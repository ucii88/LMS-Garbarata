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
        'title_en',
        'body_en',
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
            ...static::localizedContent(':label Baru: :title', ':label baru telah dipublikasikan di :target. Mulai sekarang!', [
                'label' => $label,
                'title' => $quiz->title,
                'target' => $course->title . $chapterInfo,
            ]),
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
            ...static::localizedContent('Submission :label: :title', ':name telah mengumpulkan :label ":title" di :course.', [
                'name' => $peserta->name,
                'label' => $label,
                'title' => $quiz->title,
                'course' => $course->title,
            ]),
            'url'        => route($quiz->isPractice() ? 'practices.attempts' : 'quizzes.attempts', [$course, $quiz]),
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
            ...static::localizedContent('Pengguna Baru: :name', 'Akun :role baru atas nama :name (:email) telah ditambahkan.', [
                'name' => $newUser->name,
                'role' => $roleLabel,
                'email' => $newUser->email,
            ]),
            'url'        => route('admin.users.index'),
            'read_at'    => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        if (!empty($rows)) {
            static::insert($rows);
        }
    }

    private static function localizedContent(string $title, string $body, array $replace): array
    {
        return [
            'title' => __($title, static::localizedReplace($replace, 'id'), 'id'),
            'body' => __($body, static::localizedReplace($replace, 'id'), 'id'),
            'title_en' => __($title, static::localizedReplace($replace, 'en'), 'en'),
            'body_en' => __($body, static::localizedReplace($replace, 'en'), 'en'),
        ];
    }

    private static function localizedReplace(array $replace, string $locale): array
    {
        foreach (['label', 'role'] as $key) {
            if (isset($replace[$key])) {
                $replace[$key] = __($replace[$key], [], $locale);
            }
        }

        return $replace;
    }

    /**
     * Hapus notifikasi yang sudah lebih dari 30 hari.
     */
    public static function pruneOld(): void
    {
        static::where('created_at', '<', now()->subDays(30))->delete();
    }
}

