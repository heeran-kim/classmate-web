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
    public function create(string $id)
    {
        $course = Course::findOrFail($id);
        
        return view('assessments.create')->with('course', $course);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $assessment = new Assessment();
        $assessment->course_id = $request->route('id');
        $assessment->title = $request->title;
        $assessment->instruction = $request->instruction;
        $assessment->num_required_reviews = $request->num_required_reviews;
        $assessment->max_score = $request->max_score;
        $assessment->due_date = $request->due_date;
        $assessment->type = $request->type;

        $assessment->save();
        $id = $assessment->id;
        
        return redirect("course/$assessment->course_id/assessment/$id");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $courseId, string $id)
    {
        $assessment = Assessment::findOrFail($id);
        return view("assessments.show")->with('assessment', $assessment);
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
}
