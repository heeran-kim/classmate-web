<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Review;
use App\Models\AssessmentStudent;
use App\Models\User;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Assessment $assessment)
    {
        $request->validate([
            'text' => 'required|regex:/^\s*\S+(?:\s+\S+){4,}\s*$/',
            'reviewee' => 'exists:users,id'
        ]);

        $review = new Review();
        $review->text = $request->text;
        $review->reviewee_id = $request->reviewee;
        
        $studentId = $assessment->students->random(1)->first()->id;
        $assessmentStudent = AssessmentStudent::where('assessment_id', $assessment->id)
                            ->where('student_id', $studentId)
                            ->firstOrFail();
        
        $review->assessment_student_id = $assessmentStudent->id;
        
        $review->save();

        return redirect("assessment/$assessment->id");
    }

    /**
     * Display the specified resource.
     */
    public function showStudentReviews(Assessment $assessment, User $student){
        $reviewsSubmitted = $assessment->reviews()->where('student_id', $student->id)->get();
        $reviewsReceived = $assessment->reviews()->where('reviewee_id', $student->id)->get();
        $score = AssessmentStudent::where('assessment_id', $assessment->id)
                            ->where('student_id', $student->id)
                            ->firstOrFail()
                            ->score;
        return view("reviews.student")
        ->with('assessment', $assessment)
        ->with('student', $student)
        ->with('reviewsSubmitted', $reviewsSubmitted)
        ->with('reviewsReceived', $reviewsReceived)
        ->with('score', $score);
    }
}
