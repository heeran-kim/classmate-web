<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\AssessmentStudent;

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

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //dd($course->users);
        // TODO: $teachers, $assessments 필요?
        $teachers = $course->teachers;
        $assessments = $course->assessments;
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
            'student' => 'exists:users,id'
        ]);
        
        $course->users()->attach($request->student);

        $assessments = $course->assessments;

        foreach ($assessments as $assessment) {
            $assessment->students()->attach($request->student);
        }

        return redirect("course/$course->id/enroll");
    }
}
