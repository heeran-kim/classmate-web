<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display highest reviewers
     */
    public function index()
    {
        $courses = User::where('type', 'student');
        return view('courses.index', compact('courses'));
    }
}
