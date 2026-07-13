<?php

namespace App;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Collection;

class LearningProgress
{
    public static function forUser(User $user, ?Course $course = null): array
    {
        $course ??= Course::with(['chapters.modules'])->orderBy('id')->first();

        if (! $course) {
            return [
                'percent' => 0,
                'completedModules' => collect(),
                'chapters' => collect(),
                'notes' => collect(),
            ];
        }

        $course->loadMissing(['chapters.modules']);
        $completedModuleIds = $user->moduleProgress()->pluck('module_id');
        $totalModules = $course->chapters->flatMap->modules->count();
        $completedCount = $course->chapters->flatMap->modules->whereIn('id', $completedModuleIds)->count();
        $activeChapterQuizIds = Quiz::where('course_id', $course->id)
            ->where('activity_type', 'quiz')
            ->whereNotNull('chapter_id')
            ->where('is_active', true)
            ->pluck('id', 'chapter_id');
        $passedQuizIds = QuizAttempt::where('user_id', $user->id)
            ->where('is_passed', true)
            ->whereIn('quiz_id', $activeChapterQuizIds->values())
            ->pluck('quiz_id');
        $previousComplete = true;
        $notes = collect();

        $chapters = $course->chapters->map(function ($chapter) use ($completedModuleIds, $activeChapterQuizIds, $passedQuizIds, &$previousComplete, $notes) {
            $modules = $chapter->modules;
            $completedModules = $modules->whereIn('id', $completedModuleIds)->count();
            $missingModules = $modules->whereNotIn('id', $completedModuleIds)->values();
            $isUnlocked = $previousComplete;
            $materialComplete = $modules->count() > 0 && $missingModules->isEmpty();
            $chapterQuizId = $activeChapterQuizIds->get($chapter->id);
            $hasChapterQuiz = ! is_null($chapterQuizId);
            $quizPassed = ! $hasChapterQuiz || $passedQuizIds->contains($chapterQuizId);
            $isComplete = $materialComplete && $quizPassed;

            foreach ($missingModules as $module) {
                $notes->push("Lengkapi pembelajaran BAB {$chapter->order} untuk module {$module->title}.");
            }
            if ($materialComplete && $hasChapterQuiz && ! $quizPassed) {
                $notes->push("Selesaikan Quiz Chapter BAB {$chapter->order} untuk membuka bab berikutnya.");
            }

            $previousComplete = $isComplete;

            return [
                'id' => $chapter->id,
                'order' => $chapter->order,
                'title' => $chapter->title,
                'total_modules' => $modules->count(),
                'completed_modules' => $completedModules,
                'missing_modules' => $missingModules,
                'is_unlocked' => $isUnlocked,
                'is_complete' => $isComplete,
                'material_complete' => $materialComplete,
                'has_chapter_quiz' => $hasChapterQuiz,
                'quiz_passed' => $quizPassed,
                'percent' => $modules->count() > 0 ? (int) round(($completedModules / $modules->count()) * 100) : 0,
            ];
        });

        return [
            'percent' => $totalModules > 0 ? (int) round(($completedCount / $totalModules) * 100) : 0,
            'completedModules' => $completedModuleIds,
            'chapters' => $chapters,
            'notes' => $notes,
        ];
    }

    public static function chapterProgress(Collection $chapters, int $chapterId): ?array
    {
        return $chapters->firstWhere('id', $chapterId);
    }
}
