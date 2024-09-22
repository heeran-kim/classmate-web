<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Review;
use App\Models\Assessment;
use App\Models\AssessmentStudent;

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

        $review  = Review::create([
            'text'          => $request->review,
            'reviewee_id'   => $request->reviewee,
        ]);

        $assessmentStudent = AssessmentStudent::where('assessment_id', $assessment->id)
                            ->where('student_id', $reviewer->id)
                            ->firstOrFail();
        
        $review->assessment_student_id = $assessmentStudent->id;
        $review->save();

        return redirect()->route('assessment.show', $assessment);
    }

    /**
     * Display the specified resource.
     */
    public function showStudentReviews(Assessment $assessment, User $student){
        $reviewsSubmitted = $student->reviewsSubmittedForAssessment($assessment->id)->get();
        $reviewsReceived = $student->reviewsReceivedForAssessment($assessment->id)->get();
        $score = $assessment->students()->where('student_id', $student->id)->first()->pivot->score;
        
        return view("reviews.student", compact('assessment', 'student', 'reviewsSubmitted', 'reviewsReceived', 'score');
    }
}
