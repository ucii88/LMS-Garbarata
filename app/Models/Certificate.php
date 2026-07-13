<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'total_score',
        'issued_at',
        'certificate_code',
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
     * Cek apakah user sudah lulus semua quiz aktif di course,
     * lalu buat sertifikat jika belum ada.
     */
    public static function tryIssue(int $userId, int $courseId): ?self
    {
        // Hitung total quiz aktif di course
        $totalQuizzes = Quiz::where('course_id', $courseId)
                            ->where('is_active', true)
                            ->count();

        if ($totalQuizzes === 0) return null;

        // Hitung quiz yang sudah lulus oleh user ini
        $passedQuizzes = QuizAttempt::where('user_id', $userId)
            ->where('is_passed', true)
            ->whereHas('quiz', fn ($q) => $q->where('course_id', $courseId)->where('is_active', true))
            ->distinct('quiz_id')
            ->count('quiz_id');

        if ($passedQuizzes < $totalQuizzes) return null;

        // Hitung rata-rata skor semua quiz yang lulus
        $avgScore = QuizAttempt::where('user_id', $userId)
            ->where('is_passed', true)
            ->whereHas('quiz', fn ($q) => $q->where('course_id', $courseId))
            ->selectRaw('AVG(score) as avg_score')
            ->value('avg_score') ?? 0;

        // Buat sertifikat jika belum ada
        return static::firstOrCreate(
            ['user_id' => $userId, 'course_id' => $courseId],
            [
                'total_score'      => round($avgScore, 2),
                'issued_at'        => now(),
                'certificate_code' => static::generateCode(),
            ]
        );
    }
}
