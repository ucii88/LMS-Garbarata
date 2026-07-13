<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_id',
        'attempt_number',
        'started_at',
        'submitted_at',
        'score',
        'is_passed',
        'time_spent',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'submitted_at' => 'datetime',
        'is_passed'    => 'boolean',
        'score'        => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class, 'attempt_id');
    }

    /**
     * Durasi pengerjaan dalam format menit:detik.
     */
    public function getDurationLabel(): string
    {
        if (!$this->time_spent) return '-';
        $min = intdiv($this->time_spent, 60);
        $sec = $this->time_spent % 60;
        return "{$min}m {$sec}s";
    }

    /**
     * Apakah attempt ini sudah di-submit.
     */
    public function isSubmitted(): bool
    {
        return !is_null($this->submitted_at);
    }
}
