<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Assessment;
use DateTime;

class AssessmentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $course = Course::findOrFail($request->courseId);
        return view('assessments.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'                 => 'required|max:20',
            'num_required_reviews'  => 'required|integer|min:1',
            'max_score'             => 'required|integer|min:1|max:100',
            'due_date'              => 'required|date',
            'type'                  => 'required|in:student-select,teacher-assign',
            'course_id'             => 'exists:courses,id'
        ]);
        
        $assessment = Assessment::create([
            'title'                 => $request->title,
            'instruction'           => $request->instruction,
            'num_required_reviews'  => $request->num_required_reviews,
            'max_score'             => $request->max_score,
            'due_date'              => new DateTime($request->due_date),
            'type'                  => $request->type,
            'course_id'             => $request->course_id,
        ]);

        $students = $assessment->course->students->pluck('id');
        $assessment->students()->attach($students);

        return redirect()->route('assessment.show', $assessment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assessment $assessment)
    {
        $user = Auth::user();

        if ($user->type == 'student') {
            $reviewsSubmitted = $user->reviewsSubmittedForAssessment($assessment->id)->get();
            $reviewsReceived = $user->reviewsReceivedForAssessment($assessment->id)->get();
            $reviewedStudentIds = $reviewsSubmitted->pluck('reviewee_id');
            
            $potentialReviewees = $assessment->students()
                                    ->where('users.id', '!=', $user->id)
                                    ->get();

            return view("assessments.show", compact('assessment', 'reviewsSubmitted', 'reviewsReceived', 'potentialReviewees', 'reviewedStudentIds'));
        }
        else {
            $reviewCount = $assessment->reviews()->count();
            $students = $assessment->students()->paginate(10);
            $studentsData = [];
            foreach ($students as $student) {
                $id = $student->id;
                $name = $student->name;
                $submitted = $student->reviewsSubmittedForAssessment($assessment->id)->count();
                $received = $student->reviewsReceivedForAssessment($assessment->id)->count();
                $score = $student->pivot->score;
                $studentsData[] = ['id'=>$id, 'name'=>$name, 'submitted'=>$submitted, 'received'=>$received, 'score'=>$score];
            }
            return view("assessments.show", compact('assessment', 'studentsData', 'reviewCount', 'students'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assessment $assessment)
    {
        return view("assessments.edit")->with('assessment', $assessment)->with('course', $assessment->course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assessment $assessment)
    {
        $request->validate([
            'title'                 => 'required|max:20',
            'num_required_reviews'  => 'required|integer|min:1',
            'max_score'             => 'required|integer|min:1|max:100',
            'due_date'              => 'required',
            'type'                  => 'required|in:student-select,teacher-assign'
        ]);
        
        $assessment->title                  = $request->title;
        $assessment->instruction            = $request->instruction;
        $assessment->num_required_reviews   = $request->num_required_reviews;
        $assessment->max_score              = $request->max_score;
        $assessment->due_date               = $request->due_date;
        $assessment->type                   = $request->type;
        $assessment->save();
        
        return redirect()->route('assessment.show', $assessment);
    }

    /**
     * Assign score to a student.
     */
    public function assignScore(Request $request, Assessment $assessment, User $student)
    {
        $request->validate([
            'score' => 'required|integer|min:0|max:'.$assessment->max_score
        ]);
        $assessment->students()->updateExistingPivot($student->id, ['score' => $request->score]);
        return back();
    }
}
