<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Traits\HasTranslations;

class Question extends Model
{
    use HasTranslations;

    protected $fillable = [
        'course_id',
        'chapter_id',
        'question_text',
        'question_image',
        'type',
        'points',
        'explanation',
        'topic_tag',
        'order',
    ];

    protected $translatable = [
        'question_text',
        'explanation',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class)->orderBy('order');
    }

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'quiz_questions')->withPivot('order')->withTimestamps();
    }

    /**
     * Soal yang benar untuk tipe fill_blank (opsi pertama yang is_correct).
     */
    public function correctOptions(): HasMany
    {
        return $this->hasMany(QuestionOption::class)->where('is_correct', true);
    }

    public function scopeForChapter($query, int $chapterId)
    {
        return $query->where('chapter_id', $chapterId);
    }

    public function scopeForCourse($query, int $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    /**
     * Label tipe soal yang ramah tampilan.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'multiple_choice' => 'Pilihan Ganda',
            'true_false'      => 'Benar / Salah',
            'essay'           => 'Esai',
            'matching'        => 'Menjodohkan',
            'ordering'        => 'Urutan Langkah',
            default           => $this->type,
        };
    }

    /**
     * Apakah soal ini bertipe esai (dinilai manual).
     */
    public function isEssay(): bool
    {
        return $this->type === 'essay';
    }
}
