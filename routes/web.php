<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ReviewController;

Route::resource('user', UserController::class);
Route::resource('course', CourseController::class);
Route::resource('assessment', AssessmentController::class);
Route::resource('review', ReviewController::class);

Route::get('/', function () {
    return view('welcome');
});

