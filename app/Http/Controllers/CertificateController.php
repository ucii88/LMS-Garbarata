<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\SignatureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function __construct(private SignatureService $signatureService)
    {
    }

    /**
     * Tentukan view template berdasarkan snapshot (jika ada), fallback ke pdf.blade.php lama.
     */
    private function pdfDownloadResponse(Certificate $certificate)
    {
        $certificate->load('user', 'course', 'snapshot.instructor');

        $snapshot = $certificate->snapshot;

        if ($snapshot) {
            // Gunakan template baru dengan data dari snapshot
            $templateView = match ($snapshot->template_preset) {
                'garbarata_default' => 'certificates.templates.current-style',
                'elegant_classic_1' => 'certificates.templates.elegant-classic-1',
                default             => 'certificates.templates.current-style',
            };

            $instructorSignatureUrl = null;
            if ($snapshot->instructor_signature_path) {
                $instructorSignatureUrl = $this->signatureService->toDataUri($snapshot->instructor_signature_path);
            }

            $kepalaSignatureUrl = null;
            if ($snapshot->kepala_signature_path) {
                $kepalaSignatureUrl = $this->signatureService->toDataUri($snapshot->kepala_signature_path);
            }

            $data = [
                'student_name'             => $certificate->user->name,
                'course_name'              => $certificate->course->title,
                'total_score'              => (float) $certificate->total_score,
                'issued_date'              => $certificate->issued_at->locale('id')->translatedFormat('d F Y'),
                'certificate_code'         => $certificate->certificate_code,
                'organization_name'        => $snapshot->organization_name,
                'logo_path'                => $snapshot->logo_path,
                'logo_data_uri'            => $this->signatureService->toDataUri($snapshot->logo_path),
                'instructor_name'          => $snapshot->instructor?->name,
                'instructor_signature_url' => $instructorSignatureUrl,
                'kepala_signature_url'     => $kepalaSignatureUrl,
                'kepala_name'              => config('certificate.defaults.kepala_training_name'),
                'kepala_title'             => config('certificate.defaults.kepala_training_title'),
                'primary_color'            => $snapshot->primary_color,
                'secondary_color'          => $snapshot->secondary_color,
            ];

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($templateView, $data)
                ->setPaper('a4', 'landscape');
        } else {
            // Fallback: template lama (backward compat untuk sertifikat tanpa snapshot)
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('certificates.pdf', compact('certificate'))
                ->setPaper('a4', 'landscape');
        }

        return $pdf->download('Sertifikat-' . $certificate->course->title . '.pdf');
    }

    /**
     * Tampilkan halaman sertifikat.
     */
    public function show(Certificate $certificate)
    {
        // Hanya pemilik sertifikat yang bisa lihat
        abort_if($certificate->user_id !== auth()->id(), 403);

        $certificate->load('user', 'course');

        if (request()->has('download')) {
            return $this->pdfDownloadResponse($certificate);
        }

        return view('certificates.show', compact('certificate'));
    }

    /**
     * Unduh sertifikat untuk admin.
     */
    public function download(Certificate $certificate)
    {
        abort_unless(auth()->user()?->isAdmin(), 403);

        return $this->pdfDownloadResponse($certificate);
    }
}
