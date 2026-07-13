<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Tampilkan halaman sertifikat.
     */
    public function show(Certificate $certificate)
    {
        // Hanya pemilik sertifikat yang bisa lihat
        abort_if($certificate->user_id !== auth()->id(), 403);

        $certificate->load('user', 'course');

        return view('certificates.show', compact('certificate'));
    }
}
