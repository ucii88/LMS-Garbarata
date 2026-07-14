<?php

namespace App\Http\Controllers;

use App\LearningProgress;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
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
        $participants = collect();
        $participantQuizzes = collect();
        $participantPractices = collect();

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
                ->mapWithKeys(fn (User $participant) => [$participant->id => $this->participantProgress($participant)]);
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

            $items = Course::withCount('modules')->orderBy('id', 'desc')->limit(6)->get();
            $primaryCourse = $items->first();
            $cards = [
                ['title' => 'Kelola Materi', 'description' => 'Atur course, modul, dan isi pembelajaran.', 'meta' => 'Materi', 'action' => 'Kelola Materi', 'href' => $primaryCourse ? route('courses.show', $primaryCourse) : '#kelola-kursus', 'tone' => 'blue', 'button' => true],
                ['title' => 'Kelola Quiz & Ujian', 'description' => 'Atur quiz chapter dan ujian akhir course.', 'meta' => 'Evaluasi', 'action' => 'Kelola Quiz & Ujian', 'href' => $primaryCourse ? route('quizzes.index', $primaryCourse) : '#kelola-kursus', 'tone' => 'amber', 'button' => true],
                ['title' => 'Kelola Latihan', 'description' => 'Atur latihan mandiri untuk setiap chapter.', 'meta' => 'Latihan', 'action' => 'Kelola Latihan', 'href' => $primaryCourse ? route('practices.index', $primaryCourse) : '#kelola-kursus', 'tone' => 'slate', 'button' => true],
            ];
            
            $participants = User::where('role', 'peserta')->orderBy('id', 'desc')->get();
            $adminUserProgress = $participants->mapWithKeys(fn (User $participant) => [$participant->id => $this->participantProgress($participant)]);

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

            $items = Course::where('is_published', true)->withCount('modules')->orderBy('id', 'desc')->limit(6)->get();
            $primaryCourse = $items->first();
            $cards = [
                ['title' => 'Materi Garbarata', 'description' => 'Masuk ke kursus interaktif untuk mempelajari komponen utama.', 'meta' => 'Belajar sekarang', 'action' => 'Mulai Belajar', 'href' => $primaryCourse ? route('courses.show', $primaryCourse) : '#materi-kursus', 'tone' => 'blue'],
                ['title' => 'Quiz & Ujian', 'description' => 'Kerjakan quiz chapter dan ujian akhir yang tersedia.', 'meta' => 'Evaluasi', 'action' => 'Lihat Quiz & Ujian', 'href' => $primaryCourse ? route('courses.quizzes', $primaryCourse) : '#quiz-ujian', 'tone' => 'amber'],
                ['title' => 'Latihan Mandiri', 'description' => 'Asah pemahaman lewat seluruh latihan yang tersedia.', 'meta' => 'Latihan', 'action' => 'Lihat Latihan', 'href' => $primaryCourse ? route('courses.practices', $primaryCourse) : '#latihan-mandiri', 'tone' => 'slate'],
            ];
            $activities = Quiz::with(['course', 'chapter'])->withCount('questions')
                ->whereIn('course_id', $items->pluck('id'))
                ->where('is_active', true)
                ->orderBy('course_id')
                ->orderBy('order')
                ->get();
            $participantQuizzes = $activities->filter(fn (Quiz $activity) => ! $activity->isPractice())->values();
            $participantPractices = $activities->filter(fn (Quiz $activity) => $activity->isPractice())->values();
            $badgeLabel = 'Learner Portal';
            $headline = 'Selamat datang, Peserta';
            $description = 'Ikuti materi Garbarata dalam alur yang rapi, modern, dan sama untuk semua peran.';
            $primaryAction = ['label' => 'Lanjutkan Belajar', 'href' => '#materi-kursus'];
            
        }

        return view('dashboard', compact('user', 'isAdmin', 'isInstruktur', 'isPeserta', 'stats', 'cards', 'items', 'badgeLabel', 'description', 'headline', 'primaryAction', 'adminUserProgress', 'participants', 'participantQuizzes', 'participantPractices'));
    }

    private function participantProgress(User $participant): array
    {
        $progress = LearningProgress::forUser($participant);
        $activities = Quiz::query()
            ->with(['course', 'chapter'])
            ->where('is_active', true)
            ->orderBy('course_id')
            ->orderBy('chapter_id')
            ->orderBy('order')
            ->get();
        $attempts = QuizAttempt::query()
            ->where('user_id', $participant->id)
            ->whereIn('quiz_id', $activities->pluck('id'))
            ->whereNotNull('submitted_at')
            ->orderByDesc('submitted_at')
            ->get()
            ->unique('quiz_id')
            ->keyBy('quiz_id');
        $activityData = fn (Quiz $activity) => [
            'id' => $activity->id,
            'title' => $activity->title,
            'course' => $activity->course?->title,
            'chapter' => $activity->chapter?->title,
            'is_completed' => $attempts->has($activity->id),
            'score' => $attempts->has($activity->id) ? round((float) $attempts[$activity->id]->score, 1) : null,
        ];

        return [
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
            'quizzes' => $activities->filter(fn (Quiz $activity) => ! $activity->isPractice() && ! $activity->isFinalQuiz())->map($activityData)->values(),
            'exams' => $activities->filter(fn (Quiz $activity) => ! $activity->isPractice() && $activity->isFinalQuiz())->map($activityData)->values(),
            'practices' => $activities->filter(fn (Quiz $activity) => $activity->isPractice())->map($activityData)->values(),
        ];
    }
}
