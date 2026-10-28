<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CertificateConfiguration;
use App\Models\Course;
use App\Models\Signature;
use App\Models\User;
use App\Services\ConfigurationService;
use App\Services\SignatureService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateConfigurationController extends Controller
{
    protected ConfigurationService $configService;
    protected SignatureService $signatureService;

    public function __construct(
        ConfigurationService $configService,
        SignatureService $signatureService
    ) {
        $this->configService = $configService;
        $this->signatureService = $signatureService;
    }

    /**
     * Daftar semua course dengan status konfigurasi sertifikat
     * GET /admin/certificate-config
     */
    public function index()
    {
        $courses = Course::with(['certificateConfiguration'])
            ->orderBy('title')
            ->get();

        return view('admin.certificate-config.index', compact('courses'));
    }

    /**
     * Form konfigurasi sertifikat untuk course tertentu
     * GET /admin/certificate-config/{course}
     */
    public function show(Course $course)
    {
        $config = $this->configService->getOrCreateConfiguration($course);
        $instructors = User::where('role', 'instruktur')->orderBy('name')->get();

        // Kepala training signature global (jika ada)
        $kepalaSignature = null;
        if ($config->kepala_training_signature_id) {
            $kepalaSignature = Signature::find($config->kepala_training_signature_id);
        } else {
            // Coba ambil dari global (kepala_training user pertama atau dari config)
            $kepalaSignature = Signature::where('signature_type', 'kepala_training')
                ->latest('created_at')
                ->first();
        }

        $templates = $this->getTemplatePresets();

        return view('admin.certificate-config.show', compact(
            'course',
            'config',
            'instructors',
            'kepalaSignature',
            'templates'
        ));
    }

    /**
     * Simpan konfigurasi sertifikat
     * POST /admin/certificate-config/{course}
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'template_preset'    => 'required|in:garbarata_default,current_style,elegant_classic_1',
            'instructor_id'      => 'nullable|exists:users,id',
            'organization_name'  => 'required|string|max:200',
            'primary_color'      => ['required', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'secondary_color'    => ['required', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'logo'               => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'kepala_signature_data' => 'nullable|string',
            'kepala_name'        => 'nullable|string|max:100',
            'kepala_title'       => 'nullable|string|max:100',
        ]);

        try {
            $data = [
                'template_preset'   => $validated['template_preset'],
                'instructor_id'     => $validated['instructor_id'] ?? null,
                'organization_name' => $validated['organization_name'],
                'primary_color'     => $validated['primary_color'],
                'secondary_color'   => $validated['secondary_color'],
            ];

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
                $data['logo_path'] = $file->storeAs('logos', $filename, 'public');
            }

            // Handle kepala training signature dari canvas (base64)
            if (!empty($validated['kepala_signature_data'])) {
                $adminUser = auth()->user();
                $kepalaSignature = $this->signatureService->saveFromCanvas(
                    $adminUser,
                    $validated['kepala_signature_data'],
                    'kepala_training'
                );
                $data['kepala_training_signature_id'] = $kepalaSignature->id;
            }

            // Simpan nama & jabatan kepala training ke config (lewat meta)
            // Kita simpan di snapshot via configService — tambahkan ke data jika ada field-nya
            // Karena tidak ada kolom terpisah, kita simpan di organization_name saja
            // atau kita extend nanti. Untuk sekarang, cukup update konfigurasi utama.

            $this->configService->updateConfiguration($course, $data, auth()->user());

            return redirect()
                ->route('admin.certificate-config.show', $course)
                ->with('success', __('Konfigurasi sertifikat berhasil disimpan.'));
        } catch (\Exception $e) {
            \Log::error('Certificate config update failed', [
                'course_id' => $course->id,
                'error'     => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Gagal menyimpan konfigurasi: ') . $e->getMessage());
        }
    }

    /**
     * Preview sertifikat dengan data dummy
     * GET /admin/certificate-config/{course}/preview
     */
    public function preview(Course $course)
    {
        $config = $this->configService->getOrCreateConfiguration($course);

        $instructorSignatureUrl = null;
        $instructorName = null;
        if ($config->instructor_id && $config->instructor) {
            $sig = $this->signatureService->getCurrentSignature($config->instructor, 'instructor');
            if ($sig) {
                $instructorSignatureUrl = $this->signatureService->toDataUri($sig->file_path);
            }
            $instructorName = $config->instructor->name;
        }

        $kepalaSignatureUrl = null;
        $kepalaSignaturePath = $config->kepala_training_signature_id
            ? optional(Signature::find($config->kepala_training_signature_id))->file_path
            : Signature::where('signature_type', 'kepala_training')->latest()->value('file_path');

        if ($kepalaSignaturePath) {
            $kepalaSignatureUrl = $this->signatureService->toDataUri($kepalaSignaturePath);
        }

        $data = [
            'student_name'            => 'Nama Peserta',
            'course_name'             => $course->title,
            'total_score'             => 95.0,
            'issued_date'             => now()->locale('id')->translatedFormat('d F Y'),
            'certificate_code'        => 'GRBT-PREV-1234',
            'organization_name'       => $config->organization_name ?? config('certificate.defaults.organization_name'),
            'logo_path'               => $config->logo_path,
            'logo_data_uri'           => $this->signatureService->toDataUri($config->logo_path),
            'instructor_name'         => $instructorName ?? 'Nama Instruktur',
            'instructor_signature_url'=> $instructorSignatureUrl,
            'kepala_signature_url'    => $kepalaSignatureUrl,
            'kepala_name'             => config('certificate.defaults.kepala_training_name'),
            'kepala_title'            => config('certificate.defaults.kepala_training_title'),
            'primary_color'           => $config->primary_color ?? config('certificate.defaults.primary_color'),
            'secondary_color'         => $config->secondary_color ?? config('certificate.defaults.secondary_color'),
        ];

        $templateView = $this->getTemplateView($config->template_preset ?? 'current_style');

        try {
            return Pdf::loadView($templateView, $data)
                ->setPaper('a4', 'landscape')
                ->stream('preview-sertifikat.pdf');
        } catch (\Throwable $e) {
            \Log::warning('Certificate PDF preview unavailable', ['error' => $e->getMessage()]);
            return response()->view($templateView, $data);
        }
    }

    /**
     * Simpan tanda tangan kepala training global
     * POST /admin/kepala-signature
     */
    public function saveKepalaSignature(Request $request)
    {
        $request->validate([
            'signature_data' => 'required|string',
        ]);

        try {
            $signature = $this->signatureService->saveFromCanvas(
                auth()->user(),
                $request->signature_data,
                'kepala_training'
            );

            return response()->json([
                'success'       => true,
                'message'       => __('Tanda tangan kepala training berhasil disimpan.'),
                'signature_url' => $this->signatureService->toDataUri($signature->file_path),
                'signature_id'  => $signature->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Ambil URL preview tanda tangan instruktur (AJAX)
     * GET /admin/instructor-signature/{user}
     */
    public function instructorSignaturePreview(User $user)
    {
        if ($user->role !== 'instruktur') {
            return response()->json(['url' => null]);
        }

        $signature = $this->signatureService->getCurrentSignature($user, 'instructor');

        if (!$signature) {
            return response()->json(['url' => null]);
        }

        return response()->json([
            'url'  => $this->signatureService->toDataUri($signature->file_path),
            'name' => $user->name,
        ]);
    }

    /**
     * Daftar template preset
     */
    protected function getTemplatePresets(): array
    {
        return [
            'garbarata_default' => [
                'name'        => 'Default Garbarata',
                'description' => 'Desain awal sertifikat Garbarata dengan border amber dan tanda tangan.',
            ],
            'current_style' => [
                'name'        => 'Current Style',
                'description' => 'Desain sertifikat yang sudah ada dengan dekorasi gold/amber.',
            ],
            'elegant_classic_1' => [
                'name'        => 'Elegant Classic 1',
                'description' => 'Layout formal klasik dengan border dekoratif dan tipografi serif.',
            ],
        ];
    }

    /**
     * Mapping preset ke nama view
     */
    protected function getTemplateView(string $preset): string
    {
        return match ($preset) {
            'garbarata_default' => 'certificates.templates.current-style',
            'current_style'     => 'certificates.templates.current-style',
            'elegant_classic_1' => 'certificates.templates.elegant-classic-1',
            default             => 'certificates.templates.current-style',
        };
    }
}
