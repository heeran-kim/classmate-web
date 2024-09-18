<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ReviewController;

Route::resource('user', UserController::class);
Route::resource('assessment', AssessmentController::class);
Route::resource('assessment.review', ReviewController::class);


Route::get('/', function () {
    return view('users.login');
});

Route::get('course/{id}/enroll', [CourseController::class, 'enrollPage'])->name('course.enrollPage');
Route::post('course/{course}/enroll', [CourseController::class, 'enroll'])->name('course.enroll');
Route::resource('course', CourseController::class);

Route::get('assessment/{assessment}/student/{student}/reviews', [ReviewController::class, 'showStudentReviews'])->name('student.reviews');