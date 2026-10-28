# Design Document: Customizable Certificate System with Digital Signature

## 1. Introduction

The Customizable Certificate System with Digital Signature is a comprehensive Laravel-based solution that enables instructors and administrators to manage digital signatures and customize certificate designs for course completion certificates. The system provides role-based signature management, template presets, branding customization, and historical preservation of certificate configurations through an immutable snapshot architecture.

### 1.1 System Overview

The system is built on Laravel framework and integrates with the existing LMS-Garbarata platform. It consists of four main subsystems:

1. **Signature Management Module**: Handles digital signature capture, storage, and versioning for instructors and training heads
2. **Certificate Configuration Module**: Manages template selection, branding settings, and signature assignments per course
3. **Configuration Snapshot System**: Provides immutable historical records ensuring future-only application of design changes
4. **Certificate Generation Engine**: Produces PDF certificates using DomPDF with the appropriate configuration snapshot

### 1.2 Design Principles

- **Temporal Integrity**: Configuration changes apply only to certificates generated after the change timestamp
- **Immutability**: Previously issued certificates remain unchanged regardless of future configuration modifications
- **Role-Based Access**: Clear separation between instructor (signature management) and admin (full configuration) capabilities
- **Snapshot Architecture**: Every configuration change creates a new immutable snapshot with complete settings preservation
- **Centralized Signatures**: Instructor signatures stored in profiles and automatically applied to all assigned courses

## 2. Architecture

### 2.1 System Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                         Web Layer (Blade)                        │
├─────────────────┬───────────────────┬───────────────────────────┤
│  Instructor     │   Admin           │   Student                 │
│  Profile UI     │   Config Panel    │   Certificate View        │
└────────┬────────┴────────┬──────────┴──────────┬────────────────┘
         │                 │                     │
         ▼                 ▼                     ▼
┌─────────────────────────────────────────────────────────────────┐
│                    Controller Layer                              │
├──────────────────┬──────────────────┬───────────────────────────┤
│ ProfileController│ CertConfigCtrl   │ CertificateController     │
└────────┬─────────┴────────┬─────────┴─────────┬─────────────────┘
         │                  │                   │
         ▼                  ▼                   ▼
┌─────────────────────────────────────────────────────────────────┐
│                      Service Layer                               │
├──────────────────┬──────────────────┬───────────────────────────┤
│ SignatureService │ ConfigService    │ CertificateGenService     │
└────────┬─────────┴────────┬─────────┴─────────┬─────────────────┘
         │                  │                   │
         ▼                  ▼                   ▼
┌─────────────────────────────────────────────────────────────────┐
│                       Model Layer                                │
├───────────┬──────────────┬────────────────┬────────────────────┤
│ Signature │ CertConfig   │ ConfigSnapshot │ Certificate        │
└───────────┴──────────────┴────────────────┴────────────────────┘
```

### 2.2 Component Architecture

#### 2.2.1 Signature Management Module

**Responsibilities:**
- Capture digital signatures via Signature Pad JS library
- Store signature images with versioning support
- Manage signature files for instructors and training heads
- Provide signature retrieval by timestamp for historical certificates

**Key Components:**
- `SignatureService`: Business logic for signature operations
- `Signature` Model: Database representation of signature records
- `SignaturePad` UI Component: Canvas-based signature capture interface
- `SignatureStorage`: File system management for signature images

#### 2.2.2 Certificate Configuration Module

**Responsibilities:**
- Manage per-course certificate settings
- Handle template preset selection
- Configure branding settings (logo, organization name, colors)
- Assign instructors and Kepala Training signatures
- Provide global default settings

**Key Components:**
- `ConfigService`: Configuration management business logic
- `CertificateConfiguration` Model: Current configuration per course
- `TemplatePresetRepository`: Template definitions and layouts
- `BrandingSettings`: Value object for branding configuration

#### 2.2.3 Configuration Snapshot System

**Responsibilities:**
- Create immutable snapshots on configuration changes
- Store complete configuration state with timestamps
- Link certificates to their generation-time snapshot
- Prevent modification or deletion of historical snapshots
- Manage signature file version references

**Key Components:**
- `SnapshotService`: Snapshot creation and retrieval logic
- `ConfigurationSnapshot` Model: Immutable configuration records
- `SnapshotRepository`: Data access for snapshot queries
- `VersionManager`: Signature file version tracking

#### 2.2.4 Certificate Generation Engine

**Responsibilities:**
- Generate PDF certificates using DomPDF
- Apply template layouts to certificate content
- Incorporate signatures, branding, and student data
- Link generated certificates to configuration snapshots
- Record generation timestamps

**Key Components:**
- `CertificateGenerationService`: Certificate creation logic
- `TemplateRenderer`: Blade template rendering for certificates
- `PDFGenerator`: DomPDF wrapper for PDF creation
- `CertificateRepository`: Database operations for certificate records


## 3. Database Schema

### 3.1 Entity Relationship Diagram

```
┌──────────────┐         ┌──────────────────┐         ┌─────────────┐
│    users     │────────<│   signatures     │         │   courses   │
│              │         │                  │         │             │
│ - id         │         │ - id             │         │ - id        │
│ - name       │         │ - user_id (FK)   │         │ - name      │
│ - role       │         │ - file_path      │         │             │
└──────────────┘         │ - file_name      │         └──────┬──────┘
                         │ - signature_type │                │
                         │ - created_at     │                │
                         │ - updated_at     │                │
                         └──────────────────┘                │
                                                             │
                                                             │
┌────────────────────────────────────────────────────────────┼────┐
│                    certificate_configurations              │    │
│                                                            │    │
│ - id                                                       │    │
│ - course_id (FK) ──────────────────────────────────────────────┘
│ - template_preset (enum)                                   │
│ - instructor_id (FK) ──────────────────┐                   │
│ - kepala_training_signature_id (FK)    │                   │
│ - organization_name                    │                   │
│ - logo_path                            │                   │
│ - primary_color                        │                   │
│ - secondary_color                      │                   │
│ - created_at                           │                   │
│ - updated_at                           │                   │
│ - updated_by_admin_id (FK)             │                   │
└────────────────┬───────────────────────┼───────────────────┘
                 │                       │
                 │                       └───────────────┐
                 ▼                                       │
┌────────────────────────────────────┐                  │
│   configuration_snapshots          │                  │
│                                    │                  │
│ - id                               │                  │
│ - course_id (FK)                   │                  │
│ - config_id (FK)                   │                  │
│ - template_preset                  │                  │
│ - instructor_id (FK) ───────────────────────────────────────┐
│ - instructor_signature_path        │                  │    │
│ - kepala_signature_path            │                  │    │
│ - organization_name                │                  │    │
│ - logo_path                        │                  │    │
│ - primary_color                    │                  │    │
│ - secondary_color                  │                  │    │
│ - version                          │                  │    │
│ - created_at (immutable timestamp) │                  │    │
│ - created_by_admin_id (FK)         │                  │    │
└────────────────┬───────────────────┘                  │    │
                 │                                      │    │
                 │                                      │    │
                 ▼                                      ▼    ▼
