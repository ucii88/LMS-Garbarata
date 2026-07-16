<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'body',
        'url',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    // ──────────────────────────────────────────────────────────────
    // Static helpers untuk membuat notifikasi
    // ──────────────────────────────────────────────────────────────

    /**
     * Kirim notif ke semua peserta saat quiz/latihan/ujian dipublish.
     */
    public static function notifyQuizPublished(Quiz $quiz): void
    {
        $type = match(true) {
            $quiz->isPractice()  => 'practice_published',
            $quiz->isFinalQuiz() => 'exam_published',
            default              => 'quiz_published',
        };

        $label = match(true) {
            $quiz->isPractice()  => 'Latihan',
            $quiz->isFinalQuiz() => 'Ujian',
            default              => 'Quiz',
        };

        $course = $quiz->course;
        $chapterInfo = $quiz->chapter ? " · {$quiz->chapter->title}" : '';

        $peserta = User::where('role', 'peserta')->pluck('id');

        $rows = $peserta->map(fn ($uid) => [
            'user_id'    => $uid,
            'type'       => $type,
            'title'      => "{$label} Baru: {$quiz->title}",
            'body'       => "{$label} baru telah dipublikasikan di {$course->title}{$chapterInfo}. Mulai sekarang!",
            'url'        => $quiz->isPractice()
                                ? route('courses.practices', $course)
                                : route('courses.quizzes', $course),
            'read_at'    => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        if (!empty($rows)) {
            static::insert($rows);
        }
    }

    /**
     * Kirim notif ke semua instruktur saat peserta submit quiz.
     */
    public static function notifySubmission(QuizAttempt $attempt, Quiz $quiz, User $peserta): void
    {
        $label = match(true) {
            $quiz->isPractice()  => 'Latihan',
            $quiz->isFinalQuiz() => 'Ujian',
            default              => 'Quiz',
        };

        $course = $quiz->course;

        $instrukturIds = User::where('role', 'instruktur')->pluck('id');

        $rows = $instrukturIds->map(fn ($uid) => [
            'user_id'    => $uid,
            'type'       => 'submission',
            'title'      => "Submission {$label}: {$quiz->title}",
            'body'       => "{$peserta->name} telah mengumpulkan {$label} \"{$quiz->title}\" di {$course->title}.",
            'url'        => route('quizzes.attempts', [$course, $quiz]),
            'read_at'    => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        if (!empty($rows)) {
            static::insert($rows);
        }
    }

    /**
     * Kirim notif ke semua admin saat pengguna baru ditambahkan.
     */
    public static function notifyUserCreated(User $newUser): void
    {
        $roleLabel = match($newUser->role) {
            'instruktur' => 'Instruktur',
            'admin'      => 'Admin',
            default      => 'Peserta',
        };

        $adminIds = User::where('role', 'admin')->pluck('id');

        $rows = $adminIds->map(fn ($uid) => [
            'user_id'    => $uid,
            'type'       => 'user_created',
            'title'      => "Pengguna Baru: {$newUser->name}",
            'body'       => "Akun {$roleLabel} baru atas nama {$newUser->name} ({$newUser->email}) telah ditambahkan.",
            'url'        => route('admin.users.index'),
            'read_at'    => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        if (!empty($rows)) {
            static::insert($rows);
        }
    }

    /**
     * Hapus notifikasi yang sudah lebih dari 30 hari.
     */
    public static function pruneOld(): void
    {
        static::where('created_at', '<', now()->subDays(30))->delete();
    }
}
