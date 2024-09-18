<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assessment;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $courseId)
    {
        $course = Course::findOrFail($courseId);
        
        return view('assessments.create')->with('course', $course);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $courseId)
    {
        $assessment = new Assessment();
        $assessment->course_id = $courseId;
        $assessment->title = $request->title;
        $assessment->instruction = $request->instruction;
        $assessment->num_required_reviews = $request->num_required_reviews;
        $assessment->max_score = $request->max_score;
        $assessment->due_date = $request->due_date;
        $assessment->type = $request->type;

        $assessment->save();
        $id = $assessment->id;
        
        $course = Course::findOrFail($courseId);
        $students = $course->students;

        foreach ($students as $student) {
            $assessmentStudent = new AssessmentStudent();
            $assessmentStudent->assessment_id = $id;
            $assessmentStudent->student_id = $student->id;
        }

        $assessmentStudent->save();

        return redirect("course/$courseId/assessment/$id");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $courseId, string $assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);
        $course = Course::findOrFail($courseId);
        $reviews = $assessment->reviews;

        return view("assessments.show")->with('assessment', $assessment)->with('course', $course)->with('reviews', $reviews);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $courseId, string $assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);
        $course = Course::findOrFail($courseId);
        
        return view("assessments.edit")->with('assessment', $assessment)->with('course', $course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $courseId, string $assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);

        $assessment->title = $request->title;
        $assessment->instruction = $request->instruction;
        $assessment->num_required_reviews = $request->num_required_reviews;
        $assessment->max_score = $request->max_score;
        $assessment->due_date = $request->due_date;
        $assessment->type = $request->type;

        $assessment->save();
        
        return redirect("course/$courseId/assessment/$assessmentId");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
