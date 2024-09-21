<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Auth::user()->courses;
        return view('courses.index')->with('courses', $courses);
    }

    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        $request->validate([
            'jsonFile' => 'required|file|mimes:json|max:2048', // Ensure it's a valid JSON file
        ]);
     
        // Get the uploaded file
        $file = $request->file('jsonFile');
     
        // Read the contents of the file
        $jsonContents = file_get_contents($file->getPathName());

        dd($jsonContents);
        
        $image_store = request()->file('image')->store('images/courses_images', 'public');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        // TODO: $teachers, $assessments 필요?
        $teachers = $course->teachers;
        $assessments = $course->assessments()
                        ->with(['students' => function ($query) {
                            $query->where('users.id', Auth::id());
                        }])->get();
        return view('courses.show')->with('teachers', $teachers)->with('assessments', $assessments)->with('course', $course);
    }

    public function enrollPage(Course $course)
    {
        $enrolledStudentIds = $course->students->pluck('id');
        $unenrolledStudents = User::where('type', 'student')
                                ->whereNotIn('id', $enrolledStudentIds)
                                ->orderBy('name')
                                ->get();
    
        return view('courses.enroll')->with('students', $unenrolledStudents)->with('course', $course);
    }

    public function enroll(Request $request, Course $course)
    {
        $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:users,id',
        ]);
        
        $assessments = $course->assessments;
        foreach ($request->students as $student)
        {
            $course->users()->attach($student);
            foreach ($assessments as $assessment) {
                $assessment->students()->attach($student);
            }
        }

        return redirect("course/$course->id/enroll");
    }
}
