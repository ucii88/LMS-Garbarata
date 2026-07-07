<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'title',
        'content',
        'order',
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
}
