<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $purchasedCourses = auth()->user()->courses()->latest('id')->get();

        return view('dashboard', compact('purchasedCourses'));
    }
}
