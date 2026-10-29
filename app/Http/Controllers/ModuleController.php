<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Chapter;
use App\Models\Module;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    /**
     * Show the form for creating a new module.
     */
    public function create(Course $course, Chapter $chapter)
    {
        // Get the next order number automatically
        $nextOrder = ($chapter->modules()->max('order') ?? 0) + 1;

        return view('modules.create', compact('course', 'chapter', 'nextOrder'));
    }

    /**
     * Store a newly created module in storage.
     */
    public function store(Request $request, Course $course, Chapter $chapter)
    {
        $validated = $request->validate([
            'title.id'   => 'nullable|string|max:255',
            'title.en'   => 'nullable|string|max:255',
            'content.id' => 'nullable|string',
            'content.en' => 'nullable|string',
<<<<<<< HEAD
            'image_path' => 'nullable|string|max:255',
            'order'      => 'required|integer|min:1',
        ]);

        // Require at least one language for title and content
        if (empty($validated['title']['id'] ?? '') && empty($validated['title']['en'] ?? '')) {
            return back()->withErrors(['title.id' => __('Judul wajib diisi dalam salah satu bahasa.')])->withInput();
        }
        if (empty($validated['content']['id'] ?? '') && empty($validated['content']['en'] ?? '')) {
            return back()->withErrors(['content.id' => __('Konten wajib diisi dalam salah satu bahasa.')])->withInput();
        }

        [$titleId, $titleEn]     = $this->autoTranslatePair($validated['title']['id'] ?? '', $validated['title']['en'] ?? '');
        [$contentId, $contentEn] = $this->autoTranslatePair($validated['content']['id'] ?? '', $validated['content']['en'] ?? '');

        $data = [
            'title'      => ['id' => $titleId,   'en' => $titleEn],
            'content'    => ['id' => $contentId, 'en' => $contentEn],
            'image_path' => $validated['image_path'] ?? null,
            'order'      => $validated['order'],
=======
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg,gif|max:5120',
            'order' => 'nullable|integer|min:1',
        ], [
            'image.file' => __('Berkas yang diunggah tidak valid.'),
            'image.mimes' => __('Format gambar harus berupa JPG, JPEG, PNG, WEBP, SVG, atau GIF.'),
            'image.max' => __('Ukuran berkas gambar maksimal 5 MB.'),
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('modules', 'public');
            $imagePath = 'storage/' . $path;
        }

        $order = $request->filled('order')
            ? (int) $request->input('order')
            : (($chapter->modules()->max('order') ?? 0) + 1);

        $data = [
            'title' => [
                'id' => trim($validated['title']['id']),
                'en' => trim($validated['title']['en'] ?? ''),
            ],
            'content' => [
                'id' => $validated['content']['id'],
                'en' => $validated['content']['en'] ?? '',
            ],
            'image_path' => $imagePath,
            'order' => $order,
>>>>>>> 2b0311446a8809b2a56821ed6f079305bb81f804
        ];

        $module = new Module($data);
        $module->chapter_id = $chapter->id;
        $module->save();

        return redirect()
            ->route('courses.chapters.show', [$course->id, $chapter->id])
            ->with('success', __('Modul berhasil ditambahkan.'));
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
            'title.id'   => 'nullable|string|max:255',
            'title.en'   => 'nullable|string|max:255',
            'content.id' => 'nullable|string',
            'content.en' => 'nullable|string',
<<<<<<< HEAD
            'image_path' => 'nullable|string|max:255',
            'order'      => 'required|integer|min:1',
        ]);

        // Require at least one language for title and content
        if (empty($validated['title']['id'] ?? '') && empty($validated['title']['en'] ?? '')) {
            return back()->withErrors(['title.id' => __('Judul wajib diisi dalam salah satu bahasa.')])->withInput();
        }
        if (empty($validated['content']['id'] ?? '') && empty($validated['content']['en'] ?? '')) {
            return back()->withErrors(['content.id' => __('Konten wajib diisi dalam salah satu bahasa.')])->withInput();
        }

        [$titleId, $titleEn]     = $this->autoTranslatePair($validated['title']['id'] ?? '', $validated['title']['en'] ?? '');
        [$contentId, $contentEn] = $this->autoTranslatePair($validated['content']['id'] ?? '', $validated['content']['en'] ?? '');

        $data = [
            'title'      => ['id' => $titleId,   'en' => $titleEn],
            'content'    => ['id' => $contentId, 'en' => $contentEn],
            'image_path' => $validated['image_path'] ?? null,
            'order'      => $validated['order'],
=======
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg,gif|max:5120',
            'remove_image' => 'nullable',
            'order' => 'nullable|integer|min:1',
        ], [
            'image.file' => __('Berkas yang diunggah tidak valid.'),
            'image.mimes' => __('Format gambar harus berupa JPG, JPEG, PNG, WEBP, SVG, atau GIF.'),
            'image.max' => __('Ukuran berkas gambar maksimal 5 MB.'),
        ]);

        $imagePath = $module->image_path;

        if ($request->boolean('remove_image')) {
            if ($imagePath && str_starts_with($imagePath, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $imagePath));
            }
            $imagePath = null;
        }

        if ($request->hasFile('image')) {
            if ($module->image_path && str_starts_with($module->image_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $module->image_path));
            }
            $path = $request->file('image')->store('modules', 'public');
            $imagePath = 'storage/' . $path;
        }

        $data = [
            'title' => [
                'id' => $validated['title']['id'],
                'en' => $validated['title']['en'] ?? '',
            ],
            'content' => [
                'id' => $validated['content']['id'],
                'en' => $validated['content']['en'] ?? '',
            ],
            'image_path' => $imagePath,
>>>>>>> 2b0311446a8809b2a56821ed6f079305bb81f804
        ];

        if ($request->filled('order')) {
            $data['order'] = (int) $request->input('order');
        }

        $module->update($data);

        return redirect()
            ->route('courses.chapters.show', [$course->id, $chapter->id])
            ->with('success', __('Modul berhasil diperbarui.'));
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

        if ($module->image_path && str_starts_with($module->image_path, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $module->image_path));
        }

        $module->delete();

        return redirect()
            ->route('courses.chapters.show', [$course->id, $chapter->id])
            ->with('success', __('Modul berhasil dihapus.'));
    }

    /**
     * Auto-fill missing language translation for a string pair.
     * If both are filled, returns as-is.
     * If only `id` is filled, translates id -> en.
     * If only `en` is filled, translates en -> id.
     *
     * @return array [string $id, string $en]
     */
    private function autoTranslatePair(string $textId, string $textEn): array
    {
        $res = TranslationService::autoTranslatePair($textId, $textEn);
        return [$res['id'], $res['en']];
    }
}
