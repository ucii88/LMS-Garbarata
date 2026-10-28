<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'snapshot_id',
        'total_score',
        'issued_at',
        'certificate_code',
        'pdf_path',
    ];

    protected $casts = [
        'issued_at'   => 'datetime',
        'total_score' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function snapshot(): BelongsTo
    {
        return $this->belongsTo(ConfigurationSnapshot::class, 'snapshot_id');
    }

    /**
     * Get the PDF URL
     */
    public function getPdfUrlAttribute(): string
    {
        return Storage::url($this->pdf_path);
    }

    /**
     * Generate kode sertifikat unik: GRBT-XXXX-XXXX
     */
    public static function generateCode(): string
    {
        do {
            $code = 'GRBT-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
        } while (static::where('certificate_code', $code)->exists());

        return $code;
    }

    /**
     * Cek apakah user sudah menyelesaikan seluruh course,
     * lalu buat satu sertifikat jika belum ada.
     */
    public static function tryIssue(int $userId, int $courseId): ?self
    {
        $course = Course::with('chapters.modules')->find($courseId);
        if (!$course || $course->chapters->isEmpty()) return null;

        // Semua materi pada setiap chapter harus sudah diselesaikan.
        $moduleIds = $course->chapters->flatMap->modules->pluck('id');
        $completedModuleCount = \App\Models\ModuleProgress::where('user_id', $userId)
            ->whereIn('module_id', $moduleIds)
            ->distinct('module_id')
            ->count('module_id');

        if ($moduleIds->isEmpty() || $completedModuleCount < $moduleIds->count()) return null;

        // Setiap chapter wajib memiliki quiz aktif dan lulus.
        $chapterQuizzes = Quiz::where('course_id', $courseId)
            ->where('activity_type', 'quiz')
            ->where('is_active', true)
            ->whereNotNull('chapter_id')
            ->get(['id', 'chapter_id']);

        if ($chapterQuizzes->pluck('chapter_id')->unique()->count() !== $course->chapters->count()) {
            return null;
        }

        // Ujian akhir wajib tersedia, sudah dinilai penuh, dan lulus.
        $finalQuizzes = Quiz::where('course_id', $courseId)
            ->where('activity_type', 'quiz')
            ->where('is_active', true)
            ->whereNull('chapter_id')
            ->get(['id']);

        if ($finalQuizzes->isEmpty()) return null;

        $requiredQuizIds = $chapterQuizzes->pluck('id')->merge($finalQuizzes->pluck('id'));
        $passedQuizIds = QuizAttempt::where('user_id', $userId)
            ->whereIn('quiz_id', $requiredQuizIds)
            ->where('is_passed', true)
            ->whereIn('grading_status', ['auto', 'graded'])
            ->distinct('quiz_id')
            ->pluck('quiz_id');

        if ($passedQuizIds->unique()->count() < $requiredQuizIds->unique()->count()) return null;

        // Hitung rata-rata skor semua quiz yang lulus
        $avgScore = QuizAttempt::where('user_id', $userId)
            ->where('is_passed', true)
            ->whereIn('grading_status', ['auto', 'graded'])
            ->whereIn('quiz_id', $requiredQuizIds)
            ->selectRaw('AVG(score) as avg_score')
            ->value('avg_score') ?? 0;

        // Ambil snapshot terkini untuk kursus ini (nullable — tidak break jika belum ada)
        $snapshotId = null;
        try {
            $snapshotId = \App\Models\ConfigurationSnapshot::where('course_id', $courseId)
                ->orderBy('created_at', 'desc')
                ->value('id');
        } catch (\Throwable $e) {
            // Tabel snapshot mungkin belum ada — abaikan, fallback ke null
        }

        // Buat sertifikat jika belum ada
        return static::firstOrCreate(
            ['user_id' => $userId, 'course_id' => $courseId],
            [
                'total_score'      => round($avgScore, 2),
                'issued_at'        => now(),
                'certificate_code' => static::generateCode(),
                'snapshot_id'      => $snapshotId,
            ]
        );
    }
}
