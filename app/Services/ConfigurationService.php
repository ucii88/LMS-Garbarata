<?php

namespace App\Services;

use App\Models\CertificateConfiguration;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfigurationService
{
    protected SnapshotService $snapshotService;

    public function __construct(SnapshotService $snapshotService)
    {
        $this->snapshotService = $snapshotService;
    }

    /**
     * Get or create configuration for course
     */
    public function getOrCreateConfiguration(Course $course): CertificateConfiguration
    {
        $config = CertificateConfiguration::where('course_id', $course->id)->first();
        
        if (!$config) {
            $config = $this->createDefaultConfiguration($course);
        }
        
        return $config;
    }

    /**
     * Update configuration and create snapshot
     */
    public function updateConfiguration(
        Course $course,
        array $data,
        User $admin
    ): CertificateConfiguration {
        return DB::transaction(function () use ($course, $data, $admin) {
            $config = $this->getOrCreateConfiguration($course);
            
            // Update configuration
            $config->fill($data);
            $config->updated_by_admin_id = $admin->id;
            $config->save();
            
            // Create immutable snapshot
            $this->snapshotService->createSnapshot($config, $admin);
            
            // Log configuration change
            $this->logConfigurationChange($config, $admin);
            
            return $config->fresh();
        });
    }

    /**
     * Validate configuration data
     */
    public function validateConfiguration(array $data): void
    {
        // Validate template preset
        $validTemplates = ['garbarata_default', 'current_style', 'elegant_classic_1'];
        if (isset($data['template_preset']) && !in_array($data['template_preset'], $validTemplates)) {
            throw new \InvalidArgumentException('Invalid template preset');
        }
        
        // Validate colors
        if (isset($data['primary_color']) && !$this->isValidHexColor($data['primary_color'])) {
            throw new \InvalidArgumentException('Invalid primary color format');
        }
        
        if (isset($data['secondary_color']) && !$this->isValidHexColor($data['secondary_color'])) {
            throw new \InvalidArgumentException('Invalid secondary color format');
        }
        
        // Validate organization name length
        if (isset($data['organization_name']) && 
            strlen($data['organization_name']) > config('certificate.validation.max_organization_name_length', 200)) {
            throw new \InvalidArgumentException('Organization name too long');
        }
    }

    /**
     * Create default configuration for course
     */
    protected function createDefaultConfiguration(Course $course): CertificateConfiguration
    {
        return CertificateConfiguration::create([
            'course_id' => $course->id,
            'template_preset' => config('certificate.defaults.template_preset', 'garbarata_default'),
            'organization_name' => config('certificate.defaults.organization_name', 'LMS Garbarata'),
            'logo_path' => config('certificate.defaults.logo_path'),
            'primary_color' => config('certificate.defaults.primary_color', '#1a56db'),
            'secondary_color' => config('certificate.defaults.secondary_color', '#9333ea'),
            'updated_by_admin_id' => auth()->id(),
        ]);
    }

    protected function isValidHexColor(string $color): bool
    {
        return preg_match('/^#[a-fA-F0-9]{6}$/', $color) === 1;
    }

    protected function logConfigurationChange(CertificateConfiguration $config, User $admin): void
    {
        Log::info('Certificate configuration updated', [
            'course_id' => $config->course_id,
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'timestamp' => now(),
        ]);
    }
}
