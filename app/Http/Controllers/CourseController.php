<?php

namespace App\Http\Controllers;

use App\LearningProgress;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\Module;
use App\Models\ModuleProgress;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display the course syllabus (chapters listing).
     */
    public function show(Course $course)
    {
        // Load chapters along with module counts
        $course->load(['chapters' => function ($query) {
            $query->with('modules')->withCount('modules')->orderBy('order');
        }]);

        $learningProgress = auth()->user()->isPeserta()
            ? LearningProgress::forUser(auth()->user(), $course)
            : null;

        return view('courses.show', compact('course', 'learningProgress'));
    }

    /**
     * Display the interactive study room for a specific chapter.
     */
    public function showChapter(Course $course, $chapterId)
    {
        $learningProgress = auth()->user()->isPeserta()
            ? LearningProgress::forUser(auth()->user(), $course)
            : null;

        if ($learningProgress) {
            $selectedProgress = LearningProgress::chapterProgress($learningProgress['chapters'], (int) $chapterId);

            if (! $selectedProgress || ! $selectedProgress['is_unlocked']) {
                return redirect()
                    ->route('courses.show', $course)
                    ->with('error', 'Bab ini masih terkunci. Selesaikan semua materi pada bab sebelumnya terlebih dahulu.');
            }
        }

        // Fetch the specific chapter belonging to this course
        $chapter = Chapter::with(['modules', 'diagram.hotspots'])->where('course_id', $course->id)->findOrFail($chapterId);
        
        // Fetch all other chapters of the course for the sidebar/navigation
        $chapters = $course->chapters()->orderBy('order')->get();

        $diagram = $chapter->diagram;
        $modules = $chapter->modules;

        // Quiz untuk chapter ini (jika ada)
        $chapterQuiz = Quiz::where('course_id', $course->id)->where('activity_type', 'quiz')
                           ->where('chapter_id', $chapter->id)
                           ->where('is_active', true)
                           ->withCount('questions')
                           ->first();

        // Final Quiz (jika ada dan semua chapter sudah selesai)
        $finalQuiz = Quiz::where('course_id', $course->id)->where('activity_type', 'quiz')
                         ->whereNull('chapter_id')
                         ->where('is_active', true)
                         ->withCount('questions')
                         ->first();

        // Status attempt user untuk quiz ini
        $userId = auth()->id();
        $chapterQuizAttempt = $chapterQuiz
            ? $chapterQuiz->bestAttemptFor($userId)
            : null;

        $finalQuizAttempt = $finalQuiz
            ? $finalQuiz->bestAttemptFor($userId)
            : null;

        $practices = Quiz::where('course_id', $course->id)->where('chapter_id', $chapter->id)
            ->where('activity_type', 'practice')->where('is_active', true)->withCount('questions')->orderBy('order')->get();
        $practiceAttempts = QuizAttempt::where('user_id', $userId)->whereIn('quiz_id', $practices->pluck('id'))
            ->whereNotNull('submitted_at')->orderByDesc('submitted_at')->get()->unique('quiz_id')->keyBy('quiz_id');

        // Sertifikat user untuk course ini
        $certificate = Certificate::where('user_id', $userId)
                                  ->where('course_id', $course->id)
                                  ->first();

        return view('courses.study', [
            'course'             => $course,
            'chapter'            => $chapter,
            'chapters'           => $chapters,
            'diagram'            => $diagram,
            'modules'            => $modules,
            'learningProgress'   => $learningProgress,
            'chapterQuiz'        => $chapterQuiz,
            'finalQuiz'          => $finalQuiz,
            'chapterQuizAttempt' => $chapterQuizAttempt,
            'finalQuizAttempt'   => $finalQuizAttempt,
            'certificate'        => $certificate,
            'practices'          => $practices,
            'practiceAttempts'   => $practiceAttempts,
        ]);
    }

    /** Semua aktivitas latihan dan quiz peserta, termasuk yang belum dikerjakan. */
    public function activities(Course $course)
    {
        abort_unless(auth()->user()->isPeserta(), 403);
        $activities = $course->quizzes()->with('chapter')->where('is_active', true)
            ->withCount('questions')->orderBy('activity_type')->orderBy('chapter_id')->orderBy('order')->get();
        $lastAttempts = QuizAttempt::where('user_id', auth()->id())->whereIn('quiz_id', $activities->pluck('id'))
            ->whereNotNull('submitted_at')->orderByDesc('submitted_at')->get()->unique('quiz_id')->keyBy('quiz_id');
        return view('courses.activities', compact('course', 'activities', 'lastAttempts'));
    }

    public function completeModule(Request $request, Course $course, Chapter $chapter, Module $module)
    {
        abort_unless(auth()->user()->isPeserta(), 403);
        abort_unless($chapter->course_id === $course->id && $module->chapter_id === $chapter->id, 404);

        $learningProgress = LearningProgress::forUser(auth()->user(), $course);
        $chapterProgress = LearningProgress::chapterProgress($learningProgress['chapters'], $chapter->id);

        abort_unless($chapterProgress && $chapterProgress['is_unlocked'], 403);

        ModuleProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'module_id' => $module->id,
            ],
            [
                'completed_at' => now(),
            ]
        );

        $updatedProgress = LearningProgress::forUser(auth()->user(), $course);

        return response()->json([
            'material_percent' => $updatedProgress['percent'],
            'chapter_percent' => LearningProgress::chapterProgress($updatedProgress['chapters'], $chapter->id)['percent'] ?? 0,
        ]);
    }
}
