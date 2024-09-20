<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Models\AssessmentStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Assessment $assessment)
    {
        $request->validate([
            'text'      => 'required|regex:/^\s*\S+(?:\s+\S+){4,}\s*$/',
            'reviewee'  => 'exists:users,id'
        ]);

        $review                 = new Review();
        $review->text           = $request->text;
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
        // TO DO: 새로 Enrolled 학생에 대해서 404
        $assessmentId = (int) $assessment->id;
        $studentId = (int) $student->id;
        $exists = AssessmentStudent::where('assessment_id', $assessmentId)
                                    ->where('student_id', $studentId)
                                    ->exists();
        $result = DB::select('select * from assessment_student where assessment_id = ? and student_id = ?', [$assessmentId, $studentId]);
        dd($result);
        
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