┌──────────────────────────────────────────────────────────────┐
│                      certificates                            │
│                                                              │
│ - id                                                         │
│ - user_id (FK) ──> users.id (student)                       │
│ - course_id (FK)                                            │
│ - snapshot_id (FK) ──> configuration_snapshots.id           │
│ - total_score                                               │
│ - certificate_code (unique)                                 │
│ - issued_at (generation timestamp)                          │
│ - pdf_path                                                  │
│ - created_at                                                │
└──────────────────────────────────────────────────────────────┘
```


### 3.2 Table Definitions

#### 3.2.1 signatures

Stores digital signature information for instructors and training heads.

```sql
CREATE TABLE signatures (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    file_path VARCHAR(500) NOT NULL COMMENT 'Storage path to signature image',
    file_name VARCHAR(255) NOT NULL COMMENT 'Original filename',
    signature_type ENUM('instructor', 'kepala_training') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_type (user_id, signature_type),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Notes:**
- Versioning achieved through temporal queries using `created_at` timestamp
- Old signature records preserved when updated (soft versioning)
- File path stores versioned filename to prevent file conflicts

#### 3.2.2 certificate_configurations

Stores current certificate configuration for each course.

```sql
CREATE TABLE certificate_configurations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id BIGINT UNSIGNED NOT NULL UNIQUE COMMENT 'One config per course',
    template_preset ENUM('current_style', 'elegant_classic_1', 'elegant_classic_2') 
        NOT NULL DEFAULT 'current_style',
    instructor_id BIGINT UNSIGNED NULL COMMENT 'Assigned instructor for signatures',
    kepala_training_signature_id BIGINT UNSIGNED NULL COMMENT 'Custom kepala signature',
    organization_name VARCHAR(200) NOT NULL DEFAULT 'LMS Garbarata',
    logo_path VARCHAR(500) NULL COMMENT 'Custom logo for this course',
    primary_color VARCHAR(7) NOT NULL DEFAULT '#1a56db' COMMENT 'Hex color',
    secondary_color VARCHAR(7) NOT NULL DEFAULT '#9333ea' COMMENT 'Hex color',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by_admin_id BIGINT UNSIGNED NOT NULL COMMENT 'Admin who made last change',
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (instructor_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (kepala_training_signature_id) REFERENCES signatures(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by_admin_id) REFERENCES users(id),
    
    INDEX idx_course (course_id),
    INDEX idx_instructor (instructor_id),
    INDEX idx_updated_at (updated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Notes:**
- Single record per course (enforced by UNIQUE constraint on course_id)
- NULL instructor_id means no instructor assigned
- NULL kepala_training_signature_id means use global default
- Updated_by_admin_id tracks who made the change for audit trail


#### 3.2.3 configuration_snapshots

Immutable historical records of certificate configurations.

```sql
CREATE TABLE configuration_snapshots (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id BIGINT UNSIGNED NOT NULL,
    config_id BIGINT UNSIGNED NOT NULL COMMENT 'Source configuration record',
    template_preset ENUM('current_style', 'elegant_classic_1', 'elegant_classic_2') NOT NULL,
    instructor_id BIGINT UNSIGNED NULL COMMENT 'Assigned instructor at snapshot time',
    instructor_signature_path VARCHAR(500) NULL COMMENT 'Signature file path at snapshot time',
    kepala_signature_path VARCHAR(500) NULL COMMENT 'Kepala signature file path',
    organization_name VARCHAR(200) NOT NULL,
    logo_path VARCHAR(500) NULL,
    primary_color VARCHAR(7) NOT NULL,
    secondary_color VARCHAR(7) NOT NULL,
    version INT UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Snapshot version number',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Immutable timestamp',
    created_by_admin_id BIGINT UNSIGNED NOT NULL,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE RESTRICT,
    FOREIGN KEY (config_id) REFERENCES certificate_configurations(id) ON DELETE RESTRICT,
    FOREIGN KEY (instructor_id) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (created_by_admin_id) REFERENCES users(id) ON DELETE RESTRICT,
    
    INDEX idx_course_created (course_id, created_at),
    INDEX idx_config (config_id),
    INDEX idx_created_at (created_at),
    UNIQUE KEY unique_course_version (course_id, version)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Notes:**
- Immutable records (no UPDATE operations allowed)
- ON DELETE RESTRICT prevents deletion of referenced records
- Stores file paths (not IDs) to capture signature version at snapshot time
- Version number auto-increments per course for tracking
- Created_at timestamp is the authoritative time for certificate generation

#### 3.2.4 certificates (modification to existing table)

Modified existing certificates table to include snapshot reference.

```sql
ALTER TABLE certificates 
ADD COLUMN snapshot_id BIGINT UNSIGNED NULL AFTER course_id,
ADD FOREIGN KEY (snapshot_id) REFERENCES configuration_snapshots(id) ON DELETE RESTRICT,
ADD INDEX idx_snapshot (snapshot_id),
ADD INDEX idx_issued_at (issued_at);
```

**Notes:**
- Snapshot_id links certificate to its generation-time configuration
- NULL snapshot_id for legacy certificates generated before system implementation
- ON DELETE RESTRICT prevents accidental snapshot deletion
- Issued_at indexed for temporal queries


### 3.3 Global Settings

Global default settings stored in Laravel config or dedicated settings table.

```php
// config/certificate.php
return [
    'defaults' => [
        'organization_name' => 'LMS Garbarata',
        'logo_path' => 'images/default-logo.png',
        'primary_color' => '#1a56db',
        'secondary_color' => '#9333ea',
        'template_preset' => 'current_style',
        'kepala_training_signature_path' => 'signatures/default-kepala.png',
    ],
    'validation' => [
        'max_file_size_mb' => 5,
        'allowed_logo_formats' => ['png', 'jpg', 'jpeg', 'svg'],
        'min_logo_dimensions' => [100, 100],
        'max_logo_dimensions' => [2000, 2000],
        'max_organization_name_length' => 200,
    ],
    'performance' => [
        'signature_save_timeout_seconds' => 3,
        'certificate_generation_timeout_seconds' => 10,
        'snapshot_retrieval_timeout_seconds' => 2,
    ],
];
```

## 4. Data Models

### 4.1 Eloquent Models

#### 4.1.1 Signature Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Signature extends Model
{
    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'signature_type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full URL to the signature image
     */
    public function getSignatureUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get signature version at specific timestamp
     */
    public static function getVersionAtTime(int $userId, string $type, $timestamp)
    {
        return static::where('user_id', $userId)
            ->where('signature_type', $type)
            ->where('created_at', '<=', $timestamp)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
```


#### 4.1.2 CertificateConfiguration Model

```php
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
```


#### 4.1.3 ConfigurationSnapshot Model

```php
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

    // Disable update and delete operations to enforce immutability
    public static function boot()
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
```


#### 4.1.4 Certificate Model (enhanced)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'snapshot_id',
        'total_score',
        'certificate_code',
        'issued_at',
        'pdf_path',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function snapshot(): BelongsTo
    {
        return $this->belongsTo(ConfigurationSnapshot::class, 'snapshot_id');
    }

    /**
     * Get the PDF URL
     */
    public function getPdfUrlAttribute(): string
    {
        return Storage::url($this->pdf_path);
    }

    /**
     * Generate unique certificate code
     */
    public static function generateCertificateCode(): string
    {
        do {
            $code = 'CERT-' . strtoupper(Str::random(8)) . '-' . date('Y');
        } while (static::where('certificate_code', $code)->exists());
        
        return $code;
    }
}
```

## 5. Services and Business Logic

### 5.1 SignatureService

Handles all signature-related operations including capture, storage, and versioning.

```php
<?php

namespace App\Services;

use App\Models\Signature;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SignatureService
{
    /**
     * Save signature from canvas data (base64)
     */
    public function saveFromCanvas(User $user, string $base64Data, string $type): Signature
    {
        // Validate signature type
        if (!in_array($type, ['instructor', 'kepala_training'])) {
            throw new \InvalidArgumentException('Invalid signature type');
        }

        // Decode base64 image
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Data));
        
        // Generate unique filename with timestamp for versioning
        $filename = sprintf(
            '%s_%s_%s.png',
            $type,
            $user->id,
            now()->timestamp
        );
        
        $path = "signatures/{$filename}";
        
        // Store with lossless compression
        Storage::put($path, $imageData);
        
        // Create signature record
        return Signature::create([
            'user_id' => $user->id,
            'file_path' => $path,
            'file_name' => $filename,
            'signature_type' => $type,
        ]);
    }

    /**
     * Save signature from uploaded file
     */
    public function saveFromFile(User $user, UploadedFile $file, string $type): Signature
    {
        // Validate file
        $this->validateSignatureFile($file);
        
        // Generate unique filename with timestamp
        $filename = sprintf(
            '%s_%s_%s.%s',
            $type,
            $user->id,
            now()->timestamp,
            $file->getClientOriginalExtension()
        );
        
        $path = $file->storeAs('signatures', $filename);
        
        return Signature::create([
            'user_id' => $user->id,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'signature_type' => $type,
        ]);
    }

    /**
     * Get current signature for user
     */
    public function getCurrentSignature(User $user, string $type): ?Signature
    {
        return Signature::where('user_id', $user->id)
            ->where('signature_type', $type)
            ->latest('created_at')
            ->first();
    }

    /**
     * Get signature at specific timestamp (for historical certificates)
     */
    public function getSignatureAtTime(int $userId, string $type, $timestamp): ?Signature
    {
        return Signature::getVersionAtTime($userId, $type, $timestamp);
    }

    /**
     * Validate signature file
     */
    protected function validateSignatureFile(UploadedFile $file): void
    {
        $maxSize = config('certificate.validation.max_file_size_mb') * 1024;
        
        if ($file->getSize() > $maxSize * 1024) {
            throw new \InvalidArgumentException('File size exceeds maximum allowed size');
        }
        
        $allowedMimes = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \InvalidArgumentException('Invalid file format');
        }
    }
}
```


### 5.2 ConfigurationService

Manages certificate configuration with snapshot creation.

```php
<?php

namespace App\Services;

use App\Models\CertificateConfiguration;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
     * Create default configuration for course
     */
    protected function createDefaultConfiguration(Course $course): CertificateConfiguration
    {
        return CertificateConfiguration::create([
            'course_id' => $course->id,
            'template_preset' => config('certificate.defaults.template_preset'),
            'organization_name' => config('certificate.defaults.organization_name'),
            'logo_path' => config('certificate.defaults.logo_path'),
            'primary_color' => config('certificate.defaults.primary_color'),
            'secondary_color' => config('certificate.defaults.secondary_color'),
            'updated_by_admin_id' => auth()->id(),
        ]);
    }

    /**
     * Validate configuration data
     */
    public function validateConfiguration(array $data): void
    {
        // Validate template preset
        $validTemplates = ['current_style', 'elegant_classic_1', 'elegant_classic_2'];
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
            strlen($data['organization_name']) > config('certificate.validation.max_organization_name_length')) {
            throw new \InvalidArgumentException('Organization name too long');
        }
    }

    protected function isValidHexColor(string $color): bool
    {
        return preg_match('/^#[a-fA-F0-9]{6}$/', $color);
    }

    protected function logConfigurationChange(CertificateConfiguration $config, User $admin): void
    {
        \Log::info('Certificate configuration updated', [
            'course_id' => $config->course_id,
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'timestamp' => now(),
        ]);
    }
}
```


### 5.3 SnapshotService

Creates and manages immutable configuration snapshots.

```php
<?php

namespace App\Services;

use App\Models\CertificateConfiguration;
use App\Models\ConfigurationSnapshot;
use App\Models\User;
use App\Models\Signature;

class SnapshotService
{
    /**
     * Create immutable configuration snapshot
     */
    public function createSnapshot(
        CertificateConfiguration $config,
        User $admin
    ): ConfigurationSnapshot {
        // Get current version number
        $version = $this->getNextVersion($config->course_id);
        
        // Resolve signature paths at current time
        $instructorSignaturePath = null;
        if ($config->instructor_id) {
            $signature = Signature::where('user_id', $config->instructor_id)
                ->where('signature_type', 'instructor')
                ->latest('created_at')
                ->first();
            $instructorSignaturePath = $signature?->file_path;
        }
        
        $kepalaSignaturePath = $config->getEffectiveKepalaSignaturePath();
        
        // Create immutable snapshot
        return ConfigurationSnapshot::create([
            'course_id' => $config->course_id,
            'config_id' => $config->id,
            'template_preset' => $config->template_preset,
            'instructor_id' => $config->instructor_id,
            'instructor_signature_path' => $instructorSignaturePath,
            'kepala_signature_path' => $kepalaSignaturePath,
            'organization_name' => $config->organization_name,
            'logo_path' => $config->logo_path,
            'primary_color' => $config->primary_color,
            'secondary_color' => $config->secondary_color,
            'version' => $version,
            'created_by_admin_id' => $admin->id,
        ]);
    }

    /**
     * Get snapshot for certificate generation
     */
    public function getCurrentSnapshot(int $courseId): ?ConfigurationSnapshot
    {
        return ConfigurationSnapshot::getCurrentSnapshotForCourse($courseId);
    }

    /**
     * Get snapshot at specific timestamp (for historical certificates)
     */
    public function getSnapshotAtTime(int $courseId, $timestamp): ?ConfigurationSnapshot
    {
        return ConfigurationSnapshot::getCurrentSnapshotForCourse($courseId, $timestamp);
    }

    /**
     * Get next version number for course
     */
    protected function getNextVersion(int $courseId): int
    {
        $lastSnapshot = ConfigurationSnapshot::where('course_id', $courseId)
            ->orderBy('version', 'desc')
            ->first();
        
        return $lastSnapshot ? $lastSnapshot->version + 1 : 1;
    }
}
```


### 5.4 CertificateGenerationService

Generates PDF certificates with configuration snapshots.

```php
<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\User;
use App\Models\Course;
use App\Models\ConfigurationSnapshot;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CertificateGenerationService
{
    protected SnapshotService $snapshotService;

    public function __construct(SnapshotService $snapshotService)
    {
        $this->snapshotService = $snapshotService;
    }

    /**
     * Generate certificate for student course completion
     */
    public function generateCertificate(
        User $student,
        Course $course,
        float $totalScore
    ): Certificate {
        // Get current configuration snapshot
        $snapshot = $this->snapshotService->getCurrentSnapshot($course->id);
        
        if (!$snapshot) {
            throw new \Exception('No configuration snapshot found for course');
        }
        
        // Validate instructor signature exists
        if ($snapshot->instructor_id && !$snapshot->instructor_signature_path) {
            \Log::error('Instructor signature missing', [
                'course_id' => $course->id,
                'instructor_id' => $snapshot->instructor_id,
            ]);
            throw new \Exception('Instructor signature not available');
        }
        
        // Generate unique certificate code
        $certificateCode = Certificate::generateCertificateCode();
        
        // Prepare certificate data
        $data = $this->prepareCertificateData($student, $course, $totalScore, $snapshot);
        
        // Generate PDF
        $pdfPath = $this->generatePDF($data, $snapshot, $certificateCode);
        
        // Create certificate record
        return Certificate::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'snapshot_id' => $snapshot->id,
            'total_score' => $totalScore,
            'certificate_code' => $certificateCode,
            'issued_at' => now(),
            'pdf_path' => $pdfPath,
        ]);
    }

    /**
     * Prepare data for certificate rendering
     */
    protected function prepareCertificateData(
        User $student,
        Course $course,
        float $totalScore,
        ConfigurationSnapshot $snapshot
    ): array {
        return [
            'student_name' => $student->name,
            'course_name' => $course->name,
            'total_score' => $totalScore,
            'issued_date' => now()->format('d F Y'),
            'organization_name' => $snapshot->organization_name,
            'logo_path' => $snapshot->logo_path,
            'instructor_name' => $snapshot->instructor?->name,
            'instructor_signature_url' => $snapshot->instructor_signature_path 
                ? Storage::url($snapshot->instructor_signature_path) 
                : null,
            'kepala_signature_url' => Storage::url($snapshot->kepala_signature_path),
            'primary_color' => $snapshot->primary_color,
            'secondary_color' => $snapshot->secondary_color,
        ];
    }

    /**
     * Generate PDF file
     */
    protected function generatePDF(
        array $data,
        ConfigurationSnapshot $snapshot,
        string $certificateCode
    ): string {
        // Select template blade view based on preset
        $templateView = $this->getTemplateView($snapshot->template_preset);
        
        // Generate PDF using DomPDF
        $pdf = Pdf::loadView($templateView, $data)
            ->setPaper('a4', 'landscape');
        
        // Store PDF
        $filename = "certificate_{$certificateCode}.pdf";
        $path = "certificates/{$filename}";
        
        Storage::put($path, $pdf->output());
        
        return $path;
    }

    /**
     * Get blade template view for preset
     */
    protected function getTemplateView(string $preset): string
    {
        return match($preset) {
            'current_style' => 'certificates.templates.current-style',
            'elegant_classic_1' => 'certificates.templates.elegant-classic-1',
            'elegant_classic_2' => 'certificates.templates.elegant-classic-2',
            default => 'certificates.templates.current-style',
        };
    }
}
```


## 6. API Endpoints and Controllers

### 6.1 Instructor Profile Signature Management

#### 6.1.1 ProfileController

```php
<?php

namespace App\Http\Controllers;

use App\Services\SignatureService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected SignatureService $signatureService;

    public function __construct(SignatureService $signatureService)
    {
        $this->signatureService = $signatureService;
    }

    /**
     * Display instructor profile with signature
     * GET /profile
     */
    public function show()
    {
        $user = auth()->user();
        $signature = $this->signatureService->getCurrentSignature($user, 'instructor');
        $courses = $user->role === 'instructor' ? $user->assignedCourses : [];
        
        return view('profile.show', compact('user', 'signature', 'courses'));
    }

    /**
     * Save signature from canvas
     * POST /profile/signature
     */
    public function saveSignature(Request $request)
    {
        $request->validate([
            'signature_data' => 'required|string',
        ]);

        try {
            $signature = $this->signatureService->saveFromCanvas(
                auth()->user(),
                $request->signature_data,
                'instructor'
            );

            return response()->json([
                'success' => true,
                'message' => 'Signature saved successfully',
                'signature_url' => $signature->signature_url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Upload signature from file
     * POST /profile/signature/upload
     */
    public function uploadSignature(Request $request)
    {
        $request->validate([
            'signature_file' => 'required|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        try {
            $signature = $this->signatureService->saveFromFile(
                auth()->user(),
                $request->file('signature_file'),
                'instructor'
            );

            return redirect()->back()->with('success', 'Signature uploaded successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
```


### 6.2 Admin Certificate Configuration

#### 6.2.1 CertificateConfigurationController

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ConfigurationService;
use App\Services\SignatureService;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CertificateConfigurationController extends Controller
{
    protected ConfigurationService $configService;
    protected SignatureService $signatureService;

    public function __construct(
        ConfigurationService $configService,
        SignatureService $signatureService
    ) {
        $this->middleware(['auth', 'admin']);
        $this->configService = $configService;
        $this->signatureService = $signatureService;
    }

    /**
     * Show configuration panel for course
     * GET /admin/courses/{course}/certificate-config
     */
    public function show(Course $course)
    {
        $config = $this->configService->getOrCreateConfiguration($course);
        $instructors = User::where('role', 'instructor')->get();
        $templates = $this->getTemplatePresets();
        
        return view('admin.certificate-config.show', compact(
            'course',
            'config',
            'instructors',
            'templates'
        ));
    }

    /**
     * Update certificate configuration
     * POST /admin/courses/{course}/certificate-config
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'template_preset' => 'required|in:current_style,elegant_classic_1,elegant_classic_2',
            'instructor_id' => 'nullable|exists:users,id',
            'kepala_training_signature_id' => 'nullable|exists:signatures,id',
            'organization_name' => 'required|string|max:200',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5120',
            'primary_color' => 'required|regex:/^#[a-fA-F0-9]{6}$/',
            'secondary_color' => 'required|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        try {
            // Validate configuration data
            $this->configService->validateConfiguration($validated);
            
            // Handle logo upload if present
            if ($request->hasFile('logo')) {
                $validated['logo_path'] = $this->uploadLogo($request->file('logo'));
            }
            
            // Update configuration and create snapshot
            $config = $this->configService->updateConfiguration(
                $course,
                $validated,
                auth()->user()
            );

            return redirect()
                ->route('admin.certificate-config.show', $course)
                ->with('success', 'Certificate configuration updated successfully');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Preview certificate with current settings
     * GET /admin/courses/{course}/certificate-config/preview
     */
    public function preview(Course $course, Request $request)
    {
        $config = $this->configService->getOrCreateConfiguration($course);
        
        // Prepare preview data with sample values
        $data = [
            'student_name' => 'John Doe',
            'course_name' => $course->name,
            'total_score' => 95.5,
            'issued_date' => now()->format('d F Y'),
            'organization_name' => $config->organization_name,
            'logo_path' => $config->logo_path,
            'instructor_name' => $config->instructor?->name ?? 'Instructor Name',
            'instructor_signature_url' => $config->instructor 
                ? $this->signatureService->getCurrentSignature($config->instructor, 'instructor')?->signature_url
                : null,
            'kepala_signature_url' => Storage::url($config->getEffectiveKepalaSignaturePath()),
            'primary_color' => $config->primary_color,
            'secondary_color' => $config->secondary_color,
        ];
        
        $templateView = $this->getTemplateView($config->template_preset);
        
        return view($templateView, $data);
    }

    /**
     * Upload logo file
     */
    protected function uploadLogo($file): string
    {
        $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('logos', $filename);
    }

    /**
     * Get available template presets
     */
    protected function getTemplatePresets(): array
    {
        return [
            'current_style' => [
                'name' => 'Current Style',
                'description' => 'Maintains the existing certificate design format',
                'preview_image' => asset('images/templates/current-style-preview.png'),
            ],
            'elegant_classic_1' => [
                'name' => 'Elegant Classic 1',
                'description' => 'Formal certificate layout with decorative borders',
                'preview_image' => asset('images/templates/elegant-classic-1-preview.png'),
            ],
            'elegant_classic_2' => [
                'name' => 'Elegant Classic 2',
                'description' => 'Alternative elegant layout with different typography',
                'preview_image' => asset('images/templates/elegant-classic-2-preview.png'),
            ],
        ];
    }

    protected function getTemplateView(string $preset): string
    {
        return match($preset) {
            'current_style' => 'certificates.templates.current-style',
            'elegant_classic_1' => 'certificates.templates.elegant-classic-1',
            'elegant_classic_2' => 'certificates.templates.elegant-classic-2',
            default => 'certificates.templates.current-style',
        };
    }
}
```


### 6.3 Certificate Generation Endpoint

#### 6.3.1 CertificateController (enhanced)

```php
<?php

namespace App\Http\Controllers;

use App\Services\CertificateGenerationService;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    protected CertificateGenerationService $generationService;

    public function __construct(CertificateGenerationService $generationService)
    {
        $this->generationService = $generationService;
    }

    /**
     * Generate certificate for student
     * POST /certificates/generate
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'total_score' => 'required|numeric|min:0|max:100',
        ]);

        try {
            $student = User::findOrFail($validated['student_id']);
            $course = Course::findOrFail($validated['course_id']);
            
            $certificate = $this->generationService->generateCertificate(
                $student,
                $course,
                $validated['total_score']
            );

            return response()->json([
                'success' => true,
                'message' => 'Certificate generated successfully',
                'certificate_code' => $certificate->certificate_code,
                'pdf_url' => $certificate->pdf_url,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * View certificate PDF
     * GET /certificates/{certificate}
     */
    public function show(Certificate $certificate)
    {
        // Authorization check
        if (auth()->id() !== $certificate->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        
        return response()->file(storage_path('app/' . $certificate->pdf_path));
    }

    /**
     * Download certificate PDF
     * GET /certificates/{certificate}/download
     */
    public function download(Certificate $certificate)
    {
        // Authorization check
        if (auth()->id() !== $certificate->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        
        return response()->download(
            storage_path('app/' . $certificate->pdf_path),
            "certificate_{$certificate->certificate_code}.pdf"
        );
    }

    /**
     * Verify certificate by code
     * GET /certificates/verify/{code}
     */
    public function verify(string $code)
    {
        $certificate = Certificate::where('certificate_code', $code)->first();
        
        if (!$certificate) {
            return view('certificates.verify', [
                'valid' => false,
                'message' => 'Certificate not found',
            ]);
        }
        
        return view('certificates.verify', [
            'valid' => true,
            'certificate' => $certificate,
            'student' => $certificate->user,
            'course' => $certificate->course,
        ]);
    }
}
```


### 6.4 Route Definitions

```php
<?php

// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Admin\CertificateConfigurationController;

// Instructor Profile Signature Management
Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/signature', [ProfileController::class, 'saveSignature'])->name('profile.signature.save');
    Route::post('/profile/signature/upload', [ProfileController::class, 'uploadSignature'])->name('profile.signature.upload');
});

// Admin Certificate Configuration
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/courses/{course}/certificate-config', [CertificateConfigurationController::class, 'show'])
        ->name('certificate-config.show');
    Route::post('/courses/{course}/certificate-config', [CertificateConfigurationController::class, 'update'])
        ->name('certificate-config.update');
    Route::get('/courses/{course}/certificate-config/preview', [CertificateConfigurationController::class, 'preview'])
        ->name('certificate-config.preview');
});

// Certificate Generation and Viewing
Route::middleware(['auth'])->group(function () {
    Route::post('/certificates/generate', [CertificateController::class, 'generate'])
        ->name('certificates.generate');
    Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])
        ->name('certificates.show');
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])
        ->name('certificates.download');
});

