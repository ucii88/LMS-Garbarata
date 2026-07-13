<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Certificate;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private function isPracticeRequest(): bool
    {
        return request()->routeIs('practices.*');
    }

    private function activityRoute(string $name, Course $course, Quiz $quiz = null): string
    {
        $prefix = ($quiz?->isPractice() ?? $this->isPracticeRequest()) ? 'practices.' : 'quizzes.';
        return route($prefix . $name, $quiz ? [$course, $quiz] : $course);
    }
    /**
     * Daftar semua quiz dalam course.
     */
    public function index(Course $course)
    {
        $isPractice = $this->isPracticeRequest();
        $quizzes = $course->quizzes()
                          ->where('activity_type', $isPractice ? 'practice' : 'quiz')
                          ->with('chapter')
                          ->withCount('questions')
                          ->orderBy('order')
                          ->get();

        return view('quizzes.index', compact('course', 'quizzes', 'isPractice'));
    }

    /**
     * Form buat quiz baru.
     */
    public function create(Course $course)
    {
        $isPractice = $this->isPracticeRequest();
        $chapters = $course->chapters()->orderBy('order')->get();

        return view('quizzes.create', compact('course', 'chapters', 'isPractice'));
    }

    /**
     * Simpan quiz baru.
     */
    public function store(Request $request, Course $course)
    {
        $isPractice = $this->isPracticeRequest();
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'chapter_id'        => 'nullable|exists:chapters,id',
            'time_limit'        => 'nullable|integer|min:1|max:300',
            'passing_score'     => $isPractice ? 'nullable' : 'required|integer|min:1|max:100',
            'max_attempts'      => $isPractice ? 'nullable|integer|min:1|max:100' : 'required|integer|min:1|max:10',
            'shuffle_questions' => 'nullable|boolean',
            'shuffle_options'   => 'nullable|boolean',
            'review_policy'     => 'required|in:show_all,points_only,hide_all',
            'is_active'         => 'nullable|boolean',
        ]);

        // Pastikan chapter_id milik course ini
        if (!empty($validated['chapter_id'])) {
            $chapter = Chapter::findOrFail($validated['chapter_id']);
            abort_if($chapter->course_id !== $course->id, 403);
        }
        if ($isPractice && empty($validated['chapter_id'])) {
            return back()->withErrors(['chapter_id' => 'Latihan harus ditempatkan pada sebuah chapter.'])->withInput();
        }

        $maxOrder = $course->quizzes()->max('order') ?? 0;

        Quiz::create([
            'course_id'         => $course->id,
            'chapter_id'        => $validated['chapter_id'] ?? null,
            'activity_type'     => $isPractice ? 'practice' : 'quiz',
            'title'             => $validated['title'],
            'description'       => $validated['description'] ?? null,
            'time_limit'        => $isPractice ? null : ($validated['time_limit'] ?? null),
            'passing_score'     => $isPractice ? 0 : $validated['passing_score'],
            'max_attempts'      => $validated['max_attempts'] ?? null,
            'shuffle_questions' => $request->boolean('shuffle_questions'),
            'shuffle_options'   => $request->boolean('shuffle_options'),
            'review_policy'     => $validated['review_policy'],
            'is_active'         => $request->boolean('is_active', true),
            'order'             => $maxOrder + 1,
        ]);

        return redirect($this->activityRoute('index', $course))
                         ->with('success', ($isPractice ? 'Latihan' : 'Quiz') . ' berhasil dibuat. Sekarang tambahkan soal dari bank soal.');
    }

    /**
     * Form edit quiz + pilih soal dari bank.
     */
    public function edit(Course $course, Quiz $quiz)
    {
        abort_if($quiz->course_id !== $course->id, 403);
        abort_if($quiz->isPractice() !== $this->isPracticeRequest(), 404);
        $isPractice = $quiz->isPractice();

        $chapters = $course->chapters()->orderBy('order')->get();

        // Soal dari bank yang tersedia untuk quiz ini
        $availableQuestions = $quiz->getAvailableBankQuery()
                                   ->with('options', 'chapter')
                                   ->orderBy('chapter_id')
                                   ->orderBy('order')
                                   ->get();

        // ID soal yang sudah dipilih untuk quiz ini
        $selectedQuestionIds = $quiz->questions()->pluck('questions.id')->toArray();

        return view('quizzes.edit', compact(
            'course', 'quiz', 'chapters', 'availableQuestions', 'selectedQuestionIds', 'isPractice'
        ));
    }

    /**
     * Update konfigurasi quiz.
     */
    public function update(Request $request, Course $course, Quiz $quiz)
    {
        abort_if($quiz->course_id !== $course->id, 403);
        abort_if($quiz->isPractice() !== $this->isPracticeRequest(), 404);
        $isPractice = $quiz->isPractice();

        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'chapter_id'        => 'nullable|exists:chapters,id',
            'time_limit'        => 'nullable|integer|min:1|max:300',
            'passing_score'     => $isPractice ? 'nullable' : 'required|integer|min:1|max:100',
            'max_attempts'      => $isPractice ? 'nullable|integer|min:1|max:100' : 'required|integer|min:1|max:10',
            'shuffle_questions' => 'nullable|boolean',
            'shuffle_options'   => 'nullable|boolean',
            'review_policy'     => 'required|in:show_all,points_only,hide_all',
            'is_active'         => 'nullable|boolean',
        ]);

        if (!empty($validated['chapter_id'])) {
            $chapter = Chapter::findOrFail($validated['chapter_id']);
            abort_if($chapter->course_id !== $course->id, 403);
        }
        if ($isPractice && empty($validated['chapter_id'])) {
            return back()->withErrors(['chapter_id' => 'Latihan harus ditempatkan pada sebuah chapter.'])->withInput();
        }

        $quiz->update([
            'chapter_id'        => $validated['chapter_id'] ?? null,
            'title'             => $validated['title'],
            'description'       => $validated['description'] ?? null,
            'time_limit'        => $isPractice ? null : ($validated['time_limit'] ?? null),
            'passing_score'     => $isPractice ? 0 : $validated['passing_score'],
            'max_attempts'      => $validated['max_attempts'] ?? null,
            'shuffle_questions' => $request->boolean('shuffle_questions'),
            'shuffle_options'   => $request->boolean('shuffle_options'),
            'review_policy'     => $validated['review_policy'],
            'is_active'         => $request->boolean('is_active', true),
        ]);

        return redirect($this->activityRoute('edit', $course, $quiz))
                         ->with('success', 'Quiz berhasil diperbarui.');
    }

    /**
     * Sync soal yang dipilih dari bank ke quiz (pivot quiz_questions).
     */
    public function syncQuestions(Request $request, Course $course, Quiz $quiz)
    {
        abort_if($quiz->course_id !== $course->id, 403);
        abort_if($quiz->isPractice() !== $this->isPracticeRequest(), 404);

        $validated = $request->validate([
            'question_ids'   => 'nullable|array',
            'question_ids.*' => 'integer|exists:questions,id',
        ]);

        $questionIds = $validated['question_ids'] ?? [];

        // Validasi: soal harus dari bank yang diizinkan
        if (!empty($questionIds)) {
            $allowedIds = $quiz->getAvailableBankQuery()->pluck('id')->toArray();
            $invalidIds = array_diff($questionIds, $allowedIds);
            if (!empty($invalidIds)) {
                return back()->withErrors(['question_ids' => 'Beberapa soal tidak valid untuk quiz ini.']);
            }
        }

        // Sync dengan urutan
        $syncData = [];
        foreach ($questionIds as $i => $qid) {
            $syncData[$qid] = ['order' => $i + 1];
        }

        $quiz->questions()->sync($syncData);

        return back()->with('success', count($questionIds) . ' soal berhasil disinkronkan ke quiz.');
    }

    /**
     * Hapus quiz.
     */
    public function destroy(Course $course, Quiz $quiz)
    {
        abort_if($quiz->course_id !== $course->id, 403);

        $quiz->delete();

        return redirect($this->activityRoute('index', $course, $quiz))
                         ->with('success', ($quiz->isPractice() ? 'Latihan' : 'Quiz') . ' berhasil dihapus.');
    }

    /**
     * Tampilkan daftar hasil pengerjaan (attempts) peserta untuk quiz ini.
     */
    public function attempts(Course $course, Quiz $quiz)
    {
        abort_if($quiz->course_id !== $course->id, 403);
        abort_if($quiz->isPractice() !== $this->isPracticeRequest(), 404);
        $isPractice = $quiz->isPractice();

        $attempts = QuizAttempt::where('quiz_id', $quiz->id)
                               ->with('user')
                               ->latest()
                               ->get();

        return view('quizzes.attempts', compact('course', 'quiz', 'attempts', 'isPractice'));
    }

    /**
     * Hapus attempt peserta (untuk mereset / memberi kesempatan ujian ulang).
     */
    public function destroyAttempt(Course $course, Quiz $quiz, QuizAttempt $attempt)
    {
        abort_if($quiz->course_id !== $course->id, 403);
        abort_if($attempt->quiz_id !== $quiz->id, 403);

        $userId = $attempt->user_id;
        $attempt->delete();

        // Cabut/hapus sertifikat jika attempt di-reset (karena syarat kelulusan seluruh kuis menjadi tidak terpenuhi lagi)
        if (!$quiz->isPractice()) {
            Certificate::where('user_id', $userId)->where('course_id', $course->id)->delete();
        }

        return back()->with('success', 'Percobaan peserta berhasil di-reset. Peserta sekarang memiliki kesempatan untuk mengerjakan kuis ini kembali dan sertifikat sebelumnya telah dicabut.');
    }
}
