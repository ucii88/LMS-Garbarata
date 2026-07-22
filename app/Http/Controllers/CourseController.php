<?php

namespace App\Http\Controllers;

use App\LearningProgress;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\Diagram;
use App\Models\Hotspot;
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
                    ->with('error', __('Bab ini masih terkunci. Selesaikan materi dan Quiz Chapter pada bab sebelumnya terlebih dahulu.'));
            }
        }

        // Fetch the specific chapter belonging to this course
        $chapter = Chapter::with(['modules.diagram.hotspots', 'diagram.hotspots'])->where('course_id', $course->id)->findOrFail($chapterId);
        
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

        // Ujian (jika ada dan semua chapter sudah selesai)
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

    /** Halaman Quiz Chapter dan Ujian peserta. */
    public function quizActivities(Course $course)
    {
        return $this->activityPage($course, false);
    }

    /** Halaman seluruh latihan mandiri peserta. */
    public function practiceActivities(Course $course)
    {
        return $this->activityPage($course, true);
    }

    /** Rute lama tetap mengarah ke halaman Quiz & Ujian. */
    public function activities(Course $course)
    {
        return redirect()->route('courses.quizzes', $course);
    }

    private function activityPage(Course $course, bool $isPractice)
    {
        abort_unless(auth()->user()->isPeserta(), 403);

        $activities = $course->quizzes()->with('chapter')->where('is_active', true)
            ->where('activity_type', $isPractice ? 'practice' : 'quiz')
            ->withCount('questions')->orderBy('chapter_id')->orderBy('order')->get();
        $lastAttempts = QuizAttempt::where('user_id', auth()->id())->whereIn('quiz_id', $activities->pluck('id'))
            ->whereNotNull('submitted_at')->orderByDesc('submitted_at')->get()->unique('quiz_id')->keyBy('quiz_id');

        $sections = $isPractice
            ? [['title' => __('Latihan Mandiri'), 'description' => __('Kerjakan latihan mandiri untuk menguji pemahaman Anda.'), 'items' => $activities, 'theme' => 'violet']]
            : [
                ['title' => __('Quiz Chapter'), 'description' => __('Quiz evaluasi pada masing-masing chapter.'), 'items' => $activities->filter(fn (Quiz $activity) => ! $activity->isFinalQuiz()), 'theme' => 'blue'],
                ['title' => __('Ujian'), 'description' => __('Ujian akhir course tersedia di halaman ini.'), 'items' => $activities->filter(fn (Quiz $activity) => $activity->isFinalQuiz()), 'theme' => 'amber'],
            ];

        $pageTitle = $isPractice ? __('Latihan') : __('Quiz & Ujian');

        return view('courses.activities', compact('course', 'lastAttempts', 'sections', 'pageTitle'));
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

    public function updateHotspots(Request $request, Course $course, Chapter $chapter)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);
        
        $request->validate([
            'hotspots' => 'required|array',
            'hotspots.*.id' => 'required|exists:hotspots,id',
            'hotspots.*.x' => 'required|numeric',
            'hotspots.*.y' => 'required|numeric',
        ]);

        foreach ($request->hotspots as $hotspotData) {
            \App\Models\Hotspot::where('id', $hotspotData['id'])->update([
                'x_percent' => $hotspotData['x'],
                'y_percent' => $hotspotData['y']
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function storeDiagram(Request $request, Course $course, Chapter $chapter)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'title' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'diagram_' . $chapter->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('images/diagrams');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $imagePath = 'images/diagrams/' . $filename;

            $diagram = Diagram::updateOrCreate(
                ['chapter_id' => $chapter->id],
                [
                    'title' => $request->title ?? ('Diagram ' . $chapter->title),
                    'image_path' => $imagePath,
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Diagram berhasil diunggah.',
                'diagram' => $diagram->load('hotspots'),
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Gagal mengunggah gambar.'], 400);
    }

    public function destroyDiagram(Course $course, Chapter $chapter)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);

        $diagram = Diagram::where('chapter_id', $chapter->id)->first();
        if ($diagram) {
            if ($diagram->image_path && file_exists(public_path($diagram->image_path))) {
                @unlink(public_path($diagram->image_path));
            }
            $diagram->delete();
        }

        return response()->json(['status' => 'success', 'message' => 'Diagram berhasil dihapus.']);
    }

    public function storeHotspot(Request $request, Course $course, Chapter $chapter)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);

        $diagram = Diagram::where('chapter_id', $chapter->id)->firstOrFail();

        $request->validate([
            'label' => 'required|string|max:255',
            'action_type' => 'required|in:navigate,popup',
            'target_module_id' => 'nullable|exists:modules,id',
            'popup_title' => 'nullable|string|max:255',
            'popup_content' => 'nullable|string',
            'x_percent' => 'required|numeric|between:0,100',
            'y_percent' => 'required|numeric|between:0,100',
        ]);

        $hotspot = Hotspot::create([
            'diagram_id' => $diagram->id,
            'label' => $request->label,
            'action_type' => $request->action_type,
            'target_module_id' => $request->action_type !== 'popup' ? $request->target_module_id : null,
            'popup_title' => $request->action_type === 'popup' ? $request->popup_title : null,
            'popup_content' => $request->action_type === 'popup' ? $request->popup_content : null,
            'x_percent' => $request->x_percent,
            'y_percent' => $request->y_percent,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Hotspot berhasil ditambahkan.',
            'hotspot' => $hotspot,
        ]);
    }

    public function updateHotspotDetails(Request $request, Course $course, Chapter $chapter, Hotspot $hotspot)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);

        $request->validate([
            'label' => 'required|string|max:255',
            'action_type' => 'required|in:navigate,popup',
            'target_module_id' => 'nullable|exists:modules,id',
            'popup_title' => 'nullable|string|max:255',
            'popup_content' => 'nullable|string',
            'x_percent' => 'required|numeric|between:0,100',
            'y_percent' => 'required|numeric|between:0,100',
        ]);

        $hotspot->update([
            'label' => $request->label,
            'action_type' => $request->action_type,
            'target_module_id' => $request->action_type !== 'popup' ? $request->target_module_id : null,
            'popup_title' => $request->action_type === 'popup' ? $request->popup_title : null,
            'popup_content' => $request->action_type === 'popup' ? $request->popup_content : null,
            'x_percent' => $request->x_percent,
            'y_percent' => $request->y_percent,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Hotspot berhasil diperbarui.',
            'hotspot' => $hotspot,
        ]);
    }

    public function destroyHotspot(Course $course, Chapter $chapter, Hotspot $hotspot)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);

        $hotspot->delete();

        return response()->json(['status' => 'success', 'message' => 'Hotspot berhasil dihapus.']);
    }

    // ==========================================
    // MODULE DIAGRAM & HOTSPOT MANAGEMENT
    // ==========================================

    public function storeModuleDiagram(Request $request, Course $course, Chapter $chapter, Module $module)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'title' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('diagrams/modules', 'public');
            $imagePath = 'storage/' . $path;

            $diagram = Diagram::updateOrCreate(
                ['module_id' => $module->id],
                [
                    'chapter_id' => null,
                    'title' => $request->title ?? ($module->title . ' Technical Drawing'),
                    'image_path' => $imagePath,
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Gambar diagram modul berhasil diunggah.',
                'diagram' => $diagram->load('hotspots'),
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'File tidak ditemukan.'], 400);
    }

    public function destroyModuleDiagram(Course $course, Chapter $chapter, Module $module)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);

        if ($module->diagram) {
            $module->diagram->delete();
        }

        return response()->json(['status' => 'success', 'message' => 'Diagram modul berhasil dihapus.']);
    }

    public function storeModuleHotspot(Request $request, Course $course, Chapter $chapter, Module $module)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);

        $request->validate([
            'label' => 'required|string|max:255',
            'action_type' => 'required|in:navigate,popup,scroll_row',
            'target_module_id' => 'nullable|exists:modules,id',
            'popup_title' => 'nullable|string|max:255',
            'popup_content' => 'nullable|string',
            'x_percent' => 'required|numeric|between:0,100',
            'y_percent' => 'required|numeric|between:0,100',
        ]);

        $diagram = $module->diagram;
        if (!$diagram) {
            return response()->json(['status' => 'error', 'message' => 'Diagram modul belum diunggah.'], 404);
        }

        $hotspot = $diagram->hotspots()->create([
            'label' => $request->label,
            'action_type' => $request->action_type,
            'target_module_id' => $request->action_type !== 'popup' ? $request->target_module_id : null,
            'popup_title' => $request->popup_title ?? $request->label,
            'popup_content' => $request->popup_content,
            'x_percent' => $request->x_percent,
            'y_percent' => $request->y_percent,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Hotspot modul berhasil ditambahkan.',
            'hotspot' => $hotspot,
        ]);
    }

    public function updateModuleHotspots(Request $request, Course $course, Chapter $chapter, Module $module)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);

        $request->validate([
            'hotspots' => 'required|array',
            'hotspots.*.id' => 'required|exists:hotspots,id',
            'hotspots.*.x' => 'required|numeric|between:0,100',
            'hotspots.*.y' => 'required|numeric|between:0,100',
        ]);

        foreach ($request->hotspots as $item) {
            Hotspot::where('id', $item['id'])->update([
                'x_percent' => $item['x'],
                'y_percent' => $item['y'],
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Posisi hotspot modul berhasil diperbarui.']);
    }

    public function updateModuleHotspotDetails(Request $request, Course $course, Chapter $chapter, Module $module, Hotspot $hotspot)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);

        $request->validate([
            'label' => 'required|string|max:255',
            'action_type' => 'required|in:navigate,popup,scroll_row',
            'target_module_id' => 'nullable|exists:modules,id',
            'popup_title' => 'nullable|string|max:255',
            'popup_content' => 'nullable|string',
            'x_percent' => 'required|numeric|between:0,100',
            'y_percent' => 'required|numeric|between:0,100',
        ]);

        $hotspot->update([
            'label' => $request->label,
            'action_type' => $request->action_type,
            'target_module_id' => $request->action_type !== 'popup' ? $request->target_module_id : null,
            'popup_title' => $request->popup_title ?? $request->label,
            'popup_content' => $request->popup_content,
            'x_percent' => $request->x_percent,
            'y_percent' => $request->y_percent,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Hotspot modul berhasil diperbarui.',
            'hotspot' => $hotspot,
        ]);
    }

    public function destroyModuleHotspot(Course $course, Chapter $chapter, Module $module, Hotspot $hotspot)
    {
        abort_unless(auth()->user()->isInstruktur(), 403);

        $hotspot->delete();

        return response()->json(['status' => 'success', 'message' => 'Hotspot modul berhasil dihapus.']);
    }
}
