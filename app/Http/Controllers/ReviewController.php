<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Review;
use App\Models\AssessmentStudent;
use App\Models\User;
use Illuminate\Database\Eloquent\MassAssignmentException;

class ReviewController extends Controller
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
    public function create(string $courseId, string $assessmentId)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $assessmentId)
    {
        $review = new Review();
        $review->text = $request->text;
        $review->rating = $request->rating;
        $review->reviewee_id = $request->reviewee;
        
        $studentId = Assessment::findOrFail($assessmentId)->students->random(1)->first()->id;
        $assessmentStudent = AssessmentStudent::where('assessment_id', $assessmentId)
        ->where('student_id', $studentId)
        ->firstOrFail();
        
        $review->assessment_student_id = $assessmentStudent->id;
        
        $review->save();

        return redirect("assessment/$assessmentId");
    }

    /**
     * Display the specified resource.
     */
    public function showStudentReviews(string $assessmentId, string $studentId){
        $assessment = Assessment::findOrFail($assessmentId);
        $student = User::findOrFail($studentId);
        $reviewsSubmitted = $assessment->reviews()->where('student_id', $studentId)->get();
        $reviewsReceived = $assessment->reviews()->where('reviewee_id', $studentId)->get();
        $score = AssessmentStudent::where('assessment_id', $assessmentId)
                            ->where('student_id', $studentId)
                            ->firstOrFail()
                            ->score;
        return view("reviews.student")
        ->with('assessment', $assessment)
        ->with('student', $student)
        ->with('reviewsSubmitted', $reviewsSubmitted)
        ->with('reviewsReceived', $reviewsReceived)
        ->with('score', $score);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
