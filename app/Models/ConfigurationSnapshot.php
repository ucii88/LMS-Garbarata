<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfigurationSnapshot extends Model
{
    protected $fillable = [
        'course_id',
        'config_id',
        'template_preset',
        'instructor_id',
        'instructor_signature_path',
        'kepala_signature_path',
        'organization_name',
        'logo_path',
        'primary_color',
        'secondary_color',
        'version',
        'created_by_admin_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Disable updated_at timestamp
    const UPDATED_AT = null;

    /**
     * Boot method to enforce immutability
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            throw new \Exception('Configuration snapshots are immutable and cannot be updated.');
        });

        static::deleting(function ($model) {
            throw new \Exception('Configuration snapshots are immutable and cannot be deleted.');
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function configuration(): BelongsTo
    {
        return $this->belongsTo(CertificateConfiguration::class, 'config_id');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function createdByAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_admin_id');
    }

    /**
     * Get the current snapshot for a course at specific timestamp
     */
    public static function getCurrentSnapshotForCourse(int $courseId, $timestamp = null)
    {
        $query = static::where('course_id', $courseId);

        if ($timestamp) {
            $query->where('created_at', '<=', $timestamp);
        }

        return $query->orderBy('created_at', 'desc')->first();
    }
}
