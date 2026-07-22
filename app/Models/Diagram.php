<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diagram extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'module_id',
        'title',
        'image_path',
    ];

    /**
     * Get the chapter that owns the diagram.
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Get the module that owns the diagram.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the hotspots for the diagram.
     */
    public function hotspots(): HasMany
    {
        return $this->hasMany(Hotspot::class);
    }
}
