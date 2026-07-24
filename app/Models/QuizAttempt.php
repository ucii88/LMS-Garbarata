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
        'grading_status',
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

    /**
     * Apakah masih ada soal esai yang belum dinilai.
     */
    public function isPendingEssay(): bool
    {
        return $this->grading_status === 'pending_essay';
    }

    /**
     * Apakah semua soal esai sudah dinilai (nilai sudah final).
     */
    public function isFullyGraded(): bool
    {
        return in_array($this->grading_status, ['auto', 'graded']);
    }

    /**
     * Hitung ulang skor setelah semua soal esai dinilai.
     * Dipanggil oleh QuizController::submitGrading().
     */
    public function recalculateScore(): void
    {
        $quiz      = $this->quiz()->with('questions.options')->first();
        $answers   = $this->answers()->with('question.options')->get();

        $totalPoints  = 0;
        $earnedPoints = 0;

        foreach ($quiz->questions as $question) {
            if ($question->type === 'matching' || $question->type === 'ordering') {
                $totalPoints += $question->options->count() * $question->points;
            } else {
                $totalPoints += $question->points;
            }
        }

        foreach ($answers as $answer) {
            $earnedPoints += (float) $answer->points_earned;
        }

        // Cek apakah masih ada soal esai yang belum dinilai instruktur
        $hasUngradedEssay = $this->answers()
            ->whereHas('question', fn ($q) => $q->where('type', 'essay'))
            ->whereNull('essay_graded_at')
            ->exists();

        $score          = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100, 2) : 0;
        $isPassed       = !$hasUngradedEssay && !$quiz->isPractice() && $score >= $quiz->passing_score;
        $gradingStatus  = $hasUngradedEssay ? 'pending_essay' : 'graded';

        $this->update([
            'score'          => $score,
            'is_passed'      => $isPassed,
            'grading_status' => $gradingStatus,
        ]);

        // Terbitkan sertifikat jika sudah lulus dan tidak ada esai pending
        if ($isPassed && !$hasUngradedEssay && !$quiz->isPractice()) {
            Certificate::tryIssue($this->user_id, $quiz->course_id);
        }
    }
}

