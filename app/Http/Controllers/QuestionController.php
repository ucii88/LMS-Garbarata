<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Halaman kelola bank soal per chapter.
     */
    public function index(Course $course, Chapter $chapter)
    {
        $questions = $chapter->questions()
                             ->with('options')
                             ->orderBy('order')
                             ->get();

        return view('questions.index', compact('course', 'chapter', 'questions'));
    }

    /**
     * Simpan soal baru ke bank soal chapter.
     */
    public function store(Request $request, Course $course, Chapter $chapter)
    {
        $validated = $request->validate([
            'question_text'         => 'required|string',
            'question_image'        => 'nullable|image|max:2048',
            'type'                  => 'required|in:multiple_choice,true_false,essay,matching,ordering',
            'points'                => 'required|integer|min:1',
            'explanation'           => 'nullable|string',
            'topic_tag'             => 'nullable|string|max:100',
            // Pilihan jawaban (tidak diperlukan untuk tipe essay)
            'options'               => $request->input('type') === 'essay' ? 'nullable|array' : 'required|array|min:1',
            'options.*.text'        => 'required_unless:type,essay|string',
            'options.*.image'       => 'nullable|image|max:2048',
            'options.*.is_correct'  => 'nullable|boolean',
            'options.*.match_label' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $request, $course, $chapter) {
            // Upload gambar soal
            $imagePath = null;
            if ($request->hasFile('question_image')) {
                $imagePath = $request->file('question_image')->store('questions', 'public');
            }

            $maxOrder = $chapter->questions()->max('order') ?? 0;

            $question = Question::create([
                'course_id'      => $course->id,
                'chapter_id'     => $chapter->id,
                'question_text'  => $validated['question_text'],
                'question_image' => $imagePath,
                'type'           => $validated['type'],
                'points'         => $validated['points'],
                'explanation'    => $validated['explanation'] ?? null,
                'topic_tag'      => $validated['topic_tag'] ?? null,
                'order'          => $maxOrder + 1,
            ]);

            // Simpan pilihan jawaban (tidak untuk tipe essay)
            if ($validated['type'] !== 'essay') {
                foreach ($validated['options'] ?? [] as $i => $opt) {
                    $optImagePath = null;
                    if ($request->hasFile("options.{$i}.image")) {
                        $optImagePath = $request->file("options.{$i}.image")->store('question-options', 'public');
                    }

                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $opt['text'],
                        'option_image' => $optImagePath,
                        'is_correct'  => isset($opt['is_correct']) ? (bool) $opt['is_correct'] : false,
                        'match_label' => $opt['match_label'] ?? null,
                        'order'       => $i,
                    ]);
                }
            }
        });

        return back()->with('success', 'Soal berhasil ditambahkan ke bank soal.');
    }

    /**
     * Update soal yang ada di bank soal.
     */
    public function update(Request $request, Course $course, Chapter $chapter, Question $question)
    {
        $validated = $request->validate([
            'question_text'         => 'required|string',
            'question_image'        => 'nullable|image|max:2048',
            'type'                  => 'required|in:multiple_choice,true_false,essay,matching,ordering',
            'points'                => 'required|integer|min:1',
            'explanation'           => 'nullable|string',
            'topic_tag'             => 'nullable|string|max:100',
            // Pilihan jawaban (tidak diperlukan untuk tipe essay)
            'options'               => $request->input('type') === 'essay' ? 'nullable|array' : 'required|array|min:1',
            'options.*.id'          => 'nullable|integer|exists:question_options,id',
            'options.*.text'        => 'required_unless:type,essay|string',
            'options.*.image'       => 'nullable|image|max:2048',
            'options.*.is_correct'  => 'nullable|boolean',
            'options.*.match_label' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $request, $question) {
            // Update gambar soal
            $deleteImage = $request->boolean('delete_image');
            if ($deleteImage || $request->hasFile('question_image')) {
                if ($question->question_image) {
                    Storage::disk('public')->delete($question->question_image);
                    $question->question_image = null;
                }
            }

            if ($request->hasFile('question_image')) {
                $question->question_image = $request->file('question_image')->store('questions', 'public');
            }

            $question->update([
                'question_text' => $validated['question_text'],
                'type'          => $validated['type'],
                'points'        => $validated['points'],
                'explanation'   => $validated['explanation'] ?? null,
                'topic_tag'     => $validated['topic_tag'] ?? null,
                'question_image' => $question->question_image,
            ]);

            // Hapus opsi lama, buat ulang (tidak untuk tipe essay)
            $question->options()->delete();

            if ($validated['type'] !== 'essay') {
                foreach ($validated['options'] ?? [] as $i => $opt) {
                    $optImagePath = null;
                    if ($request->hasFile("options.{$i}.image")) {
                        $optImagePath = $request->file("options.{$i}.image")->store('question-options', 'public');
                    }

                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $opt['text'],
                        'option_image' => $optImagePath,
                        'is_correct'  => isset($opt['is_correct']) ? (bool) $opt['is_correct'] : false,
                        'match_label' => $opt['match_label'] ?? null,
                        'order'       => $i,
                    ]);
                }
            }
        });

        // Perubahan poin dapat membuat aktivitas yang sudah dipublikasikan tidak lagi berjumlah 100.
        // Aktivitas tersebut otomatis kembali menjadi draft sampai instruktur mempublikasikannya lagi.
        Quiz::whereHas('questions', fn ($query) => $query->where('questions.id', $question->id))
            ->where('is_active', true)
            ->get()
            ->each(function (Quiz $quiz) {
                if ($quiz->questions()->sum('points') !== 100) {
                    $quiz->update(['is_active' => false]);
                }
            });

        $returnTo = $request->input('return_to');
        if ($returnTo && str_starts_with($returnTo, url('/courses/' . $course->id))) {
            return redirect()->to($returnTo)->with('success', 'Soal berhasil diperbarui.');
        }

        return back()->with('success', 'Soal berhasil diperbarui.');
    }

    /**
     * Hapus soal dari bank soal.
     */
    public function destroy(Course $course, Chapter $chapter, Question $question)
    {
        // Hapus gambar jika ada
        if ($question->question_image) {
            Storage::disk('public')->delete($question->question_image);
        }

        $question->delete();

        return back()->with('success', 'Soal berhasil dihapus dari bank soal.');
    }
}
