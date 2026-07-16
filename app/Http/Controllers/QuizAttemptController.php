<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Notification;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizAttemptController extends Controller
{
    private function routeName(Quiz $quiz, string $action): string
    {
        return ($quiz->isPractice() ? 'practice.' : 'quiz.') . $action;
    }

    private function ensureCorrectActivityRoute(Quiz $quiz): void
    {
        abort_if($quiz->isPractice() !== request()->routeIs('practice.*'), 404);
    }
    /**
     * Halaman info sebelum mulai quiz.
     */
    public function start(Course $course, Quiz $quiz)
    {
        abort_if($quiz->course_id !== $course->id, 403);
        abort_if(!$quiz->is_active, 404);
        $this->ensureCorrectActivityRoute($quiz);

        $user = Auth::user();
        $attemptCount = $quiz->attemptCountFor($user->id);
        $canAttempt   = $quiz->canAttempt($user->id);
        $bestAttempt  = $quiz->bestAttemptFor($user->id);
        $questionCount = $quiz->questions()->count();

        // Cek apakah ada attempt yang belum selesai (in-progress)
        $ongoingAttempt = QuizAttempt::where('user_id', $user->id)
                                     ->where('quiz_id', $quiz->id)
                                     ->whereNull('submitted_at')
                                     ->latest()
                                     ->first();

        return view('quiz-attempt.start', compact(
            'course', 'quiz', 'attemptCount', 'canAttempt',
            'bestAttempt', 'questionCount', 'ongoingAttempt'
        ));
    }

    /**
     * Mulai quiz — buat attempt baru.
     */
    public function begin(Request $request, Course $course, Quiz $quiz)
    {
        abort_if($quiz->course_id !== $course->id, 403);
        abort_if(!$quiz->is_active, 404);
        $this->ensureCorrectActivityRoute($quiz);

        if (!$quiz->isPractice() && $quiz->availability_status === 'upcoming') {
            return redirect()->route($this->routeName($quiz, 'start'), [$course, $quiz])
                             ->withErrors(['msg' => 'Quiz belum dibuka. Silakan tunggu hingga jadwal yang ditentukan.']);
        }

        if (!$quiz->isPractice() && $quiz->availability_status === 'closed') {
            return redirect()->route($this->routeName($quiz, 'start'), [$course, $quiz])
                             ->withErrors(['msg' => 'Quiz sudah ditutup dan tidak dapat dikerjakan lagi.']);
        }

        $user = Auth::user();

        if (!$quiz->canAttempt($user->id)) {
            return redirect()->route($this->routeName($quiz, 'start'), [$course, $quiz])
                             ->withErrors(['msg' => 'Kamu sudah mencapai batas percobaan untuk quiz ini.']);
        }

        // Batalkan attempt yang belum selesai jika ada
        QuizAttempt::where('user_id', $user->id)
                   ->where('quiz_id', $quiz->id)
                   ->whereNull('submitted_at')
                   ->delete();

        $attemptNumber = $quiz->attemptCountFor($user->id) + 1;

        $attempt = QuizAttempt::create([
            'user_id'        => $user->id,
            'quiz_id'        => $quiz->id,
            'attempt_number' => $attemptNumber,
            'started_at'     => now(),
        ]);

        return redirect()->route($this->routeName($quiz, 'attempt'), [$course, $quiz]);
    }

    /**
     * Halaman pengerjaan soal.
     */
    public function attempt(Course $course, Quiz $quiz)
    {
        abort_if($quiz->course_id !== $course->id, 403);
        $this->ensureCorrectActivityRoute($quiz);

        $user = Auth::user();

        // Ambil attempt yang sedang berjalan
        $attempt = QuizAttempt::where('user_id', $user->id)
                               ->where('quiz_id', $quiz->id)
                               ->whereNull('submitted_at')
                               ->latest()
                               ->firstOrFail();

        // Ambil soal — shuffle jika diaktifkan
        $questions = $quiz->questions()->with('options')->get();
        if ($quiz->shuffle_questions) {
            $questions = $questions->shuffle();
        }
        if ($quiz->shuffle_options) {
            $questions = $questions->map(function ($q) {
                $q->setRelation('options', $q->options->shuffle());
                return $q;
            });
        }

        // Jawaban yang sudah diisi (untuk auto-save/resume)
        $savedAnswers = $attempt->answers()->get()->keyBy('question_id');

        // Hitung sisa waktu jika ada timer
        $timeRemainingSeconds = null;
        if ($quiz->time_limit) {
            $elapsed = (int) abs(now()->diffInSeconds($attempt->started_at, true));
            $timeRemainingSeconds = max(0, ($quiz->time_limit * 60) - $elapsed);
        }

        return view('quiz-attempt.attempt', compact(
            'course', 'quiz', 'attempt', 'questions', 'savedAnswers', 'timeRemainingSeconds'
        ));
    }

    /**
     * Auto-save jawaban satu soal (AJAX).
     */
    public function saveAnswer(Request $request, Course $course, Quiz $quiz)
    {
        abort_if($quiz->course_id !== $course->id, 403);
        $this->ensureCorrectActivityRoute($quiz);
        $user = Auth::user();

        $attempt = QuizAttempt::where('user_id', $user->id)
                               ->where('quiz_id', $quiz->id)
                               ->whereNull('submitted_at')
                               ->latest()
                               ->firstOrFail();

        $validated = $request->validate([
            'question_id'        => 'required|exists:questions,id',
            'selected_option_id' => 'nullable|exists:question_options,id',
            'text_answer'        => 'nullable|string',
            'order_answer'       => 'nullable|array',
        ]);

        QuizAnswer::updateOrCreate(
            ['attempt_id' => $attempt->id, 'question_id' => $validated['question_id']],
            [
                'selected_option_id' => $validated['selected_option_id'] ?? null,
                'text_answer'        => $validated['text_answer'] ?? null,
                'order_answer'       => $validated['order_answer'] ?? null,
                'is_correct'         => false,
                'points_earned'      => 0,
            ]
        );

        return response()->json(['status' => 'saved']);
    }

    /**
     * Submit semua jawaban dan hitung skor.
     */
    public function submit(Request $request, Course $course, Quiz $quiz)
    {
        abort_if($quiz->course_id !== $course->id, 403);
        $this->ensureCorrectActivityRoute($quiz);
        $user = Auth::user();

        $attempt = QuizAttempt::where('user_id', $user->id)
                               ->where('quiz_id', $quiz->id)
                               ->whereNull('submitted_at')
                               ->latest()
                               ->firstOrFail();

        // Cek timer — auto-submit jika waktu habis
        if ($quiz->time_limit) {
            $elapsed = (int) abs(now()->diffInSeconds($attempt->started_at, true));
            $timeLimit = $quiz->time_limit * 60;
            if ($elapsed > $timeLimit + 30) { // 30 detik toleransi
                // Waktu sudah habis, submit apa adanya
            }
        }

        DB::transaction(function () use ($request, $quiz, $attempt, $user, $course) {
            $questions     = $quiz->questions()->with('options', 'correctOptions')->get();
            $totalPoints = 0;
            $hasEssay    = false;
            foreach ($questions as $question) {
                if ($question->type === 'matching' || $question->type === 'ordering') {
                    $totalPoints += $question->options->count() * $question->points;
                } else {
                    $totalPoints += $question->points;
                }
            }
            $earnedPoints  = 0;
            $timeSpent     = (int) abs(now()->diffInSeconds($attempt->started_at, true));

            foreach ($questions as $question) {
                $answerData = [
                    'attempt_id'         => $attempt->id,
                    'question_id'        => $question->id,
                    'selected_option_id' => null,
                    'text_answer'        => null,
                    'order_answer'       => null,
                    'is_correct'         => false,
                    'points_earned'      => 0,
                ];

                $isCorrect    = false;
                $pointsEarned = 0;

                $rawAnswer = $request->input("answers.{$question->id}");

                switch ($question->type) {
                    case 'multiple_choice':
                    case 'true_false':
                        $optionId = $rawAnswer ? (int) $rawAnswer : null;
                        if ($optionId) {
                            $option = $question->options->firstWhere('id', $optionId);
                            $isCorrect = $option && $option->is_correct;
                            $pointsEarned = $isCorrect ? $question->points : 0;
                        }
                        $answerData['selected_option_id'] = $optionId;
                        break;

                    case 'essay':
                        // Esai dinilai manual oleh instruktur — simpan jawaban saja
                        $answerData['text_answer'] = $rawAnswer ?? null;
                        $answerData['is_correct']  = null; // belum bisa ditentukan
                        $answerData['points_earned'] = 0;
                        $hasEssay = true;
                        break;

                    case 'matching':
                        // rawAnswer = ['option_id' => 'match_target_label', ...]
                        $matchAnswers = is_array($rawAnswer) ? $rawAnswer : [];
                        $correctCount = 0;
                        $totalOptions = $question->options->count();
                        
                        foreach ($question->options as $option) {
                            $userMatch = $matchAnswers[$option->id] ?? null;
                            if ($userMatch === $option->match_label) {
                                $correctCount++;
                            }
                        }
                        
                        $isCorrect = ($correctCount === $totalOptions) && ($totalOptions > 0);
                        // Poin parsial: jumlah pasangan benar dikalikan poin per pasangan
                        $pointsEarned = $correctCount * $question->points;
                        
                        $answerData['order_answer'] = $matchAnswers;
                        break;

                    case 'ordering':
                        // rawAnswer = [1, 3, 2, 4] (array of option IDs dalam urutan user)
                        $userOrder   = is_array($rawAnswer) ? array_map('intval', $rawAnswer) : [];
                        $correctOrder = $question->options->sortBy('order')->pluck('id')->toArray();
                        
                        $correctCount = 0;
                        $totalSteps = count($correctOrder);
                        
                        for ($stepIdx = 0; $stepIdx < $totalSteps; $stepIdx++) {
                            if (isset($userOrder[$stepIdx]) && $userOrder[$stepIdx] === $correctOrder[$stepIdx]) {
                                $correctCount++;
                            }
                        }
                        
                        $isCorrect = ($correctCount === $totalSteps) && ($totalSteps > 0);
                        // Poin parsial: jumlah langkah benar dikalikan poin per langkah
                        $pointsEarned = $correctCount * $question->points;
                        
                        $answerData['order_answer'] = $userOrder;
                        break;
                }

                $answerData['is_correct']    = $isCorrect;
                $answerData['points_earned'] = $pointsEarned;
                $earnedPoints += $pointsEarned;

                QuizAnswer::updateOrCreate(
                    ['attempt_id' => $attempt->id, 'question_id' => $question->id],
                    $answerData
                );
            }

            // Hitung skor sementara (hanya dari soal non-esai)
            // Soal esai akan ditambahkan setelah instruktur menilai
            $gradingStatus = $hasEssay ? 'pending_essay' : 'auto';

            $score = $totalPoints > 0
                ? round(($earnedPoints / $totalPoints) * 100, 2)
                : 0;

            // Jika ada esai, skor belum final (akan dihitung ulang setelah grading)
            $isPassed = !$hasEssay && !$quiz->isPractice() && $score >= $quiz->passing_score;

            $attempt->update([
                'submitted_at'   => now(),
                'score'          => $score,
                'is_passed'      => $isPassed,
                'grading_status' => $gradingStatus,
                'time_spent'     => $timeSpent,
            ]);

            // Coba terbitkan sertifikat hanya jika tidak ada esai yang pending
            if ($isPassed && !$hasEssay && !$quiz->isPractice()) {
                Certificate::tryIssue($user->id, $course->id);
            }

            // Kirim notifikasi ke instruktur
            $quiz->load(['course', 'chapter']);
            Notification::notifySubmission($attempt, $quiz, $user);
        });

        if ($quiz->isPractice()) {
            return redirect()->route('courses.practices', $course)
                ->with('success', 'Latihan selesai. Nilai terakhir kamu: ' . number_format($attempt->fresh()->score, 0) . '%.');
        }

        return redirect()->route('quiz.result', [$course, $quiz]);
    }

    /**
     * Halaman hasil quiz.
     */
    public function result(Course $course, Quiz $quiz)
    {
        abort_if($quiz->course_id !== $course->id, 403);
        $this->ensureCorrectActivityRoute($quiz);
        $user = Auth::user();

        // Ambil attempt terakhir yang sudah di-submit
        $attempt = QuizAttempt::where('user_id', $user->id)
                               ->where('quiz_id', $quiz->id)
                               ->whereNotNull('submitted_at')
                               ->with(['answers.question.options', 'answers.selectedOption', 'answers.gradedBy'])
                               ->latest('submitted_at')
                               ->firstOrFail();

        $certificate = $quiz->isPractice() ? null : Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)->first();

        return view('quiz-attempt.result', compact('course', 'quiz', 'attempt', 'certificate'));
    }
}
