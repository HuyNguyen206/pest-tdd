<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseController extends Controller
{
    public function show(Course $course)
    {
        if ($course->released_at === null) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $course->loadCount('videos');

        return view('courses.show', compact('course'));
    }
}
