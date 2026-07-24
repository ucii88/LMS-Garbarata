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
        $badgeLabel = __('Dashboard');
        $headline = __('Ringkasan aktivitas belajar');
        $description = __('Pantau aktivitas utama sesuai peran Anda dalam satu tampilan yang konsisten.');
        $primaryAction = null;
        $adminUserProgress = [];
        $participants = collect();
        $participantQuizzes = collect();
        $participantPractices = collect();

        if ($isAdmin) {
            $stats = [
                ['label' => __('Total Peserta'), 'value' => User::where('role', 'peserta')->count(), 'tone' => 'blue'],
                ['label' => __('Total Instruktur'), 'value' => User::where('role', 'instruktur')->count(), 'tone' => 'amber'],
                ['label' => __('Total Kursus'), 'value' => Course::count(), 'tone' => 'rose'],
            ];

            $cards = [
                ['title' => __('Manajemen Pengguna'), 'description' => __('Kelola akun peserta dan instruktur dari satu panel.'), 'meta' => __('Akses admin'), 'action' => __('Tambah User'), 'href' => '#manajemen-user', 'tone' => 'blue'],
                ['title' => __('Kontrol Kursus'), 'description' => __('Lihat status kursus, publikasi, dan materi aktif.'), 'meta' => __('Data LMS'), 'action' => __('Lihat Kursus'), 'href' => '#daftar-kursus', 'tone' => 'slate'],
                ['title' => __('Pengaturan Lanjutan'), 'description' => __('Area ini bisa dipakai untuk approval, report, dan audit.'), 'meta' => __('Coming soon'), 'action' => __('Segera Hadir'), 'href' => '#', 'tone' => 'amber', 'disabled' => true],
            ];

            $items = User::orderBy('id', 'desc')->limit(6)->get();
            $adminUserProgress = $items
                ->where('role', 'peserta')
                ->mapWithKeys(fn (User $participant) => [$participant->id => $this->participantProgress($participant)]);
            $badgeLabel = __('Admin Control Center');
            $headline = __('Selamat datang, Administrator');
            $description = __('Kendalikan pengguna, status kursus, dan struktur materi dari dashboard yang konsisten dan bersih.');
            $primaryAction = ['label' => __('Buka Manajemen Pengguna'), 'href' => route('admin.users.index')];
        } elseif ($isInstruktur) {
            $stats = [
                ['label' => __('Total Kursus'), 'value' => Course::count(), 'tone' => 'blue'],
                ['label' => __('Kursus Terpublikasi'), 'value' => Course::where('is_published', true)->count(), 'tone' => 'emerald'],
                ['label' => __('Modul Tersedia'), 'value' => Course::withCount('modules')->get()->sum('modules_count'), 'tone' => 'amber'],
            ];

            $items = Course::withCount('modules')->orderBy('id', 'desc')->limit(6)->get();
            $primaryCourse = $items->first();
            $cards = [
                ['title' => __('Kelola Materi'), 'description' => __('Atur course, modul, dan isi pembelajaran.'), 'meta' => __('Materi'), 'action' => __('Kelola Materi'), 'href' => $primaryCourse ? route('courses.show', $primaryCourse) : '#kelola-kursus', 'tone' => 'blue', 'button' => true],
                ['title' => __('Kelola Quiz & Ujian'), 'description' => __('Atur quiz chapter dan ujian akhir course.'), 'meta' => __('Evaluasi'), 'action' => __('Kelola Quiz & Ujian'), 'href' => $primaryCourse ? route('quizzes.index', $primaryCourse) : '#kelola-kursus', 'tone' => 'amber', 'button' => true],
                ['title' => __('Kelola Latihan'), 'description' => __('Atur latihan mandiri untuk setiap chapter.'), 'meta' => __('Latihan'), 'action' => __('Kelola Latihan'), 'href' => $primaryCourse ? route('practices.index', $primaryCourse) : '#kelola-kursus', 'tone' => 'slate', 'button' => true],
            ];
            
            $participants = User::where('role', 'peserta')->orderBy('id', 'desc')->get();
            $adminUserProgress = $participants->mapWithKeys(fn (User $participant) => [$participant->id => $this->participantProgress($participant)]);

            $badgeLabel = __('Instructor Workspace');
            $headline = __('Selamat datang, Instruktur');
            $description = __('Kelola materi Garbarata dan pantau progress belajar seluruh peserta.');
            $primaryAction = ['label' => __('Kelola Materi'), 'href' => $primaryCourse ? route('courses.show', $primaryCourse) : '#kelola-kursus'];
        } elseif ($isPeserta) {
            $stats = [
                ['label' => __('Materi Aktif'), 'value' => Course::where('is_published', true)->count(), 'tone' => 'blue'],
                ['label' => __('Modul Belajar'), 'value' => Course::where('is_published', true)->withCount('modules')->get()->sum('modules_count'), 'tone' => 'amber'],
                ['label' => __('Progress Materi'), 'value' => LearningProgress::forUser($user)['percent'].'%', 'tone' => 'emerald'],
            ];

            $items = Course::where('is_published', true)->withCount('modules')->orderBy('id', 'desc')->limit(6)->get();
            $primaryCourse = $items->first();
            $cards = [
                ['title' => __('Materi Garbarata'), 'description' => __('Masuk ke kursus interaktif untuk mempelajari komponen utama.'), 'meta' => __('Belajar sekarang'), 'action' => __('Mulai Belajar'), 'href' => $primaryCourse ? route('courses.show', $primaryCourse) : '#materi-kursus', 'tone' => 'blue'],
                ['title' => __('Quiz & Ujian'), 'description' => __('Kerjakan quiz chapter dan ujian akhir yang tersedia.'), 'meta' => __('Evaluasi'), 'action' => __('Lihat Quiz & Ujian'), 'href' => $primaryCourse ? route('courses.quizzes', $primaryCourse) : '#quiz-ujian', 'tone' => 'amber'],
                ['title' => __('Latihan Mandiri'), 'description' => __('Asah pemahaman lewat seluruh latihan yang tersedia.'), 'meta' => __('Latihan'), 'action' => __('Lihat Latihan'), 'href' => $primaryCourse ? route('courses.practices', $primaryCourse) : '#latihan-mandiri', 'tone' => 'slate'],
            ];
            $activities = Quiz::with(['course', 'chapter'])->withCount('questions')
                ->whereIn('course_id', $items->pluck('id'))
                ->where('is_active', true)
                ->orderBy('course_id')
                ->orderBy('order')
                ->get();
            $participantQuizzes = $activities->filter(fn (Quiz $activity) => ! $activity->isPractice())->values();
            $participantPractices = $activities->filter(fn (Quiz $activity) => $activity->isPractice())->values();
            $badgeLabel = __('Learner Portal');
            $headline = __('Selamat datang, Peserta');
            $description = __('Ikuti materi Garbarata dalam alur yang rapi, modern, dan sama untuk semua peran.');
            // Cari modul progress terakhir (updated_at terbaru), ambil chapter & course-nya
            $lastProgress = \App\Models\ModuleProgress::where('user_id', $user->id)
                ->with(['module.chapter.course'])
                ->orderByDesc('updated_at')
                ->first();
            $lastUrl = '#materi-kursus';
            if ($lastProgress && $lastProgress->module && $lastProgress->module->chapter && $lastProgress->module->chapter->course) {
                $lastChapter = $lastProgress->module->chapter;
                $lastUrl = route('courses.chapters.show', [$lastChapter->course_id, $lastChapter->id]);
            } elseif ($primaryCourse) {
                $lastUrl = route('courses.show', $primaryCourse);
            }
            $primaryAction = ['label' => __('Lanjutkan Belajar'), 'href' => $lastUrl];
        }

        // Generate current week days (Monday - Sunday)
        $today = \Carbon\Carbon::today();
        $startOfWeek = $today->copy()->startOfWeek();
        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i);
            $weekDays[] = [
                'day_name' => match($day->dayOfWeek) {
                    \Carbon\Carbon::MONDAY => 'S',
                    \Carbon\Carbon::TUESDAY => 'S',
                    \Carbon\Carbon::WEDNESDAY => 'R',
                    \Carbon\Carbon::THURSDAY => 'K',
                    \Carbon\Carbon::FRIDAY => 'J',
                    \Carbon\Carbon::SATURDAY => 'S',
                    \Carbon\Carbon::SUNDAY => 'M',
                },
                'date' => $day->day,
                'is_today' => $day->isToday(),
                'full_date' => $day->toDateString()
            ];
        }

        // Generate events based on role (Quiz/Exam schedules only)
        $scheduleEvents = [];

        // Add dynamic quizzes/exams with schedule
        $timedQuizzes = Quiz::where(function ($query) {
                $query->whereNotNull('start_time')->orWhereNotNull('end_time');
            })
            ->where('is_active', true)
            ->with('course')
            ->get();

        foreach ($timedQuizzes as $q) {
            $start = $q->start_time ? \Carbon\Carbon::parse($q->start_time)->timezone('Asia/Jakarta') : null;
            $end = $q->end_time ? \Carbon\Carbon::parse($q->end_time)->timezone('Asia/Jakarta') : null;
            $prefix = $q->isFinalQuiz() ? __('Final Exam:') . ' ' : ($q->isPractice() ? __('Latihan:') . ' ' : __('Quiz:') . ' ');

            if ($start && $end && $start->toDateString() === $end->toDateString()) {
                $scheduleEvents[] = [
                    'day_num' => $start->day,
                    'month_name' => strtoupper($start->translatedFormat('M')),
                    'title' => $prefix . $q->title,
                    'time_or_loc' => $start->format('H:i') . ' - ' . $end->format('H:i') . ' WIB · Online LMS',
                    'icon' => 'lock-open'
                ];
            } else {
                if ($start) {
                    $scheduleEvents[] = [
                        'day_num' => $start->day,
                        'month_name' => strtoupper($start->translatedFormat('M')),
                        'title' => $prefix . $q->title . ' ' . __('(Opened)'),
                        'time_or_loc' => $start->format('H:i') . ' WIB · Online LMS',
                        'icon' => 'lock-open'
                    ];
                }
                if ($end) {
                    $scheduleEvents[] = [
                        'day_num' => $end->day,
                        'month_name' => strtoupper($end->translatedFormat('M')),
                        'title' => $prefix . $q->title . ' ' . __('(Deadline)'),
                        'time_or_loc' => $end->format('H:i') . ' WIB · Online LMS',
                        'icon' => 'lock'
                    ];
                }
            }
        }

        // Sort events chronologically by day_num
        usort($scheduleEvents, function ($a, $b) {
            return $a['day_num'] <=> $b['day_num'];
        });

        return view('dashboard', compact('user', 'isAdmin', 'isInstruktur', 'isPeserta', 'stats', 'cards', 'items', 'badgeLabel', 'description', 'headline', 'primaryAction', 'adminUserProgress', 'participants', 'participantQuizzes', 'participantPractices', 'weekDays', 'scheduleEvents'));
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
