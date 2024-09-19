<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseUser;
use Illuminate\Http\Request;
use App\Models\AssessmentStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests; 

class CourseController extends Controller
{
    use ValidatesRequests;  // 트레이트 추가
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $courses = $user->courses;

        return view('courses.index')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // displays teachers, assessments (due date)
        $course = Course::findOrFail($id);
        $teachers = $course->teachers;
        $assessments = $course->assessments;
        return view('courses.show')->with('teachers', $teachers)->with('assessments', $assessments)->with('course', $course);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function enrollPage(string $id)
    {
        $course = Course::findOrFail($id);
        $enrolledStudentIds = $course->students->pluck('id');
        $unenrolledStudents = User::where('type', 'student')
                                ->whereNotIn('id', $enrolledStudentIds)
                                ->orderBy('name')
                                ->get();
    
        return view('courses.enroll')->with('students', $unenrolledStudents)->with('course', $course);
    }

    public function enroll(Request $request, string $courseId)
    {
        $this->validate($request, [
            'student' => 'exists:users,id'
        ]);

        $courseUser = new CourseUser();
        $courseUser->course_id = $courseId;
        $courseUser->user_id = $request->student;
        $courseUser->save();

        $course = Course::findOrFail($courseId);
        $assessments = $course->assessments;

        foreach ($assessments as $assessment) {
            $assessmentStudent = new AssessmentStudent();
            $assessmentStudent->assessment_id = $assessment->id;
            $assessmentStudent->student_id = $request->student;
            $assessmentStudent->save();
        }

        return redirect("course/$courseId/enroll");
    }

}
