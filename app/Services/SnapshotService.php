<?php

namespace App\Services;

use App\Models\ConfigurationSnapshot;
use App\Models\CertificateConfiguration;
use App\Models\Signature;
use App\Models\User;

class SnapshotService
{
    /**
     * Create a snapshot from current configuration
     *
     * @param CertificateConfiguration $config
     * @param User $admin
     * @return ConfigurationSnapshot
     */
    public function createSnapshot(CertificateConfiguration $config, User $admin): ConfigurationSnapshot
    {
        // Resolve current signature paths
        $instructorSignaturePath = null;
        if ($config->instructor_id) {
            $instructorSignature = Signature::where('user_id', $config->instructor_id)
                ->where('signature_type', 'instructor')
                ->latest('created_at')
                ->first();
            $instructorSignaturePath = $instructorSignature?->file_path;
        }

        $kepalaSignaturePath = null;
        if ($config->kepala_training_signature_id) {
            $kepalaSignature = Signature::find($config->kepala_training_signature_id);
            $kepalaSignaturePath = $kepalaSignature?->file_path;
        } else {
            // Use default from config if exists
            $kepalaSignaturePath = config('certificate.defaults.kepala_training_signature_path');
        }

        // Get next version number
        $version = $this->getNextVersion($config->course_id);

        // Create immutable snapshot
        return ConfigurationSnapshot::create([
            'course_id' => $config->course_id,
            'config_id' => $config->id,
            'template_preset' => $config->template_preset,
            'instructor_id' => $config->instructor_id,
            'instructor_signature_path' => $instructorSignaturePath,
            'kepala_signature_path' => $kepalaSignaturePath,
            'organization_name' => $config->organization_name ?? config('certificate.defaults.organization_name', 'LMS Garbarata'),
            'logo_path' => $config->logo_path,
            'primary_color' => $config->primary_color,
            'secondary_color' => $config->secondary_color,
            'version' => $version,
            'created_by_admin_id' => $admin->id,
        ]);
    }

    /**
     * Get current snapshot for a course
     *
     * @param int $courseId
     * @return ConfigurationSnapshot|null
     */
    public function getCurrentSnapshot(int $courseId): ?ConfigurationSnapshot
    {
        return ConfigurationSnapshot::where('course_id', $courseId)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Get snapshot at specific timestamp
     *
     * @param int $courseId
     * @param mixed $timestamp
     * @return ConfigurationSnapshot|null
     */
    public function getSnapshotAtTime(int $courseId, $timestamp): ?ConfigurationSnapshot
    {
        return ConfigurationSnapshot::getCurrentSnapshotForCourse($courseId, $timestamp);
    }

    /**
     * Calculate next version number for course
     *
     * @param int $courseId
     * @return int
     */
    private function getNextVersion(int $courseId): int
    {
        $latestSnapshot = ConfigurationSnapshot::where('course_id', $courseId)
            ->orderBy('version', 'desc')
            ->first();

        return $latestSnapshot ? $latestSnapshot->version + 1 : 1;
    }
}
