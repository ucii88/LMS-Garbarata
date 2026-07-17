<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    private function pdfDownloadResponse(Certificate $certificate)
    {
        $certificate->load('user', 'course');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('certificates.pdf', compact('certificate'))
            ->setPaper('a4', 'landscape');

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
