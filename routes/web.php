<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReviewController;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Middleware\TeacherMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssessmentController;
use App\Http\Middleware\EnsureProfileComplete;
use App\Http\Controllers\Auth\PasswordController;

Route::middleware(['auth', TeacherMiddleware::class])->group(function () {
    Route::resource('assessment', AssessmentController::class)->only(['create', 'store', 'edit', 'update']);
    Route::post('assessment/{assessment}/student/{student}', [AssessmentController::class, 'assignScore'])->name('assessment.assignScore');
    Route::get('assessment/{assessment}/student/{student}/reviews', [ReviewController::class, 'showStudentReviews'])->name('student.reviews');
    Route::resource('course', CourseController::class)->only(['create', 'store']);
    Route::get('course/{course}/enroll', [CourseController::class, 'enrollPage'])->name('course.enrollPage');
    Route::post('course/{course}/enroll', [CourseController::class, 'enroll'])->name('course.enroll');
});

Route::middleware(['auth', StudentMiddleware::class])->group(function () {
    Route::resource('assessment.review', ReviewController::class)->only(['store']);
    Route::post('review/rating', [ReviewController::class, 'rating'])->name('review.rating');
});

Route::middleware(['auth', EnsureProfileComplete::class])->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('dashboard');
    Route::resource('course', CourseController::class)->only(['index', 'show']);
    Route::resource('assessment', AssessmentController::class)->only(['show']);
    Route::get('user/rank', [UserController::class, 'rank'])->name('user.rank');
});

Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('profile/password', [PasswordController::class, 'update'])->name('password.update');
});

require __DIR__.'/auth.php';