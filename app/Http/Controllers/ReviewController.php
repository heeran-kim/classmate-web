<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AssessmentStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the course.
     */
    public function index(Assessment $assessment)
    {
        $sort = request('sort') ?? 'rating-desc';
        switch ($sort) {
            case 'rating-asc':
                $orderByCol = 'rating';
                $orderByDir = 'asc';
                break;
            case 'rating-desc':
            default:
                $orderByCol = 'rating';
                $orderByDir = 'desc';
                break;
        }
        
        $reviews = $assessment->reviews()
                              ->orderBy($orderByCol, $orderByDir)
                              ->paginate(10);

        

        return view('reviews.index', compact('reviews', 'reviewers', 'assessment', 'sort'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Assessment $assessment)
    {
        $reviewer = Auth::user();
        $reviewsSubmitted = $reviewer->reviewsSubmittedForAssessment($assessment->id)->get();
        $reviewedStudentIds = $reviewsSubmitted->pluck('reviewee_id');

        $request->validate([
            'review'    => 'required|regex:/^\s*\S+(?:\s+\S+){4,}\s*$/',
            'reviewee' => ['required', 'exists:users,id', Rule::notIn($reviewedStudentIds)],
        ],
        [
            'review.regex' => 'The review text must be at least 5 words.',
            'reviewee.not_in' => 'This reviewee has already been reviewed.',
        ]);

        $review  = new Review([
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
        
        return view("reviews.student", compact('assessment', 'student', 'reviewsSubmitted', 'reviewsReceived', 'score'));
    }

    public function rating(Request $request){
        $request->validate([
            'rating.*' => 'nullable|integer|min:1|max:5',
        ]);
        $reviewIds = $request->reviewsId;
        $ratings = $request->rating;
        foreach ($reviewIds as $index => $reviewId) {
            $review = Review::findOrFail($reviewId);
            $review->rating = $ratings[$index];
            $review->save();
        }
        
        return redirect()->back();
    }
}
