<?php

namespace App\Http\Controllers;

use App\LearningProgress;
use App\Models\Course;
use App\Models\ModuleProgress;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

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
        $badgeLabel = __('Beranda');
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

            // ── Pre-load data untuk peserta yang muncul di recent users ──
            $pesertaItems   = $items->where('role', 'peserta');
            $pesertaIds     = $pesertaItems->pluck('id')->all();

            if (!empty($pesertaIds)) {
                $allActivities = Quiz::query()
                    ->with(['course', 'chapter'])
                    ->where('is_active', true)
                    ->orderBy('course_id')->orderBy('chapter_id')->orderBy('order')
                    ->get();

                $activityIds = $allActivities->pluck('id')->all();

                $allAttemptsByUser = QuizAttempt::query()
                    ->whereIn('user_id', $pesertaIds)
                    ->whereIn('quiz_id', $activityIds)
                    ->whereNotNull('submitted_at')
                    ->orderByDesc('submitted_at')
                    ->get()
                    ->groupBy('user_id');

                $allModuleProgressByUser = ModuleProgress::whereIn('user_id', $pesertaIds)
                    ->get(['user_id', 'module_id'])
                    ->groupBy('user_id')
                    ->map(fn ($rows) => $rows->pluck('module_id'));

                $adminUserProgress = $pesertaItems->mapWithKeys(
                    fn (User $participant) => [
                        $participant->id => $this->participantProgress(
                            $participant,
                            $allActivities,
                            $allAttemptsByUser->get($participant->id, collect()),
                            $allModuleProgressByUser->get($participant->id, collect()),
                        ),
                    ]
                );
            }
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

            // ── Pre-load semua data yang dibutuhkan participantProgress() dalam SATU set query ──
            $participantIds = $participants->pluck('id')->all();

            // 1. Semua aktivitas quiz (satu query, di-share ke semua peserta)
            $allActivities = Quiz::query()
                ->with(['course', 'chapter'])
                ->where('is_active', true)
                ->orderBy('course_id')->orderBy('chapter_id')->orderBy('order')
                ->get();

            $activityIds = $allActivities->pluck('id')->all();

            // 2. Semua QuizAttempt peserta (satu query)
            $allAttemptsByUser = QuizAttempt::query()
                ->whereIn('user_id', $participantIds)
                ->whereIn('quiz_id', $activityIds)
                ->whereNotNull('submitted_at')
                ->orderByDesc('submitted_at')
                ->get()
                ->groupBy('user_id');  // [ user_id => Collection<QuizAttempt> ]

            // 3. Semua module progress peserta (satu query)
            $allModuleProgressByUser = ModuleProgress::whereIn('user_id', $participantIds)
                ->pluck('module_id', 'user_id')  // hanya pluck id
                ->groupBy(fn ($moduleId, $userId) => $userId);
            // Gunakan groupBy dengan key agar tetap bisa di-lookup per user
            $allModuleProgressByUser = ModuleProgress::whereIn('user_id', $participantIds)
                ->get(['user_id', 'module_id'])
                ->groupBy('user_id')  // [ user_id => Collection<ModuleProgress> ]
                ->map(fn ($rows) => $rows->pluck('module_id'));

            $adminUserProgress = $participants->mapWithKeys(
                fn (User $participant) => [
                    $participant->id => $this->participantProgress(
                        $participant,
                        $allActivities,
                        $allAttemptsByUser->get($participant->id, collect()),
                        $allModuleProgressByUser->get($participant->id, collect()),
                    ),
                ]
            );

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
            ->with(['course'])
            ->get();

        $userQuizAttempts = collect();
        if ($isPeserta && $timedQuizzes->isNotEmpty()) {
            $userQuizAttempts = QuizAttempt::where('user_id', $user->id)
                ->whereIn('quiz_id', $timedQuizzes->pluck('id'))
                ->whereNotNull('submitted_at')
                ->get(['quiz_id', 'is_passed', 'score'])
                ->keyBy('quiz_id');
        }

        $now = \Carbon\Carbon::now('Asia/Jakarta');

        foreach ($timedQuizzes as $q) {
            $start = $q->start_time ? \Carbon\Carbon::parse($q->start_time)->timezone('Asia/Jakarta') : null;
            $end = $q->end_time ? \Carbon\Carbon::parse($q->end_time)->timezone('Asia/Jakarta') : null;
            $prefix = $q->isFinalQuiz() ? __('Final Exam:') . ' ' : ($q->isPractice() ? __('Latihan:') . ' ' : __('Quiz:') . ' ');
            $quizTitle = $q->title;
            $courseTitle = $q->course?->title ?? '';

            // Tentukan status quiz berdasarkan waktu
            if ($start && $now->lt($start)) {
                $status = 'upcoming'; // Belum dibuka
            } elseif ($end && $now->gt($end)) {
                $status = 'closed';   // Sudah ditutup
            } else {
                $status = 'open';     // Sedang dibuka
            }

            $hasSubmitted = $userQuizAttempts->has($q->id);

            // Tentukan URL & Modal Aksi berdasarkan Role & Status
            $url = null;
            $isModal = false;

            if ($isPeserta) {
                if ($status === 'upcoming') {
                    $url = '#';
                    $isModal = true;
                } elseif ($status === 'closed' || $hasSubmitted) {
                    $url = route($q->isPractice() ? 'practice.result' : 'quiz.result', [$q->course_id, $q->id]);
                } else { // open and not submitted
                    $url = route($q->isPractice() ? 'practice.start' : 'quiz.start', [$q->course_id, $q->id]);
                }
            } else { // Instruktur & Admin
                if ($status === 'closed') {
                    $url = route($q->isPractice() ? 'practices.attempts' : 'quizzes.attempts', [$q->course_id, $q->id]);
                } else { // open or upcoming
                    $url = route($q->isPractice() ? 'practices.edit' : 'quizzes.edit', [$q->course_id, $q->id]);
                }
            }

            $startFmt = $start ? $start->translatedFormat('d M Y H:i') . ' WIB' : '-';
            $endFmt = $end ? $end->translatedFormat('d M Y H:i') . ' WIB' : '-';

            if ($start && $end && $start->toDateString() === $end->toDateString()) {
                $scheduleEvents[] = [
                    'day_num' => $start->day,
                    'month_name' => strtoupper($start->translatedFormat('M')),
                    'title' => $prefix . $q->title,
                    'time_or_loc' => $start->format('H:i') . ' - ' . $end->format('H:i') . ' WIB · Online LMS',
                    'icon' => $status === 'closed' ? 'lock' : 'lock-open',
                    'url' => $url,
                    'is_modal' => $isModal,
                    'quiz_title' => $quizTitle,
                    'course_title' => $courseTitle,
                    'start_fmt' => $startFmt,
                    'end_fmt' => $endFmt,
                    'status' => $status,
                ];
            } else {
                if ($start) {
                    $scheduleEvents[] = [
                        'day_num' => $start->day,
                        'month_name' => strtoupper($start->translatedFormat('M')),
                        'title' => $prefix . $q->title . ' ' . __('(Opened)'),
                        'time_or_loc' => $start->format('H:i') . ' WIB · Online LMS',
                        'icon' => 'lock-open',
                        'url' => $url,
                        'is_modal' => $isModal,
                        'quiz_title' => $quizTitle,
                        'course_title' => $courseTitle,
                        'start_fmt' => $startFmt,
                        'end_fmt' => $endFmt,
                        'status' => $status,
                    ];
                }
                if ($end) {
                    $scheduleEvents[] = [
                        'day_num' => $end->day,
                        'month_name' => strtoupper($end->translatedFormat('M')),
                        'title' => $prefix . $q->title . ' ' . __('(Deadline)'),
                        'time_or_loc' => $end->format('H:i') . ' WIB · Online LMS',
                        'icon' => 'lock',
                        'url' => $url,
                        'is_modal' => $isModal,
                        'quiz_title' => $quizTitle,
                        'course_title' => $courseTitle,
                        'start_fmt' => $startFmt,
                        'end_fmt' => $endFmt,
                        'status' => $status,
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

    /**
     * Hitung progress belajar seorang peserta.
     *
     * Semua data diterima sebagai parameter (sudah di-preload di __invoke)
     * sehingga method ini TIDAK membuat query DB sama sekali.
     *
     * @param User       $participant
     * @param Collection $allActivities          Semua Quiz aktif (sudah eager-loaded)
     * @param Collection $userAttempts           QuizAttempt peserta ini (sudah di-filter dari luar)
     * @param Collection $completedModuleIds     module_id yang sudah diselesaikan peserta ini
     */
    private function participantProgress(
        User $participant,
        Collection $allActivities,
        Collection $userAttempts,
        Collection $completedModuleIds,
    ): array {
        // ── Progress materi (dari collection in-memory, 0 query) ──
        $progress = LearningProgress::forUserPreloaded($participant, $completedModuleIds);

        // ── Attempts: ambil 1 per quiz (latest submitted) ── (0 query)
        $attemptsByQuiz = $userAttempts
            ->unique('quiz_id')
            ->keyBy('quiz_id');

        $activityData = fn (Quiz $activity) => [
            'id'           => $activity->id,
            'title'        => $activity->title,
            'course'       => $activity->course?->title,
            'chapter'      => $activity->chapter?->title,
            'is_completed' => $attemptsByQuiz->has($activity->id),
            'score'        => $attemptsByQuiz->has($activity->id)
                ? round((float) $attemptsByQuiz[$activity->id]->score, 1)
                : null,
        ];

        return [
            'name'             => $participant->name,
            'email'            => $participant->email,
            'material_percent' => $progress['percent'],
            'chapters'         => $progress['chapters']->map(fn (array $chapter) => [
                'order'           => $chapter['order'],
                'title'           => $chapter['title'],
                'percent'         => $chapter['percent'],
                'is_complete'     => $chapter['is_complete'],
                'missing_modules' => $chapter['missing_modules']->map(fn ($module) => $module->title)->values(),
            ])->values(),
            'quizzes'   => $allActivities->filter(fn (Quiz $a) => !$a->isPractice() && !$a->isFinalQuiz())->map($activityData)->values(),
            'exams'     => $allActivities->filter(fn (Quiz $a) => !$a->isPractice() && $a->isFinalQuiz())->map($activityData)->values(),
            'practices' => $allActivities->filter(fn (Quiz $a) => $a->isPractice())->map($activityData)->values(),
        ];
    }
}

