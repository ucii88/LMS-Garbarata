<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hotspot extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagram_id',
        'target_module_id',
        'action_type',
        'label',
        'popup_title',
        'popup_content',
        'popup_image',
        'x_percent',
        'y_percent',
    ];

    protected $casts = [
        'x_percent' => 'float',
        'y_percent' => 'float',
    ];

    /**
     * Get the diagram that owns the hotspot.
     */
    public function diagram(): BelongsTo
    {
        return $this->belongsTo(Diagram::class);
    }

    /**
     * Get the target module linked to the hotspot.
     */
    public function targetModule(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'target_module_id');
    }
}
