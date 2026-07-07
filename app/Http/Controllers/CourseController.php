<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Chapter;
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
            $query->withCount('modules')->orderBy('order');
        }]);

        return view('courses.show', compact('course'));
    }

    /**
     * Display the interactive study room for a specific chapter.
     */
    public function showChapter(Course $course, $chapterId)
    {
        // Fetch the specific chapter belonging to this course
        $chapter = Chapter::with(['modules', 'diagram.hotspots'])->where('course_id', $course->id)->findOrFail($chapterId);
        
        // Fetch all other chapters of the course for the sidebar/navigation
        $chapters = $course->chapters()->orderBy('order')->get();

        $diagram = $chapter->diagram;
        $modules = $chapter->modules;

        return view('courses.study', [
            'course' => $course,
            'chapter' => $chapter,
            'chapters' => $chapters,
            'diagram' => $diagram,
            'modules' => $modules,
        ]);
    }
}
