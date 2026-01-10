<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', \App\Http\Controllers\PageHomeController::class)->name('home');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/courses/{course:slug}/videos', [\App\Http\Controllers\CourseVideoController::class, 'index'])
    ->name('courses.videos.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard',[\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});
