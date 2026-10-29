<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Chapter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Display full interactive calendar page.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', __('Halaman Kalender hanya tersedia untuk Instruktur dan Peserta.'));
        }

        // Get requested month & year, default to current month & year (Asia/Jakarta timezone)
        $now = Carbon::now('Asia/Jakarta');
        $month = (int) $request->input('month', $now->month);
        $year = (int) $request->input('year', $now->year);

        // Sanitize bounds
        if ($month < 1 || $month > 12) {
            $month = $now->month;
        }
        if ($year < 2020 || $year > 2050) {
            $year = $now->year;
        }

        $currentMonthDate = Carbon::createFromDate($year, $month, 1, 'Asia/Jakarta')->startOfDay();
        
        $prevMonthDate = $currentMonthDate->copy()->subMonth();
        $nextMonthDate = $currentMonthDate->copy()->addMonth();

        $startOfMonth = $currentMonthDate->copy()->startOfMonth();
        $endOfMonth = $currentMonthDate->copy()->endOfMonth();

        // Start grid on Monday (ISO week)
        $startOfGrid = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        // End grid on Sunday
        $endOfGrid = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);

        // Build calendar grid matrix (weeks -> days)
        $gridWeeks = [];
        $currentCursor = $startOfGrid->copy();

        while ($currentCursor->lte($endOfGrid)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $week[] = [
                    'date_string' => $currentCursor->toDateString(),
                    'day_number'  => $currentCursor->day,
                    'is_current_month' => $currentCursor->month === $month,
                    'is_today'    => $currentCursor->isToday(),
                    'is_past'     => $currentCursor->isPast() && !$currentCursor->isToday(),
                ];
                $currentCursor->addDay();
            }
            $gridWeeks[] = $week;
        }

        // Fetch events for the grid date range
        $events = [];

        // 1. Timed Quizzes and Exams (from Quiz model)
        $timedQuizzes = Quiz::where(function ($query) use ($startOfGrid, $endOfGrid) {
                $query->whereBetween('start_time', [$startOfGrid->toDateTimeString(), $endOfGrid->toDateTimeString()])
                      ->orWhereBetween('end_time', [$startOfGrid->toDateTimeString(), $endOfGrid->toDateTimeString()]);
            })
            ->where('is_active', true)
            ->with(['course', 'chapter'])
            ->get();

        $userQuizAttempts = collect();
        if ($user->isPeserta() && $timedQuizzes->isNotEmpty()) {
            $userQuizAttempts = QuizAttempt::where('user_id', $user->id)
                ->whereIn('quiz_id', $timedQuizzes->pluck('id'))
                ->whereNotNull('submitted_at')
                ->get(['quiz_id', 'is_passed', 'score'])
                ->keyBy('quiz_id');
        }

        foreach ($timedQuizzes as $quiz) {
            $courseName = $quiz->course ? $quiz->course->title : __('Kursus LMS');
            $chapterName = $quiz->chapter ? $quiz->chapter->title : null;

            $startTime = $quiz->start_time ? Carbon::parse($quiz->start_time)->timezone('Asia/Jakarta') : null;
            $endTime = $quiz->end_time ? Carbon::parse($quiz->end_time)->timezone('Asia/Jakarta') : null;

            $isFinal = $quiz->isFinalQuiz();
            $isPractice = $quiz->isPractice();
            $type = $isPractice ? 'practice' : ($isFinal ? 'exam' : 'quiz');

            $status = $quiz->availability_status; // 'upcoming', 'open', 'closed'
            $statusBadge = match($status) {
                'upcoming' => __('Belum Dibuka'),
                'closed'   => __('Ditutup'),
                'open'     => __('Dibuka'),
            };

            $hasSubmitted = $userQuizAttempts->has($quiz->id);

            $actionUrl = '#';
            $actionLabel = '';
            $isDisabled = false;

            if ($user->isPeserta()) {
                if ($hasSubmitted) {
                    $actionUrl = route($isPractice ? 'practice.result' : 'quiz.result', [$quiz->course_id, $quiz->id]);
                    $actionLabel = __('Lihat Hasil');
                } elseif ($status === 'upcoming') {
                    $actionUrl = '#';
                    $actionLabel = __('Belum Dibuka');
                    $isDisabled = true;
                } elseif ($status === 'closed') {
                    $actionUrl = route($isPractice ? 'practice.result' : 'quiz.result', [$quiz->course_id, $quiz->id]);
                    $actionLabel = __('Sudah Ditutup');
                    $isDisabled = true;
                } else {
                    $actionUrl = route($isPractice ? 'practice.start' : 'quiz.start', [$quiz->course_id, $quiz->id]);
                    $actionLabel = $isFinal ? __('Mulai Ujian') : ($isPractice ? __('Mulai Latihan') : __('Mulai Kuis'));
                }
            } elseif ($user->isInstruktur()) {
                if ($status === 'upcoming') {
                    $actionUrl = route($isPractice ? 'practices.edit' : 'quizzes.edit', [$quiz->course_id, $quiz->id]);
                    $actionLabel = $isPractice ? __('Edit Latihan') : __('Edit Kuis');
                } else {
                    $actionUrl = route($isPractice ? 'practices.attempts' : 'quizzes.attempts', [$quiz->course_id, $quiz->id]);
                    $actionLabel = __('Hasil Peserta');
                }
            }

            // Case A: Both start & end fall on the exact same date -> Combine into 1 single event card
            if ($startTime && $endTime && $startTime->toDateString() === $endTime->toDateString()) {
                $dateKey = $startTime->toDateString();
                $badgeText = $isPractice ? __('Latihan') : ($isFinal ? __('Ujian Akhir') : __('Kuis'));
                $color = $isPractice ? 'blue' : ($isFinal ? 'amber' : 'emerald');
                $timeStr = $startTime->format('H:i') . ' - ' . $endTime->format('H:i') . ' WIB';

                $events[$dateKey][] = [
                    'id' => 'quiz-single-' . $quiz->id,
                    'quiz_id' => $quiz->id,
                    'title' => $quiz->title,
                    'course_title' => $courseName,
                    'chapter_title' => $chapterName,
                    'type' => $type,
                    'badge_text' => $badgeText,
                    'status' => $status,
                    'status_badge' => $statusBadge,
                    'time_str' => $timeStr,
                    'color' => $color,
                    'description' => __('Waktu pengerjaan dibuka dari :start sampai :end WIB.', ['start' => $startTime->format('H:i'), 'end' => $endTime->format('H:i')]),
                    'action_url' => $actionUrl,
                    'action_label' => $actionLabel,
                    'is_disabled' => $isDisabled,
                ];
            } else {
                // Case B: Start and End are on different dates -> Create separate start and end event markers
                if ($startTime) {
                    $dateKey = $startTime->toDateString();
                    $badgeText = $isPractice ? __('Latihan (Dibuka)') : ($isFinal ? __('Ujian (Dibuka)') : __('Kuis (Dibuka)'));
                    $color = $isPractice ? 'blue' : ($isFinal ? 'amber' : 'emerald');

                    $events[$dateKey][] = [
                        'id' => 'quiz-start-' . $quiz->id,
                        'quiz_id' => $quiz->id,
                        'title' => $quiz->title,
                        'course_title' => $courseName,
                        'chapter_title' => $chapterName,
                        'type' => $type,
                        'badge_text' => $badgeText,
                        'status' => $status,
                        'status_badge' => $statusBadge,
                        'time_str' => $startTime->format('H:i') . ' WIB',
                        'color' => $color,
                        'description' => $quiz->description ?: __('Pembukaan waktu pengerjaan evaluasi.'),
                        'action_url' => $actionUrl,
                        'action_label' => $actionLabel,
                        'is_disabled' => $isDisabled,
                    ];
                }

                if ($endTime) {
                    $dateKey = $endTime->toDateString();
                    $badgeText = $isPractice ? __('Latihan (Tenggat)') : ($isFinal ? __('Ujian (Tenggat)') : __('Kuis (Tenggat)'));
                    $color = 'rose';

                    $events[$dateKey][] = [
                        'id' => 'quiz-end-' . $quiz->id,
                        'quiz_id' => $quiz->id,
                        'title' => $quiz->title,
                        'course_title' => $courseName,
                        'chapter_title' => $chapterName,
                        'type' => $type,
                        'badge_text' => $badgeText,
                        'status' => $status,
                        'status_badge' => $statusBadge,
                        'time_str' => $endTime->format('H:i') . ' WIB',
                        'color' => $color,
                        'description' => __('Batas akhir pengumpulan / pengerjaan evaluasi.'),
                        'action_url' => $actionUrl,
                        'action_label' => $actionLabel,
                        'is_disabled' => $isDisabled,
                    ];
                }
            }
        }

        // 2. Chapters & Course Materials (Untimed / Weekly study milestones)
        $chapters = Chapter::with('course')->get();
        foreach ($chapters as $chapter) {
            $chapterDate = Carbon::parse($chapter->created_at)->timezone('Asia/Jakarta');
            if ($chapterDate->between($startOfGrid, $endOfGrid)) {
                $dateKey = $chapterDate->toDateString();
                $events[$dateKey][] = [
                    'id' => 'chapter-' . $chapter->id,
                    'title' => $chapter->title,
                    'course_title' => $chapter->course ? $chapter->course->title : __('Materi Garbarata'),
                    'chapter_title' => __('Chapter :order', ['order' => $chapter->order]),
                    'type' => 'material',
                    'badge_text' => __('Materi Rilis'),
                    'time_str' => $chapterDate->format('H:i') . ' WIB',
                    'color' => 'indigo',
                    'description' => __('Materi pembelajaran bab :order telah dirilis.', ['order' => $chapter->order]),
                    'action_url' => route('courses.chapters.show', [$chapter->course_id, $chapter->id]),
                    'action_label' => __('Pelajari Materi'),
                ];
            }
        }

        // Event counts summary for header cards (Count UNIQUE items)
        $uniqueQuizzesInMonth = [];
        $uniquePracticesInMonth = [];
        $uniqueMaterialsInMonth = [];

        foreach ($events as $dateStr => $dayEvents) {
            $eDate = Carbon::parse($dateStr);
            if ($eDate->month === $month && $eDate->year === $year) {
                foreach ($dayEvents as $ev) {
                    if ($ev['type'] === 'quiz' || $ev['type'] === 'exam') {
                        if (isset($ev['quiz_id'])) {
                            $uniqueQuizzesInMonth[$ev['quiz_id']] = true;
                        }
                    } elseif ($ev['type'] === 'practice') {
                        if (isset($ev['quiz_id'])) {
                            $uniquePracticesInMonth[$ev['quiz_id']] = true;
                        }
                    } else {
                        $uniqueMaterialsInMonth[$ev['id']] = true;
                    }
                }
            }
        }

        $quizCount = count($uniqueQuizzesInMonth);
        $practiceCount = count($uniquePracticesInMonth);
        $materialCount = count($uniqueMaterialsInMonth);
        $totalMonthEvents = $quizCount + $practiceCount + $materialCount;

        return view('calendar.index', compact(
            'user',
            'month',
            'year',
            'currentMonthDate',
            'prevMonthDate',
            'nextMonthDate',
            'gridWeeks',
            'events',
            'totalMonthEvents',
            'quizCount',
            'practiceCount',
            'materialCount'
        ));
    }
}
