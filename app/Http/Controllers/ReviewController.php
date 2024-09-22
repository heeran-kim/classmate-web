<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Models\AssessmentStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Assessment $assessment)
    {
        $reviewer = Auth::user();
        $reviewedStudentIds = $reviewer->reviews()->pluck('reviewee_id');

        $request->validate([
            'review'    => 'required|regex:/^\s*\S+(?:\s+\S+){4,}\s*$/',
            'reviewee' => ['required', 'exists:users,id', Rule::notIn($reviewedStudentIds)],
        ],
        [
            'review.regex' => 'The review text must be at least 5 words.',
            'reviewee.not_in' => 'This reviewee has already been reviewed.',
        ]);

        $review                 = new Review();
        $review->text           = $request->review;
        $review->reviewee_id    = $request->reviewee;
        
        $assessmentStudent = AssessmentStudent::where('assessment_id', $assessment->id)
                            ->where('student_id', Auth::user()->id)
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
        $score = $assessment->students()->where('student_id', $student->id)->first()->pivot->score;
        
        return view("reviews.student")
        ->with('assessment', $assessment)
        ->with('student', $student)
        ->with('reviewsSubmitted', $reviewsSubmitted)
        ->with('reviewsReceived', $reviewsReceived)
        ->with('score', $score);
    }
}
