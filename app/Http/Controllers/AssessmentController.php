<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Models\AssessmentStudent;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $course = Course::findOrFail($request->input('courseId'));
        return view('assessments.create')->with('course', $course);
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
            'due_date'              => 'required',
            'type'                  => 'required|in:student-select,teacher-assign',
            'courseId'              => 'exists:courses,id'
        ]);
        
        $assessment = new Assessment();
        $assessment->course_id              = $request->courseId;
        $assessment->title                  = $request->title;
        $assessment->instruction            = $request->instruction;
        $assessment->num_required_reviews   = $request->num_required_reviews;
        $assessment->max_score              = $request->max_score;
        $assessment->due_date               = $request->due_date;
        $assessment->type                   = $request->type;
        $assessment->save();
        
        $students = Course::FindOrFail($request->courseId)->students;
        foreach ($students as $student) {
            $assessment->students()->attach($student->id);
        }

        return redirect("assessment/$assessment->id");
    }

    /**
     * Display the specified resource.
     */
    public function show(Assessment $assessment)
    {
        if (Auth::user()->type == 'student') {
            $reviewer = Auth::user();
            $reviewsSubmitted = $assessment->reviews()->where('student_id', $reviewer->id)->get();
            $reviewsReceived = $assessment->reviews()->where('reviewee_id', $reviewer->id)->get();
            $reviewedStudentIds = $reviewer->reviews()->pluck('reviewee_id');
            $potentialReviewees = $assessment->students()
                                    ->whereNotIn('users.id', $reviewedStudentIds)
                                    ->where('users.id', '!=', $reviewer->id)
                                    ->get();
            return view("assessments.show")
            ->with('assessment', $assessment)
            ->with('reviewsSubmitted', $reviewsSubmitted)
            ->with('reviewsReceived', $reviewsReceived)
            ->with('potentialReviewees', $potentialReviewees);
        }
        else {
            $reviewCount = $assessment->reviews()->count();
            $students = $assessment->students()->paginate(10);
            
            $studentsData = [];
            foreach ($students as $student) {
                $id = $student->id;
                $name = $student->name;
                $received = $assessment->reviews()->where('reviewee_id', $student->id)->count();
                $submitted = $assessment->reviews()->where('student_id', $student->id)->count();
                $score = $student->pivot->score;
                $studentsData[] = ['id'=>$id, 'name'=>$name, 'received'=>$received, 'submitted'=>$submitted, 'score'=>$score];
            }
            return view("assessments.show")
            ->with('assessment', $assessment)
            ->with('reviewCount', $reviewCount)
            ->with('students', $students)
            ->with('studentsData', $studentsData);
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
        
        return redirect("assessment/$assessment->id");
    }

    public function assignScore(Request $request, Assessment $assessment, User $student)
    {
        $request->validate([
            'score' => 'required|integer|max:'.$assessment->max_score
        ]);
        $assessment->students()->updateExistingPivot($student->id, ['score' => $request->score]);
        return back();
    }
}
