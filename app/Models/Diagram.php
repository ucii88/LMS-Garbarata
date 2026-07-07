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
        'course_id',
        'title',
        'image_path',
    ];

    /**
     * Get the course that owns the diagram.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the hotspots for the diagram.
     */
    public function hotspots(): HasMany
    {
        return $this->hasMany(Hotspot::class);
    }
}
