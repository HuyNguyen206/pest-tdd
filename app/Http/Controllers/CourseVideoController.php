<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;

class CourseVideoController extends Controller
{
    public function index(Course $course, ?Video $video = null)
    {
        $video ??= $course->videos()->first();

        return view('videos.index', compact('video'));
    }
}
