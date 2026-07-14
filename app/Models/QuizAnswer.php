<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAnswer extends Model
{
    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_option_id',
        'text_answer',
        'order_answer',
        'is_correct',
        'points_earned',
        'essay_feedback',
        'essay_graded_at',
        'essay_graded_by',
    ];

    protected $casts = [
        'is_correct'       => 'boolean',
        'order_answer'     => 'array',
        'points_earned'    => 'decimal:2',
        'essay_graded_at'  => 'datetime',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class, 'selected_option_id');
    }

    public function gradedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'essay_graded_by');
    }
}

