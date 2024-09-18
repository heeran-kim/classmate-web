<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assessment;
use App\Models\AssessmentStudent;

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
    public function create(string $courseId)
    {
        $course = Course::findOrFail($courseId);
        
        return view('assessments.create')->with('course', $course);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $courseId)
    {
        $assessment = new Assessment();
        $assessment->course_id = $courseId;
        $assessment->title = $request->title;
        $assessment->instruction = $request->instruction;
        $assessment->num_required_reviews = $request->num_required_reviews;
        $assessment->max_score = $request->max_score;
        $assessment->due_date = $request->due_date;
        $assessment->type = $request->type;

        $assessment->save();
        $id = $assessment->id;
        
        $course = Course::findOrFail($courseId);
        $students = $course->students;

        foreach ($students as $student) {
            $assessmentStudent = new AssessmentStudent();
            $assessmentStudent->assessment_id = $id;
            $assessmentStudent->student_id = $student->id;
            $assessmentStudent->save();
        }

        return redirect("course/$courseId/assessment/$id");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $courseId, string $assessmentId)
    {
        if (0) {
            $assessment = Assessment::findOrFail($assessmentId);
            $course = Course::findOrFail($courseId);
            
            $reviewer = Assessment::findOrFail($assessmentId)->students->random(1)->first();
            $reviewsSubmitted = $assessment->reviews()->where('student_id', $reviewer->id)->get();
            $reviewsReceived = $assessment->reviews()->where('reviewee_id', $reviewer->id)->get();
            $assessmentStudent = AssessmentStudent::where('assessment_id', $assessmentId)
            ->where('student_id', $reviewer->id)
            ->firstOrFail();
            $revieweeIds = $assessmentStudent->reviews->pluck('reviewee_id');
            $notReviewedStudents = $assessment->students()->whereNotIn('users.id', $revieweeIds)->get();
            
            return view("assessments.show")
            ->with('assessment', $assessment)
            ->with('course', $course)
            ->with('reviewsSubmitted', $reviewsSubmitted)
            ->with('reviewsReceived', $reviewsReceived)
            ->with('students', $notReviewedStudents)
            ->with('reviewer', $reviewer);
        }
        else {
            $assessment = Assessment::findOrFail($assessmentId);
            $reviewCount = $assessment->reviews()->count();
            $students = $assessment->students;
            
            $studentsData = [];
            foreach ($students as $student) {
                $name = $student->name;
                $received = $assessment->reviews()->where('reviewee_id', $student->id)->count();
                $submitted = $assessment->reviews()->where('student_id', $student->id)->count();
                $score = AssessmentStudent::where('assessment_id', $assessmentId)
                                            ->where('student_id', $student->id)
                                            ->pluck('score');
                $studentsData[] = ['name'=>$name, 'received'=>$received, 'submitted'=>$submitted, 'score'=>$score];
            }
            return view("assessments.show")
            ->with('reviewCount', $reviewCount)
            ->with('students', $students)
            ->with('studentsData', $studentsData);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $courseId, string $assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);
        $course = Course::findOrFail($courseId);
        
        return view("assessments.edit")->with('assessment', $assessment)->with('course', $course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $courseId, string $assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);

        $assessment->title = $request->title;
        $assessment->instruction = $request->instruction;
        $assessment->num_required_reviews = $request->num_required_reviews;
        $assessment->max_score = $request->max_score;
        $assessment->due_date = $request->due_date;
        $assessment->type = $request->type;

        $assessment->save();
        
        return redirect("course/$courseId/assessment/$assessmentId");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
