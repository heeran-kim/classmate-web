<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ReviewController;

require __DIR__.'/auth.php';

Route::resource('course', CourseController::class)->only(['index', 'show']);
Route::resource('assessment', AssessmentController::class)->except(['index', 'destroy']);;
Route::resource('assessment.review', ReviewController::class);

Route::get('/', [CourseController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('course/{id}/enroll', [CourseController::class, 'enrollPage'])->name('course.enrollPage');
Route::post('course/{course}/enroll', [CourseController::class, 'enroll'])->name('course.enroll');
Route::post('assessment/{assessment}/student/{student}', [AssessmentController::class, 'assignScore'])->name('assessment.assignScore');
Route::get('assessment/{assessment}/student/{student}/reviews', [ReviewController::class, 'showStudentReviews'])->name('student.reviews');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