// Public Certificate Verification
Route::get('/certificates/verify/{code}', [CertificateController::class, 'verify'])
    ->name('certificates.verify');
```

## 7. User Interface Components

### 7.1 Instructor Profile Signature Section

#### 7.1.1 Blade Template (resources/views/profile/show.blade.php)

```blade
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Instructor Profile</h1>
    
    <!-- Profile Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-gray-600">Name:</label>
                <p class="font-medium">{{ $user->name }}</p>
            </div>
            <div>
                <label class="text-gray-600">Email:</label>
                <p class="font-medium">{{ $user->email }}</p>
            </div>
        </div>
    </div>
    
    <!-- Digital Signature Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Digital Signature</h2>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <p class="text-gray-600 mb-4">
            Your digital signature will be used on certificates for courses you teach. 
            You can draw your signature using your mouse or touchscreen, or upload an image.
        </p>
        
        <!-- Current Signature Preview -->
        @if($signature)
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Current Signature:</h3>
                <div class="border-2 border-gray-300 rounded p-4 bg-gray-50 inline-block">
                    <img src="{{ $signature->signature_url }}" alt="Current Signature" class="max-h-32">
                </div>
            </div>
        @endif
        
        <!-- Signature Canvas -->
        <div class="mb-4">
            <h3 class="font-semibold mb-2">Draw Your Signature:</h3>
            <canvas id="signature-pad" class="border-2 border-gray-300 rounded" width="600" height="200"></canvas>
            <div class="mt-2 flex gap-2">
                <button id="clear-btn" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Clear
                </button>
                <button id="save-btn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save Signature
                </button>
            </div>
        </div>
        
        <!-- File Upload Alternative -->
        <div class="border-t pt-4 mt-4">
            <h3 class="font-semibold mb-2">Or Upload Signature Image:</h3>
            <form action="{{ route('profile.signature.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="signature_file" accept="image/png,image/jpeg,image/jpg" 
                       class="border rounded px-3 py-2 mb-2" required>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Upload
                </button>
                <p class="text-sm text-gray-500 mt-2">
                    Accepted formats: PNG, JPG, JPEG. Max size: 5MB
                </p>
            </form>
        </div>
    </div>
    
    <!-- Courses Using This Signature -->
    @if(count($courses) > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Courses Using Your Signature</h2>
            <ul class="list-disc list-inside">
                @foreach($courses as $course)
                    <li class="text-gray-700">{{ $course->name }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)'
    });
    
    document.getElementById('clear-btn').addEventListener('click', () => {
        signaturePad.clear();
    });
    
    document.getElementById('save-btn').addEventListener('click', async () => {
        if (signaturePad.isEmpty()) {
            alert('Please provide a signature first');
            return;
        }
        
        const dataURL = signaturePad.toDataURL();
        
        try {
            const response = await fetch('{{ route("profile.signature.save") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    signature_data: dataURL
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Signature saved successfully!');
                window.location.reload();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            alert('Error saving signature');
        }
    });
</script>
@endpush
@endsection
```


### 7.2 Admin Certificate Configuration Panel

#### 7.2.1 Blade Template (resources/views/admin/certificate-config/show.blade.php)

```blade
@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Certificate Configuration: {{ $course->name }}</h1>
        <a href="{{ route('admin.certificate-config.preview', $course) }}" 
           target="_blank"
           class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
            Preview Certificate
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    
    <form action="{{ route('admin.certificate-config.update', $course) }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        
        <!-- Template Selection Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Template Selection</h2>
            <div class="grid grid-cols-3 gap-4">
                @foreach($templates as $key => $template)
                    <label class="cursor-pointer">
                        <input type="radio" 
                               name="template_preset" 
                               value="{{ $key }}" 
                               {{ $config->template_preset === $key ? 'checked' : '' }}
                               class="hidden peer"
                               required>
                        <div class="border-2 rounded-lg p-4 peer-checked:border-blue-600 peer-checked:bg-blue-50 hover:border-blue-400 transition">
                            <img src="{{ $template['preview_image'] }}" 
                                 alt="{{ $template['name'] }}" 
                                 class="w-full h-32 object-cover rounded mb-2">
                            <h3 class="font-semibold">{{ $template['name'] }}</h3>
                            <p class="text-sm text-gray-600">{{ $template['description'] }}</p>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>
        
        <!-- Signature Assignment Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Signature Assignment</h2>
            
            <div class="grid grid-cols-2 gap-6">
                <!-- Instructor Signature -->
                <div>
                    <label class="block font-medium mb-2">Instructor <span class="text-red-500">*</span></label>
                    <select name="instructor_id" 
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <option value="">Select Instructor</option>
                        @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}" 
                                    {{ $config->instructor_id === $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">
                        Instructor's signature from their profile will be used
                    </p>
                </div>
                
                <!-- Kepala Training Signature -->
                <div>
                    <label class="block font-medium mb-2">Kepala Training Signature</label>
                    <select name="kepala_training_signature_id" 
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Use Global Default</option>
                        <!-- Populate with available kepala signatures -->
                    </select>
                    <p class="text-sm text-gray-500 mt-1">
                        Leave empty to use system default
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Branding Settings Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Branding Settings</h2>
            
            <div class="space-y-4">
                <!-- Organization Name -->
                <div>
                    <label class="block font-medium mb-2">Organization Name <span class="text-red-500">*</span></label>
                    <input type="text" 
                           name="organization_name" 
                           value="{{ $config->organization_name }}"
                           maxlength="200"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('organization_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Logo Upload -->
                <div>
                    <label class="block font-medium mb-2">Organization Logo</label>
                    @if($config->logo_path)
                        <div class="mb-2">
                            <p class="text-sm text-gray-600 mb-1">Current Logo:</p>
                            <img src="{{ Storage::url($config->logo_path) }}" 
                                 alt="Logo" 
                                 class="max-h-24 border rounded">
                        </div>
                    @endif
                    <input type="file" 
                           name="logo" 
                           accept="image/png,image/jpeg,image/jpg,image/svg+xml"
                           class="border rounded px-3 py-2">
                    <p class="text-sm text-gray-500 mt-1">
                        Formats: PNG, JPG, SVG. Max size: 5MB. Recommended: 100x100 to 2000x2000 pixels
                    </p>
                </div>
                
                <!-- Color Settings -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium mb-2">Primary Color <span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <input type="color" 
                                   name="primary_color" 
                                   value="{{ $config->primary_color }}"
                                   class="h-10 w-20 border rounded cursor-pointer"
                                   required>
                            <input type="text" 
                                   name="primary_color_text" 
                                   value="{{ $config->primary_color }}"
                                   pattern="^#[a-fA-F0-9]{6}$"
                                   class="flex-1 border rounded px-3 py-2 font-mono"
                                   required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block font-medium mb-2">Secondary Color <span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <input type="color" 
                                   name="secondary_color" 
                                   value="{{ $config->secondary_color }}"
                                   class="h-10 w-20 border rounded cursor-pointer"
                                   required>
                            <input type="text" 
                                   name="secondary_color_text" 
                                   value="{{ $config->secondary_color }}"
                                   pattern="^#[a-fA-F0-9]{6}$"
                                   class="flex-1 border rounded px-3 py-2 font-mono"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.courses.index') }}" 
               class="px-6 py-3 border border-gray-300 rounded hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">
                Save Configuration
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Sync color picker with hex input
    const primaryColor = document.querySelector('input[name="primary_color"]');
    const primaryColorText = document.querySelector('input[name="primary_color_text"]');
    const secondaryColor = document.querySelector('input[name="secondary_color"]');
    const secondaryColorText = document.querySelector('input[name="secondary_color_text"]');
    
    primaryColor.addEventListener('input', (e) => {
        primaryColorText.value = e.target.value;
    });
    
    primaryColorText.addEventListener('input', (e) => {
        if (/^#[a-fA-F0-9]{6}$/.test(e.target.value)) {
            primaryColor.value = e.target.value;
        }
    });
    
    secondaryColor.addEventListener('input', (e) => {
        secondaryColorText.value = e.target.value;
    });
    
    secondaryColorText.addEventListener('input', (e) => {
        if (/^#[a-fA-F0-9]{6}$/.test(e.target.value)) {
            secondaryColor.value = e.target.value;
        }
    });
</script>
@endpush
@endsection
```


## 8. Certificate Templates

### 8.1 Template Structure

Each certificate template is a Blade view file that receives configuration data and renders a certificate design.

#### 8.1.1 Current Style Template (resources/views/certificates/templates/current-style.blade.php)

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            width: 297mm;
            height: 210mm;
            background: white;
            position: relative;
        }
        
        .certificate-container {
            width: 100%;
            height: 100%;
            border: 15px solid {{ $primary_color }};
            padding: 30px;
            position: relative;
        }
        
        .inner-border {
            width: 100%;
            height: 100%;
            border: 2px solid {{ $secondary_color }};
            padding: 40px;
            text-align: center;
        }
        
        .logo {
            max-height: 80px;
            margin-bottom: 20px;
        }
        
        .organization-name {
            font-size: 24px;
            font-weight: bold;
            color: {{ $primary_color }};
            margin-bottom: 10px;
        }
        
        .certificate-title {
            font-size: 48px;
            font-weight: bold;
            color: {{ $primary_color }};
            margin: 30px 0;
            text-transform: uppercase;
            letter-spacing: 4px;
        }
        
        .certificate-text {
            font-size: 18px;
            line-height: 1.8;
            margin: 20px 0;
        }
        
        .student-name {
            font-size: 32px;
            font-weight: bold;
            color: {{ $secondary_color }};
            margin: 20px 0;
            text-decoration: underline;
        }
        
        .course-name {
            font-size: 24px;
            font-weight: bold;
            margin: 15px 0;
        }
        
        .score {
            font-size: 20px;
            margin: 10px 0;
        }
        
        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }
        
        .signature-block {
            text-align: center;
            width: 200px;
        }
        
        .signature-image {
            height: 60px;
            margin-bottom: 10px;
        }
        
        .signature-line {
            border-top: 2px solid #000;
            margin: 10px 0;
        }
        
        .signature-name {
            font-size: 14px;
            font-weight: bold;
        }
        
        .signature-title {
            font-size: 12px;
            color: #666;
        }
        
        .issued-date {
            font-size: 14px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="inner-border">
            @if($logo_path)
                <img src="{{ public_path($logo_path) }}" alt="Logo" class="logo">
            @endif
            
            <div class="organization-name">{{ $organization_name }}</div>
            
            <div class="certificate-title">Certificate of Completion</div>
            
            <div class="certificate-text">
                This is to certify that
            </div>
            
            <div class="student-name">{{ $student_name }}</div>
            
            <div class="certificate-text">
                has successfully completed the course
            </div>
            
            <div class="course-name">{{ $course_name }}</div>
            
            <div class="score">
                with a final score of <strong>{{ number_format($total_score, 1) }}%</strong>
            </div>
            
            <div class="signatures">
                @if($instructor_signature_url)
                    <div class="signature-block">
                        <img src="{{ $instructor_signature_url }}" alt="Instructor Signature" class="signature-image">
                        <div class="signature-line"></div>
                        <div class="signature-name">{{ $instructor_name }}</div>
                        <div class="signature-title">Instructor</div>
                    </div>
                @endif
                
                <div class="signature-block">
                    <img src="{{ $kepala_signature_url }}" alt="Kepala Training Signature" class="signature-image">
                    <div class="signature-line"></div>
                    <div class="signature-name">Kepala Training</div>
                    <div class="signature-title">Training Director</div>
                </div>
            </div>
            
            <div class="issued-date">
                Issued on {{ $issued_date }}
            </div>
        </div>
    </div>
</body>
</html>
```


### 8.2 Template Preset Definitions

The other two template presets follow similar structure but with different styling:

**Elegant Classic 1**: Features ornate decorative borders, serif fonts with elegant script for the title, and traditional formal layout with gold/burgundy accent colors.

**Elegant Classic 2**: Features minimalist modern design with clean lines, sans-serif typography, and contemporary spacing with emphasis on negative space.

Implementation details for these templates would follow the same pattern as the current style template, with variations in CSS styling, border designs, and typography choices.

## 9. File Storage Structure

```
storage/app/
├── signatures/
│   ├── instructor_1_1234567890.png
│   ├── instructor_1_1234567891.png  (version history)
│   ├── instructor_2_1234567892.png
│   ├── kepala_training_1_1234567893.png
│   └── ...
├── logos/
│   ├── logo_1234567890.png
│   ├── logo_1234567891.jpg
│   └── ...
└── certificates/
    ├── certificate_CERT-ABC12345-2024.pdf
    ├── certificate_CERT-XYZ67890-2024.pdf
    └── ...
```

**Storage Strategy:**
- Signatures include timestamp in filename for versioning
- Old signature files are never deleted to maintain historical certificate integrity
- Certificates stored with unique code in filename for easy identification
- All files stored in Laravel's private storage (not publicly accessible)
- Public access controlled through routes and authorization checks

## 10. Migration Files

### 10.1 Create Signatures Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('file_path', 500);
            $table->string('file_name', 255);
            $table->enum('signature_type', ['instructor', 'kepala_training']);
            $table->timestamps();
            
            $table->index(['user_id', 'signature_type']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signatures');
    }
};
```

### 10.2 Create Certificate Configurations Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->unique()->constrained()->onDelete('cascade');
            $table->enum('template_preset', [
                'current_style',
                'elegant_classic_1',
                'elegant_classic_2'
            ])->default('current_style');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('kepala_training_signature_id')->nullable()->constrained('signatures')->onDelete('set null');
            $table->string('organization_name', 200)->default('LMS Garbarata');
            $table->string('logo_path', 500)->nullable();
            $table->string('primary_color', 7)->default('#1a56db');
            $table->string('secondary_color', 7)->default('#9333ea');
            $table->timestamps();
            $table->foreignId('updated_by_admin_id')->constrained('users');
            
            $table->index('course_id');
            $table->index('instructor_id');
            $table->index('updated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_configurations');
    }
};
```


### 10.3 Create Configuration Snapshots Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuration_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('restrict');
            $table->foreignId('config_id')->constrained('certificate_configurations')->onDelete('restrict');
            $table->enum('template_preset', [
                'current_style',
                'elegant_classic_1',
                'elegant_classic_2'
            ]);
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('restrict');
            $table->string('instructor_signature_path', 500)->nullable();
            $table->string('kepala_signature_path', 500);
            $table->string('organization_name', 200);
            $table->string('logo_path', 500)->nullable();
            $table->string('primary_color', 7);
            $table->string('secondary_color', 7);
            $table->unsignedInteger('version')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->foreignId('created_by_admin_id')->constrained('users')->onDelete('restrict');
            
            $table->index(['course_id', 'created_at']);
            $table->index('config_id');
            $table->index('created_at');
            $table->unique(['course_id', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuration_snapshots');
    }
};
```

### 10.4 Modify Certificates Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->foreignId('snapshot_id')->nullable()->after('course_id')
                ->constrained('configuration_snapshots')->onDelete('restrict');
            $table->string('pdf_path', 500)->nullable()->after('certificate_code');
            
            $table->index('snapshot_id');
            $table->index('issued_at');
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['snapshot_id']);
            $table->dropColumn(['snapshot_id', 'pdf_path']);
        });
    }
};
```

## 11. Error Handling and Validation

### 11.1 Validation Rules Summary

| Field | Rules | Error Messages |
|-------|-------|---------------|
| signature_data | required, string (base64) | "Please provide a signature" |
| signature_file | image, mimes:png,jpg,jpeg, max:5120 | "Invalid file format or size exceeds 5MB" |
| template_preset | required, in:current_style,elegant_classic_1,elegant_classic_2 | "Please select a valid template" |
| instructor_id | nullable, exists:users,id | "Selected instructor not found" |
| organization_name | required, string, max:200 | "Organization name is required and must not exceed 200 characters" |
| logo | nullable, image, mimes:png,jpg,jpeg,svg, max:5120 | "Invalid logo format or size exceeds 5MB" |
| primary_color | required, regex:/^#[a-fA-F0-9]{6}$/ | "Please provide a valid hex color code" |
| secondary_color | required, regex:/^#[a-fA-F0-9]{6}$/ | "Please provide a valid hex color code" |

### 11.2 Error Handling Strategy

**Signature Operations:**
- Empty canvas save attempt → Prevent with client-side validation and display message
- File upload failure → Rollback operation, display error, log details
- Storage write failure → Retry once, then log error and notify admin

**Configuration Operations:**
- Invalid data → Display specific field errors, preserve form data
- Snapshot creation failure → Rollback entire transaction, log error
- Missing instructor signature → Log warning, allow save but flag in snapshot

**Certificate Generation:**
- Missing snapshot → Throw exception, log error, notify admin
- Missing signature files → Log error, attempt generation without signature or use placeholder
- PDF generation failure → Log error, retry once, then notify admin
- Storage write failure → Log error, notify admin, allow retry

### 11.3 Logging Strategy

```php
// Signature operations
\Log::info('Signature saved', ['user_id' => $user->id, 'type' => $type]);
\Log::error('Signature save failed', ['user_id' => $user->id, 'error' => $e->getMessage()]);

// Configuration operations
\Log::info('Configuration updated', ['course_id' => $course->id, 'admin_id' => $admin->id]);
\Log::info('Snapshot created', ['snapshot_id' => $snapshot->id, 'version' => $snapshot->version]);

// Certificate generation
\Log::info('Certificate generated', ['certificate_id' => $cert->id, 'code' => $cert->certificate_code]);
\Log::error('Certificate generation failed', ['course_id' => $course->id, 'error' => $e->getMessage()]);

// Missing resources
\Log::warning('Instructor signature missing', ['course_id' => $course->id, 'instructor_id' => $instructorId]);
```


## 12. Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property Reflection

Before defining the correctness properties, a reflection analysis was performed to eliminate redundant properties:

**Consolidated Properties:**
- Signature storage, file creation, and persistence properties combined into signature persistence round-trip
- Multiple temporal application properties (requirements 1.10, 2.4, 4.9) combined into single temporal version correctness property
- Configuration snapshot creation properties (2.6, 7.1) unified
- Certificate immutability properties (2.7, 6.10, 7.6) consolidated
- Instructor signature integration properties (4.2, 8.1) merged
- Access control properties (9.1, 9.2, 9.6) combined into role-based access control

**Eliminated Redundancies:**
- Separate signature retrieval and display properties subsumed by persistence property
- Duplicate fallback/default properties combined into single default configuration property
- Multiple audit logging properties unified into single audit trail property


### Property 1: Signature Persistence Round-Trip

*For any* signature data (canvas or file), when saved to the system, retrieving the signature by user and type should return the stored signature with a valid file path that exists in storage.

**Validates: Requirements 1.4, 1.5, 4.5, 5.2**

### Property 2: Signature Replacement Versioning

*For any* instructor with an existing signature, when updating with new signature data, the system should create a new signature record with a later timestamp, and the old signature file should remain in storage for historical certificates.

**Validates: Requirements 1.6, 7.8**

### Property 3: Signature Access Control

*For any* instructor attempting to access or modify a signature, access should be granted if and only if the signature belongs to that instructor or the user has admin role.

**Validates: Requirements 1.9**

### Property 4: Temporal Version Correctness

*For any* certificate generation request at timestamp T, when an instructor signature was updated at timestamp T_update, the certificate should use the signature version that existed at time T, where the signature version is the most recent signature with created_at <= T.

**Validates: Requirements 1.10, 2.4, 4.9, 8.4, 8.8**

### Property 5: Configuration Snapshot Creation

*For any* configuration modification saved by an admin, a new configuration snapshot should be created with a unique version number (one greater than the previous version for that course) and an immutable timestamp equal to the save time.

**Validates: Requirements 2.6, 7.1**

### Property 6: Certificate Immutability

*For any* previously generated certificate, when the course configuration is subsequently modified, retrieving the certificate should return the exact same PDF and configuration data (via snapshot) as was generated initially, regardless of how many configuration changes occur afterward.

**Validates: Requirements 2.7, 6.10, 7.6**

### Property 7: Default Configuration Fallback

*For any* course without explicit custom configuration settings, retrieving the effective configuration should return the global default values for all unset fields (organization name, logo, colors, kepala signature).

**Validates: Requirements 2.8, 4.4, 4.8, 5.10**

### Property 8: Course Configuration Loading

*For any* course with saved configuration settings, when an admin loads the certificate configuration for that course, all returned settings should exactly match the most recently saved values for that specific course.

**Validates: Requirements 2.9**

### Property 9: Template Application Preservation

*For any* configuration with existing branding settings (organization name, logo, colors) and signature assignments, when the template preset is changed, all non-template settings should remain unchanged in the updated configuration.

**Validates: Requirements 3.3, 3.5**

### Property 10: Template Selection Persistence

*For any* template preset selection saved to a course configuration, querying the database for that course's configuration should return the same template preset value that was saved.

**Validates: Requirements 3.10**

### Property 11: Single Instructor Constraint

*For any* course, at any given time, the certificate configuration should reference exactly zero or one instructor (not multiple instructors).

**Validates: Requirements 4.1**

### Property 12: Instructor Signature Integration

*For any* course configuration with an assigned instructor, when a certificate is generated for that course, the certificate should automatically use the instructor's current signature from their profile (the most recent signature of type 'instructor' for that user).

**Validates: Requirements 4.2, 8.1**

### Property 13: Signature Display Completeness

*For any* generated certificate with a valid configuration snapshot, the certificate PDF should include both the instructor signature (if instructor is assigned and has signature) and the kepala training signature (from course-specific setting or global default).

**Validates: Requirements 4.6**

### Property 14: Missing Signature Handling

*For any* certificate generation where the assigned instructor has no signature, the system should either display a placeholder in the instructor signature area or omit the instructor signature section entirely, while still including the kepala training signature.

**Validates: Requirements 4.7**

### Property 15: Branding Configuration Round-Trip

*For any* organization name, logo file, and color values saved to a course configuration, retrieving that configuration should return the same organization name, logo file path, and color values that were saved.

**Validates: Requirements 5.1, 5.2, 5.3**

### Property 16: Logo Upload Validation

*For any* logo file upload attempt, if the file format is not in [PNG, JPG, JPEG, SVG] or the file size exceeds 5MB or dimensions are outside the range [100x100, 2000x2000] pixels, the upload should be rejected with a specific validation error message.

**Validates: Requirements 5.4**

### Property 17: Preview Rendering Synchronization

*For any* configuration setting change (organization name, colors, template), when an admin views the certificate preview, the preview should display the configuration values currently set in the form (even if not yet saved).

**Validates: Requirements 5.6, 5.8, 11.3**

### Property 18: Certificate Generation with Configuration

*For any* course completion event, when a certificate is generated, the system should retrieve the current configuration snapshot for that course at generation time and produce a PDF that incorporates the template layout, branding settings, and signatures from that snapshot.

**Validates: Requirements 6.1, 6.2, 6.5, 6.6, 6.7**

### Property 19: Certificate Snapshot Linkage

*For any* generated certificate, the certificate record should store a reference to the configuration snapshot ID that was used during generation, and that snapshot should be retrievable at any future time.

**Validates: Requirements 6.8, 7.3**

### Property 20: Certificate Generation Timestamp

*For any* certificate generation, the certificate record should include an issued_at timestamp equal to the time of generation, and this timestamp should be immutable after creation.

**Validates: Requirements 6.9**

### Property 21: Snapshot Completeness

*For any* configuration snapshot, the snapshot should include all configuration fields: template_preset, instructor_id, instructor_signature_path, kepala_signature_path, organization_name, logo_path, primary_color, secondary_color, version, and created_by_admin_id.

**Validates: Requirements 7.2**

### Property 22: Snapshot Immutability

*For any* configuration snapshot record, any attempt to update or delete the record should be prevented (throw exception) to maintain immutability.

**Validates: Requirements 7.4**

### Property 23: Initial Default Snapshot

*For any* course that has never had its certificate configuration modified, the first snapshot created should use version number 1 and include all default configuration values from the system configuration.

**Validates: Requirements 7.5**

### Property 24: Instructor Multi-Course Signature Consistency

*For any* instructor assigned to multiple courses, all courses should reference the same instructor user ID, and when generating certificates for any of those courses, the same instructor signature version (based on generation timestamp) should be used.

**Validates: Requirements 8.3, 8.5**

### Property 25: Instructor Removal Effect

*For any* course from which an instructor is removed (instructor_id set to null), certificates generated after the removal should not include that instructor's signature, while certificates generated before the removal should retain the signature that was active at their generation time.

**Validates: Requirements 8.6**

### Property 26: Instructor Name Display

*For any* certificate with an assigned instructor, the rendered PDF should display the instructor's name adjacent to or below their signature in the instructor signature block.

**Validates: Requirements 8.7**

### Property 27: Instructor Course Listing

*For any* instructor, their profile should display a list of courses that currently have the instructor assigned in the certificate configuration, and this list should update when instructor assignments change.

**Validates: Requirements 8.9**

### Property 28: Instructor Signature Validation

*For any* certificate generation request, if the configuration specifies an instructor_id but no signature exists for that instructor at the generation time, the system should log an error and either reject generation or generate without instructor signature.

**Validates: Requirements 8.10**

### Property 29: Role-Based Access Control

*For any* user attempting to access certificate configuration operations, access should be granted if and only if the user has admin role; non-admin users (including instructors) should be denied access with an authorization error.

**Validates: Requirements 9.1, 9.2, 9.6**

### Property 30: Admin Universal Permissions

*For any* admin user and any course, the admin should have permission to view and modify the certificate configuration for that course.

**Validates: Requirements 9.3**

### Property 31: Configuration Change Audit Trail

*For any* configuration modification, the system should create a log entry containing the course_id, admin user ID, admin name, and timestamp, and the configuration snapshot should record the created_by_admin_id.

**Validates: Requirements 9.4, 9.5, 9.10**

### Property 32: Instructor Read-Only Access

*For any* instructor and any course they are assigned to teach, the instructor should be able to view the certificate design for that course, but any attempt to modify configuration settings should be denied.

**Validates: Requirements 9.7**

### Property 33: Concurrent Certificate Generation Isolation

*For any* set of concurrent certificate generation requests for different students, all certificates should be generated successfully with correct data and no data corruption, where each certificate has a unique certificate_code and correct snapshot_id.

**Validates: Requirements 10.3**

### Property 34: Concurrent Configuration Independence

*For any* set of concurrent configuration update operations by different admins on different courses, all updates should complete successfully with each course receiving the correct configuration changes and independent snapshots.

**Validates: Requirements 10.4**

### Property 35: File Upload Validation

*For any* file upload (signature or logo), if the file size exceeds 5MB or the format is not in the allowed list, the upload should be rejected with a validation error before any storage operations occur.

**Validates: Requirements 10.5**

### Property 36: Signature Compression Quality Preservation

*For any* signature image stored in the system, when retrieved from storage, the image quality should be identical to the original (lossless compression), meaning pixel-perfect comparison should succeed.

**Validates: Requirements 10.7**

### Property 37: Error Handling Graceful Degradation

*For any* signature capture failure or certificate generation error, the system should catch the exception, log detailed error information, display a user-friendly error message (not exposing system internals), and leave the system in a consistent state without partial updates.

**Validates: Requirements 10.9**

### Property 38: Configuration Transaction Atomicity

*For any* configuration update operation that fails partway through (e.g., snapshot creation fails after configuration save), the entire operation should be rolled back such that neither the configuration nor snapshot changes are persisted to the database.

**Validates: Requirements 10.10**

### Property 39: Validation Error Display Locality

*For any* form submission with validation errors, each error message should be displayed adjacent to the specific form field that failed validation, not as a generic error at the top of the form.

**Validates: Requirements 11.6**

### Property 40: Signature Undo Reversal

*For any* sequence of signature drawing actions on the canvas followed by an undo operation, the canvas state should revert to the state before the last drawing action, and repeated undo operations should continue reverting previous actions.

**Validates: Requirements 11.8**

### Property 41: Configuration Save Confirmation

*For any* successful configuration save operation, a success confirmation message should be displayed to the admin user, confirming that changes were saved and a new snapshot was created.

**Validates: Requirements 11.9**

### Property 42: Empty Canvas Validation

*For any* attempt to save a signature from a canvas with no drawing strokes, the save operation should be prevented and a validation error message "Please provide a signature" should be displayed.

**Validates: Requirements 12.1**

### Property 43: Logo Dimension Validation

*For any* logo upload, if the image dimensions are less than 100x100 pixels or greater than 2000x2000 pixels, the upload should be rejected with a validation error specifying the allowed dimension range.

**Validates: Requirements 12.3**

### Property 44: Color Format Validation

*For any* color value input, if the value does not match the hexadecimal pattern /^#[a-fA-F0-9]{6}$/, the value should be rejected with a validation error "Please provide a valid hex color code".

**Validates: Requirements 12.4**

### Property 45: Missing Signature Error Handling

*For any* certificate generation request where required signature files are missing from storage (instructor or kepala signature paths point to non-existent files), the system should log an error including the missing file paths and course_id, and notify the admin.

**Validates: Requirements 12.5**

### Property 46: Instructor Account Validation

*For any* attempt to assign an instructor to a course configuration, if the instructor user account is inactive or does not exist, the assignment should be rejected with a validation error.

**Validates: Requirements 12.8**

## 13. Testing Strategy

### 13.1 Unit Tests

Unit tests should focus on specific examples, edge cases, and error conditions:

- **Signature validation**: Test empty canvas, invalid file formats, oversized files
- **Configuration validation**: Test invalid hex colors, names exceeding 200 chars, invalid template presets
- **Logo validation**: Test dimension boundaries (99x99, 100x100, 2000x2000, 2001x2001)
- **Role authorization**: Test specific role combinations (admin, instructor, student) accessing various endpoints
- **Error message display**: Test that specific validation errors produce expected messages
- **File upload edge cases**: Test exact size boundary (5MB), multiple simultaneous uploads

### 13.2 Property-Based Tests

Property tests should verify universal properties across random generated inputs (minimum 100 iterations):

- **Property 1-46**: Each property should have corresponding property test
- Test with randomly generated: user IDs, course IDs, signature data, configuration values, timestamps, hex colors, organization names
- Use property test library (e.g., PHPUnit with Faker, or pest with property testing plugin)
- Each property test must reference its design document property in test tag/description

### 13.3 Integration Tests

- Signature Pad JS library integration (canvas drawing, touch input)
- DomPDF certificate generation with actual templates
- Database transaction rollback scenarios
- Concurrent request handling
- File storage operations with filesystem
- Authentication system integration

### 13.4 Test Coverage Goals

- Unit test coverage: 80%+ for business logic services
- Property test coverage: All 46 properties implemented
- Integration test coverage: All critical user flows (signature save, config update, certificate generation)
- UI component tests: All Blade templates render without errors with sample data


## 14. Implementation Plan

### 14.1 Phase 1: Database and Models (Week 1)

1. Create migration files for all new tables
2. Modify existing certificates table migration
3. Implement Eloquent models with relationships
4. Add model validation and business rules
5. Implement snapshot immutability guards
6. Test database schema and relationships

### 14.2 Phase 2: Signature Management (Week 2)

1. Implement SignatureService with canvas and file upload support
2. Create Signature Pad UI component integration
3. Build instructor profile signature section
4. Implement signature versioning logic
5. Add file storage and validation
6. Write unit tests for signature operations
7. Write property tests for signature properties

### 14.3 Phase 3: Configuration System (Week 3)

1. Implement ConfigurationService and SnapshotService
2. Create admin certificate configuration controller
3. Build configuration UI panel with template selection
4. Implement branding settings (logo upload, colors, org name)
5. Add signature assignment functionality
6. Implement configuration validation
7. Write unit tests for configuration operations
8. Write property tests for configuration properties

### 14.4 Phase 4: Certificate Generation (Week 4)

1. Implement CertificateGenerationService
2. Create three template Blade views (current, elegant classic 1 & 2)
3. Integrate DomPDF for PDF generation
4. Implement snapshot-based certificate generation
5. Add certificate verification functionality
6. Write unit tests for generation logic
7. Write property tests for generation properties

### 14.5 Phase 5: Testing and Refinement (Week 5)

1. Implement all remaining property tests (100+ iterations each)
2. Conduct integration testing
3. Perform UI/UX testing with actual users
4. Load testing for concurrent operations
5. Security audit for file uploads and access control
6. Performance optimization
7. Bug fixes and refinements

### 14.6 Phase 6: Documentation and Deployment (Week 6)

1. Complete API documentation
2. Create user guides for instructors and admins
3. Set up monitoring and logging
4. Database backup and migration scripts
5. Deploy to staging environment
6. User acceptance testing
7. Production deployment
8. Post-deployment monitoring

## 15. Security Considerations

### 15.1 Access Control

- Implement middleware for role-based authorization
- Validate user permissions on every configuration and signature operation
- Use Laravel's built-in authorization policies for model-level access control
- Prevent signature access across instructor accounts

### 15.2 File Upload Security

- Validate file types using both extension and MIME type checks
- Scan uploaded files for malicious content using antivirus integration
- Store uploaded files in private storage (not web-accessible)
- Use random filename generation to prevent path traversal attacks
- Implement rate limiting on file upload endpoints

### 15.3 Data Integrity

- Use database transactions for all multi-step operations
- Implement snapshot immutability at model level (prevent updates/deletes)
- Use foreign key constraints with appropriate ON DELETE actions
- Validate all configuration data before snapshot creation
- Implement audit logging for all configuration changes

### 15.4 SQL Injection Prevention

- Use Eloquent ORM with parameterized queries exclusively
- Validate and sanitize all user inputs
- Use Laravel's query builder for complex queries
- Never concatenate user input into raw SQL queries

### 15.5 XSS Prevention

- Use Blade's {{ }} syntax for automatic HTML escaping
- Validate and sanitize user input on server side
- Use Laravel's validation rules for all form inputs
- Implement Content Security Policy headers

### 15.6 CSRF Protection

- Use Laravel's CSRF token on all forms
- Validate CSRF tokens on all POST/PUT/DELETE requests
- Use @csrf directive in all Blade forms

## 16. Performance Optimization

### 16.1 Database Optimization

- Index frequently queried columns (user_id, course_id, created_at, issued_at)
- Use eager loading for relationships to prevent N+1 queries
- Implement database connection pooling
- Use database query caching for configuration snapshots
- Implement pagination for large result sets

### 16.2 File Storage Optimization

- Store signature images with lossless compression
- Implement CDN for serving certificate PDFs (if public access needed)
- Use lazy loading for signature image display
- Implement file cleanup job for unused signatures (after confirmation of no historical references)

### 16.3 Caching Strategy

- Cache configuration snapshots (immutable data, perfect for caching)
- Cache global default settings
- Use Redis for session and cache storage
- Implement cache invalidation on configuration updates
- Cache template preset metadata

### 16.4 Certificate Generation Optimization

- Queue certificate generation for async processing if synchronous generation exceeds timeout
- Implement PDF caching for certificate verification page
- Use database transactions to minimize lock contention
- Optimize Blade template rendering with view caching

## 17. Monitoring and Logging

### 17.1 Application Monitoring

- Monitor certificate generation success/failure rates
- Track average certificate generation time
- Monitor file upload success rates
- Track configuration change frequency
- Monitor database query performance

### 17.2 Error Logging

- Log all signature operation failures with context
- Log certificate generation failures with student/course details
- Log configuration update failures
- Log missing signature file errors
- Implement error alerting for critical failures

### 17.3 Audit Logging

- Log all configuration changes with admin user, timestamp, and changes made
- Log all signature updates with instructor user and timestamp
- Log all certificate generations with student, course, and snapshot used
- Maintain immutable audit trail in database
- Implement audit log review interface for administrators

### 17.4 Performance Metrics

- Track certificate generation time (target: < 10 seconds)
- Track signature save time (target: < 3 seconds)
- Track configuration snapshot retrieval time (target: < 2 seconds)
- Monitor concurrent request handling capacity
- Track storage usage growth for signatures and certificates

## 18. Maintenance and Support

### 18.1 Backup Strategy

- Daily automated database backups
- Backup signature and certificate files to separate storage
- Implement point-in-time recovery capability
- Test backup restoration procedures monthly
- Maintain backup retention policy (90 days minimum)

### 18.2 Signature File Management

- Implement job to identify orphaned signature files
- Archive old signature versions (retain for historical certificates)
- Monitor signature storage usage
- Implement signature file integrity checks
- Document signature file versioning strategy

### 18.3 Certificate Archive Management

- Implement certificate archive system for old certificates
- Maintain certificate accessibility for verification
- Document certificate retention policy
- Implement certificate bulk export functionality
- Support certificate regeneration from historical snapshots if needed

### 18.4 Template Management

- Version control for template Blade files
- Test template changes in staging before production
- Document template customization procedures
- Support template preview with sample data
- Implement template rollback capability

## 19. Future Enhancements

### 19.1 Potential Feature Additions

- Custom template builder with drag-and-drop interface
- Multi-language certificate support
- Digital signature verification with QR codes
- Certificate badge integration (Open Badges standard)
- Bulk certificate generation for entire courses
- Certificate email delivery automation
- Certificate analytics dashboard
- Mobile app for certificate viewing
- Blockchain-based certificate verification

### 19.2 Scalability Improvements

- Microservices architecture for certificate generation
- Distributed file storage for signatures and certificates
- Database sharding for multi-tenant support
- Horizontal scaling for certificate generation service
- CDN integration for global certificate delivery

## 20. Conclusion

The Customizable Certificate System with Digital Signature provides a comprehensive solution for managing certificate generation in the LMS-Garbarata platform. The design emphasizes temporal integrity through immutable configuration snapshots, role-based access control for instructors and administrators, and flexible customization through template presets and branding options.

Key architectural decisions include:

1. **Snapshot-based versioning**: Ensures previously issued certificates remain unchanged when configurations are updated
2. **Centralized signature management**: Instructor signatures stored in profiles and automatically applied to all assigned courses
3. **Immutable audit trail**: Complete history of configuration changes with admin attribution
4. **Flexible template system**: Three preset templates with customizable branding
5. **Robust error handling**: Graceful degradation with comprehensive logging

The system is designed to scale with the platform's growth while maintaining data integrity and providing a seamless user experience for instructors, administrators, and students.

