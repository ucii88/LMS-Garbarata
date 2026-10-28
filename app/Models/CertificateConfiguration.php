<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateConfiguration extends Model
{
    protected $fillable = [
        'course_id',
        'template_preset',
        'instructor_id',
        'kepala_training_signature_id',
        'organization_name',
        'logo_path',
        'primary_color',
        'secondary_color',
        'updated_by_admin_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function kepalaSignature(): BelongsTo
    {
        return $this->belongsTo(Signature::class, 'kepala_training_signature_id');
    }

    public function updatedByAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_admin_id');
    }

    /**
     * Get effective kepala signature (custom or default)
     */
    public function getEffectiveKepalaSignaturePath(): string
    {
        if ($this->kepala_training_signature_id) {
            return $this->kepalaSignature->file_path;
        }
        return config('certificate.defaults.kepala_training_signature_path');
    }

    /**
     * Get effective organization name (custom or default)
     */
    public function getEffectiveOrganizationName(): string
    {
        return $this->organization_name ?? config('certificate.defaults.organization_name');
    }
}
