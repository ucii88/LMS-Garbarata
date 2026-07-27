<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\HasTranslations;

class QuestionOption extends Model
{
    use HasTranslations;

    protected $fillable = [
        'question_id',
        'option_text',
        'option_image',
        'is_correct',
        'match_label',
        'order',
    ];

    protected $translatable = [
        'option_text',
        'match_label',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
