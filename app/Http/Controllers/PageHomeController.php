<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class PageHomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Course::query();

        if ($request->get('is_released')) {
            $query->whereNotNull('released_at');
        }

        $courses = $query->latest('released_at')->get();

        return view('home', compact('courses'));
    }
}
