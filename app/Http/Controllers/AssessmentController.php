<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assessment;
use App\Models\AssessmentStudent;
use Illuminate\Foundation\Validation\ValidatesRequests; 

class AssessmentController extends Controller
{
    use ValidatesRequests;  // 트레이트 추가
    
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
    public function create(Request $request)
    {
        $courseId = $request->input('courseId');
        return view('assessments.create')->with('courseId', $courseId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:20',
            'num_required_reviews' => 'required|integer|min:1',
            'max_score' => 'required|integer|min:1|max:100',
            'due_date' => 'required',
            'type' => 'required|in:student-select,teacher-assign',
            'courseId' => 'exists:courses,id'
        ]);
        

        $assessment = new Assessment();
        $assessment->course_id = $request->courseId;
        $assessment->title = $request->title;
        $assessment->instruction = $request->instruction;
        $assessment->num_required_reviews = $request->num_required_reviews;
        $assessment->max_score = $request->max_score;
        $assessment->due_date = $request->due_date;
        $assessment->type = $request->type;


        $assessment->save();
        $id = $assessment->id;
        
        $course = Course::findOrFail($request->courseId);
        $students = $course->students;

        foreach ($students as $student) {
            $assessmentStudent = new AssessmentStudent();
            $assessmentStudent->assessment_id = $id;
            $assessmentStudent->student_id = $student->id;

            $assessmentStudent->save();
        }

        return redirect("assessment/$id");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $assessmentId)
    {
        if (1) {
            $assessment = Assessment::findOrFail($assessmentId);
            
            $reviewer = Assessment::findOrFail($assessmentId)->students->random(1)->first();
            $reviewsSubmitted = $assessment->reviews()->where('student_id', $reviewer->id)->get();
            $reviewsReceived = $assessment->reviews()->where('reviewee_id', $reviewer->id)->get();
            $assessmentStudent = AssessmentStudent::where('assessment_id', $assessmentId)
                                ->where('student_id', $reviewer->id)
                                ->firstOrFail();
            $revieweeIds = $assessmentStudent->reviews->pluck('reviewee_id');
            $potentialReviewees = $assessment->students()
                                    ->whereNotIn('users.id', $revieweeIds)
                                    ->where('users.id', '!=', $reviewer->id)
                                    ->get();
            
            return view("assessments.show")
            ->with('assessment', $assessment)
            ->with('reviewsSubmitted', $reviewsSubmitted)
            ->with('reviewsReceived', $reviewsReceived)
            ->with('potentialReviewees', $potentialReviewees)
            ->with('reviewer', $reviewer);
        }
        else {
            $assessment = Assessment::findOrFail($assessmentId);
            $reviewCount = $assessment->reviews()->count();
            $students = $assessment->students;
            
            $studentsData = [];
            foreach ($students as $student) {
                $id = $student->id;
                $name = $student->name;
                $received = $assessment->reviews()->where('reviewee_id', $student->id)->count();
                $submitted = $assessment->reviews()->where('student_id', $student->id)->count();
                $score = AssessmentStudent::where('assessment_id', $assessmentId)
                                            ->where('student_id', $student->id)
                                            ->pluck('score')
                                            ->first();
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
    public function edit(string $assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);
        
        return view("assessments.edit")->with('assessment', $assessment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $assessmentId)
    {
        $this->validate($request, [
            'title' => 'required|max:20',
            'num_required_reviews' => 'required|integer|min:1',
            'max_score' => 'required|integer|min:1|max:100',
            'due_date' => 'required',
            'type' => 'required|in:student-select,teacher-assign'
        ]);

        $assessment = Assessment::findOrFail($assessmentId);

        $assessment->title = $request->title;
        $assessment->instruction = $request->instruction;
        $assessment->num_required_reviews = $request->num_required_reviews;
        $assessment->max_score = $request->max_score;
        $assessment->due_date = $request->due_date;
        $assessment->type = $request->type;

        $assessment->save();
        
        return redirect("assessment/$assessmentId");
    }

    public function assignScore(Request $request, string $assessmentId, string $studentId)
    {
        $maxScore = Assessment::findOrFail($assessmentId)->max_score;
        $this->validate($request, [
            'score' => 'required|max:'.$maxScore
        ]);

        $assessmentStudent = AssessmentStudent::where('assessment_id', $assessmentId)
                            ->where('student_id', $studentId)
                            ->firstOrFail();
        $assessmentStudent->score = $request->score;
        $assessmentStudent->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
