<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\User;
use App\Models\Course;
use App\Models\ConfigurationSnapshot;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CertificateGenerationService
{
    protected SnapshotService $snapshotService;
    protected SignatureService $signatureService;

    public function __construct(SnapshotService $snapshotService, SignatureService $signatureService)
    {
        $this->snapshotService = $snapshotService;
        $this->signatureService = $signatureService;
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
            Log::error('Instructor signature missing', [
                'course_id' => $course->id,
                'instructor_id' => $snapshot->instructor_id,
            ]);
            throw new \Exception('Instructor signature not available');
        }
        
        // Generate unique certificate code
        $certificateCode = Certificate::generateCode();
        
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
            'course_name' => $course->title,
            'total_score' => $totalScore,
            'issued_date' => now()->format('d F Y'),
            'organization_name' => $snapshot->organization_name,
            'logo_path' => $snapshot->logo_path,
            'logo_data_uri' => $this->signatureService->toDataUri($snapshot->logo_path),
            'instructor_name' => $snapshot->instructor?->name,
            'instructor_signature_url' => $snapshot->instructor_signature_path 
                ? $this->signatureService->toDataUri($snapshot->instructor_signature_path)
                : null,
            'kepala_signature_url'    => $this->signatureService->toDataUri($snapshot->kepala_signature_path),
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
            'garbarata_default' => 'certificates.templates.current-style',
            'current_style' => 'certificates.templates.current-style',
            'elegant_classic_1' => 'certificates.templates.elegant-classic-1',
            default => 'certificates.templates.current-style',
        };
    }
}
