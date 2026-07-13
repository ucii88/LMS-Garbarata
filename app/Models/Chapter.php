<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chapter extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'order',
    ];

    /**
     * Get the course that owns the chapter.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the modules for the chapter.
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    /**
     * Get the diagram associated with the chapter.
     */
    public function diagram(): HasOne
    {
        return $this->hasOne(Diagram::class);
    }

    /**
     * Get the quizzes assigned to this chapter.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class)->orderBy('order');
    }

    /**
     * Get the questions in the bank for this chapter.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }
}
