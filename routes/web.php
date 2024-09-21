<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Middleware\TeacherMiddleware;

Route::middleware(['auth', TeacherMiddleware::class])->group(function () {
    Route::resource('assessment', AssessmentController::class)->only(['create', 'store', 'edit', 'update']);
    Route::post('assessment/{assessment}/student/{student}', [AssessmentController::class, 'assignScore'])->name('assessment.assignScore');
    Route::get('assessment/{assessment}/student/{student}/reviews', [ReviewController::class, 'showStudentReviews'])->name('student.reviews');
    Route::resource('course', CourseController::class)->only(['create', 'store']);
    Route::get('course/{course}/enroll', [CourseController::class, 'enrollPage'])->name('course.enrollPage');
    Route::post('course/{course}/enroll', [CourseController::class, 'enroll'])->name('course.enroll');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('dashboard');
    Route::resource('course', CourseController::class)->only(['index', 'show']);
    Route::resource('assessment', AssessmentController::class)->only(['show']);
});

Route::middleware(['auth', StudentMiddleware::class])->group(function () {
    Route::resource('assessment.review', ReviewController::class)->only(['store']);
});


require __DIR__.'/auth.php';