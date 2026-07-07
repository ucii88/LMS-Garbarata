<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display the specified course with its interactive diagram and modules.
     */
    public function show(Course $course)
    {
        $course->load(['modules', 'diagrams.hotspots.targetModule']);
        $diagram = $course->diagrams->first();

        return view('courses.show', [
            'course' => $course,
            'diagram' => $diagram,
            'modules' => $course->modules,
        ]);
    }
}
