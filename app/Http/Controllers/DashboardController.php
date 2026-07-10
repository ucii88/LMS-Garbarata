<?php

namespace App\Http\Controllers;

use App\LearningProgress;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isAdmin();
        $isInstruktur = $user->isInstruktur();
        $isPeserta = $user->isPeserta();

        $stats = [];
        $cards = [];
        $items = collect();
        $badgeLabel = 'Dashboard';
        $headline = 'Ringkasan aktivitas belajar';
        $description = 'Pantau aktivitas utama sesuai peran Anda dalam satu tampilan yang konsisten.';
        $primaryAction = null;
        $adminUserProgress = [];

        if ($isAdmin) {
            $stats = [
                ['label' => 'Total Peserta', 'value' => User::where('role', 'peserta')->count(), 'tone' => 'blue'],
                ['label' => 'Total Instruktur', 'value' => User::where('role', 'instruktur')->count(), 'tone' => 'amber'],
                ['label' => 'Total Kursus', 'value' => Course::count(), 'tone' => 'rose'],
            ];

            $cards = [
                ['title' => 'Manajemen Pengguna', 'description' => 'Kelola akun peserta dan instruktur dari satu panel.', 'meta' => 'Akses admin', 'action' => 'Tambah User', 'href' => '#manajemen-user', 'tone' => 'blue'],
                ['title' => 'Kontrol Kursus', 'description' => 'Lihat status kursus, publikasi, dan materi aktif.', 'meta' => 'Data LMS', 'action' => 'Lihat Kursus', 'href' => '#daftar-kursus', 'tone' => 'slate'],
                ['title' => 'Pengaturan Lanjutan', 'description' => 'Area ini bisa dipakai untuk approval, report, dan audit.', 'meta' => 'Coming soon', 'action' => 'Segera Hadir', 'href' => '#', 'tone' => 'amber', 'disabled' => true],
            ];

            $items = User::orderBy('id', 'desc')->limit(6)->get();
            $adminUserProgress = $items
                ->where('role', 'peserta')
                ->mapWithKeys(function (User $participant) {
                    $progress = LearningProgress::forUser($participant);

                    return [
                        $participant->id => [
                            'name' => $participant->name,
                            'email' => $participant->email,
                            'material_percent' => $progress['percent'],
                            'chapters' => $progress['chapters']->map(fn (array $chapter) => [
                                'order' => $chapter['order'],
                                'title' => $chapter['title'],
                                'percent' => $chapter['percent'],
                                'is_complete' => $chapter['is_complete'],
                                'missing_modules' => $chapter['missing_modules']->map(fn ($module) => $module->title)->values(),
                            ])->values(),
                            'notes' => $progress['notes']->values(),
                        ],
                    ];
                });
            $badgeLabel = 'Admin Control Center';
            $headline = 'Selamat datang, Administrator';
            $description = 'Kendalikan pengguna, status kursus, dan struktur materi dari dashboard yang konsisten dan bersih.';
            $primaryAction = ['label' => 'Buka Manajemen Pengguna', 'href' => '#manajemen-user'];
        } elseif ($isInstruktur) {
            $stats = [
                ['label' => 'Total Kursus', 'value' => Course::count(), 'tone' => 'blue'],
                ['label' => 'Kursus Terpublikasi', 'value' => Course::where('is_published', true)->count(), 'tone' => 'emerald'],
                ['label' => 'Modul Tersedia', 'value' => Course::withCount('modules')->get()->sum('modules_count'), 'tone' => 'amber'],
            ];

            $cards = [
                ['title' => 'Kelola Materi', 'description' => 'Atur course, modul, dan isi pembelajaran interaktif.', 'meta' => 'Workspace pengajar', 'action' => 'Buka Materi', 'href' => '#daftar-kursus', 'tone' => 'blue'],
                ['title' => 'Diagram Interaktif', 'description' => 'Pantau diagram dan hotspot pembelajaran pada materi.', 'meta' => 'Visual learning', 'action' => 'Lihat Diagram', 'href' => '#daftar-kursus', 'tone' => 'slate'],
                ['title' => 'Evaluasi', 'description' => 'Ruang untuk kuis, latihan, dan evaluasi peserta.', 'meta' => 'Coming soon', 'action' => 'Segera Hadir', 'href' => '#', 'tone' => 'amber', 'disabled' => true],
            ];

            $items = Course::withCount('modules')->orderBy('id', 'desc')->limit(6)->get();
            
            $participants = User::where('role', 'peserta')->orderBy('id', 'desc')->get();
            $adminUserProgress = $participants->mapWithKeys(function (User $participant) {
                $progress = LearningProgress::forUser($participant);

                return [
                    $participant->id => [
                        'name' => $participant->name,
                        'email' => $participant->email,
                        'material_percent' => $progress['percent'],
                        'chapters' => $progress['chapters']->map(fn (array $chapter) => [
                            'order' => $chapter['order'],
                            'title' => $chapter['title'],
                            'percent' => $chapter['percent'],
                            'is_complete' => $chapter['is_complete'],
                            'missing_modules' => $chapter['missing_modules']->map(fn ($module) => $module->title)->values(),
                        ])->values(),
                        'notes' => $progress['notes']->values(),
                    ],
                ];
            });

            $badgeLabel = 'Instructor Workspace';
            $headline = 'Selamat datang, Instruktur';
            $description = 'Kelola materi Garbarata dan pantau progress belajar seluruh peserta.';
            $primaryAction = ['label' => 'Buka Daftar Kursus', 'href' => '#daftar-kursus'];
        } elseif ($isPeserta) {
            $stats = [
                ['label' => 'Materi Aktif', 'value' => Course::where('is_published', true)->count(), 'tone' => 'blue'],
                ['label' => 'Modul Belajar', 'value' => Course::where('is_published', true)->withCount('modules')->get()->sum('modules_count'), 'tone' => 'amber'],
                ['label' => 'Progress Materi', 'value' => LearningProgress::forUser($user)['percent'].'%', 'tone' => 'emerald'],
            ];

            $cards = [
                ['title' => 'Materi Garbarata', 'description' => 'Masuk ke kursus interaktif untuk mempelajari komponen utama.', 'meta' => 'Belajar sekarang', 'action' => 'Mulai Belajar', 'href' => '#materi-kursus', 'tone' => 'blue'],
                ['title' => 'Diagram Interaktif', 'description' => 'Klik hotspot untuk membuka penjelasan setiap komponen.', 'meta' => 'Visual guide', 'action' => 'Buka Diagram', 'href' => '#materi-kursus', 'tone' => 'slate'],
                ['title' => 'Kuis & Latihan', 'description' => 'Fitur penilaian dan latihan mandiri akan menyusul.', 'meta' => 'Coming soon', 'action' => 'Segera Hadir', 'href' => '#', 'tone' => 'amber', 'disabled' => true],
            ];

            $items = Course::where('is_published', true)->orderBy('id', 'desc')->limit(6)->get();
            $badgeLabel = 'Learner Portal';
            $headline = 'Selamat datang, Peserta';
            $description = 'Ikuti materi Garbarata dalam alur yang rapi, modern, dan sama untuk semua peran.';
            $primaryAction = ['label' => 'Lanjutkan Belajar', 'href' => '#materi-kursus'];
        }

        return view('dashboard', compact('user', 'isAdmin', 'isInstruktur', 'isPeserta', 'stats', 'cards', 'items', 'badgeLabel', 'description', 'headline', 'primaryAction', 'adminUserProgress', 'participants'));
    }
}
