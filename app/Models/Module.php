<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Traits\HasTranslations;

class Module extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'chapter_id',
        'title',
        'content',
        'image_path',
        'order',
    ];

    protected $translatable = [
        'title',
        'content',
    ];

    /**
     * Get the chapter that owns the module.
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Get the hotspots targeting this module.
     */
    public function hotspots(): HasMany
    {
        return $this->hasMany(Hotspot::class, 'target_module_id');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(ModuleProgress::class);
    }
}
