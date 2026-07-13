<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Quiz extends Model
{
    protected $fillable = [
        'course_id',
        'chapter_id',
        'title',
        'description',
        'time_limit',
        'passing_score',
        'max_attempts',
        'shuffle_questions',
        'shuffle_options',
        'review_policy',
        'start_time',
        'end_time',
        'is_active',
        'order',
    ];

    protected $casts = [
        'shuffle_questions' => 'boolean',
        'shuffle_options'   => 'boolean',
        'is_active'         => 'boolean',
        'chapter_id'        => 'integer',
        'start_time'        => 'datetime',
        'end_time'          => 'datetime',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'quiz_questions')
                    ->withPivot('order')
                    ->orderBy('quiz_questions.order')
                    ->withTimestamps();
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Quiz tanpa chapter_id adalah Final Quiz (ujian akhir course).
     */
    public function isFinalQuiz(): bool
    {
        return is_null($this->chapter_id);
    }

    /**
     * Soal dari bank yang boleh dipilih untuk quiz ini.
     * - Chapter Quiz  → soal dari chapter yang sama
     * - Final Quiz    → soal dari semua chapter dalam course
     */
    public function getAvailableBankQuery()
    {
        if ($this->isFinalQuiz()) {
            return Question::where('course_id', $this->course_id);
        }

        return Question::where('chapter_id', $this->chapter_id);
    }

    /**
     * Hitung attempt user tertentu pada quiz ini.
     */
    public function attemptCountFor(int $userId): int
    {
        return $this->attempts()->where('user_id', $userId)->count();
    }

    /**
     * Apakah user boleh mencoba quiz ini lagi.
     */
    public function canAttempt(int $userId): bool
    {
        return $this->attemptCountFor($userId) < $this->max_attempts;
    }

    /**
     * Attempt terbaik (skor tertinggi) user tertentu.
     */
    public function bestAttemptFor(int $userId): ?QuizAttempt
    {
        return $this->attempts()
                    ->where('user_id', $userId)
                    ->orderByDesc('score')
                    ->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Dapatkan status ketersediaan waktu kuis berdasarkan jadwal.
     */
    public function getAvailabilityStatusAttribute(): string
    {
        $now = now();
        if ($this->start_time && $now->lt($this->start_time)) {
            return 'upcoming';
        }
        if ($this->end_time && $now->gt($this->end_time)) {
            return 'closed';
        }
        return 'open';
    }
}
