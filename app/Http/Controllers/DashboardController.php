<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $purchasedCourses = auth()->user()->courses()
            ->with('videos')->latest('purchased_course.created_at')->get();

        return view('dashboard', compact('purchasedCourses'));
    }
}
