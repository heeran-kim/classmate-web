<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ReviewController;

Route::resource('user', UserController::class);
Route::resource('review', ReviewController::class);

Route::get('/', function () {
    return view('users.login');
});

Route::get('course/{id}/enroll', [CourseController::class, 'enrollPage'])->name('course.enrollPage');
Route::post('course/{id}/enroll', [CourseController::class, 'enroll'])->name('course.enroll');

Route::get('course/{id}/assessment/create', [AssessmentController::class, 'create'])->name('assessment.create');
Route::post('course/{id}/assessment', [AssessmentController::class, 'store'])->name('assessment.store');
Route::get('course/{courseId}/assessment/{id}', [AssessmentController::class, 'show'])->name('assessment.show');

Route::resource('course', CourseController::class);