<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Chapter;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Show the form for creating a new module.
     */
    public function create(Course $course, Chapter $chapter)
    {
        // Get the next order number automatically
        $nextOrder = $chapter->modules()->max('order') + 1;

        return view('modules.create', compact('course', 'chapter', 'nextOrder'));
    }

    /**
     * Store a newly created module in storage.
     */
    public function store(Request $request, Course $course, Chapter $chapter)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_path' => 'nullable|string|max:255',
            'order' => 'required|integer|min:1',
        ]);

        $module = new Module($validated);
        $module->chapter_id = $chapter->id;
        $module->save();

        return redirect()
            ->route('courses.chapters.show', [$course->id, $chapter->id])
            ->with('success', 'Modul berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified module.
     */
    public function edit(Course $course, Chapter $chapter, Module $module)
    {
        // Abort if the module does not belong to this chapter
        if ($module->chapter_id !== $chapter->id) {
            abort(404);
        }

        return view('modules.edit', compact('course', 'chapter', 'module'));
    }

    /**
     * Update the specified module in storage.
     */
    public function update(Request $request, Course $course, Chapter $chapter, Module $module)
    {
        // Abort if the module does not belong to this chapter
        if ($module->chapter_id !== $chapter->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_path' => 'nullable|string|max:255',
            'order' => 'required|integer|min:1',
        ]);

        $module->update($validated);

        return redirect()
            ->route('courses.chapters.show', [$course->id, $chapter->id])
            ->with('success', 'Modul berhasil diperbarui.');
    }

    /**
     * Remove the specified module from storage.
     */
    public function destroy(Course $course, Chapter $chapter, Module $module)
    {
        // Abort if the module does not belong to this chapter
        if ($module->chapter_id !== $chapter->id) {
            abort(404);
        }

        $module->delete();

        return redirect()
            ->route('courses.chapters.show', [$course->id, $chapter->id])
            ->with('success', 'Modul berhasil dihapus.');
    }
}
