<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Assessment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Auth::user()->courses;
        return view('courses.index')->with('courses', $courses);
    }

    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        $request->validate([
            'jsonFile' => 'required|file|mimes:json|max:2048', 
        ]);
        
        $file = $request->file('jsonFile');
        $jsonContents = file_get_contents($file->getPathName());
        $data = json_decode($jsonContents, true);

        if (Course::where('code', $data['code'])->count()) {
            return back()->withErrors(['jsonFile' => 'Course code (' . $data['code'] . ') already exist.']);
        }
            
        $imageStore = null;
        if ($request->hasFile('image')) {
            $imageStore = request()->file('image')->store('images/courses_images', 'public');
        }
        
        $course = new Course();
        $course->code = $data['code'];
        $course->name = $data['name'];
        $course->image = $imageStore;
        $course->save();

        // assessments
        foreach ($data['assessments'] as $assessmentData) {
            $assessment = new Assessment();
            $assessment->course_id              = $course->id;
            $assessment->title                  = $assessmentData['title'];
            $assessment->instruction            = $assessmentData['instruction'];
            $assessment->num_required_reviews   = $assessmentData['num_required_reviews'];
            $assessment->max_score              = $assessmentData['max_score'];
            $assessment->due_date               = $assessmentData['due_date'];
            $assessment->type                   = $assessmentData['type'];
            $assessment->save();
        }
        
        // for teachers
        foreach ($data['teachers'] as $teacherNum) {
            $teacherId = User::where('snumber', $teacherNum)->first()->id;
            $course->users()->attach($teacherId);
        }

        // for students
        $assessments = $course->assessments;
        foreach ($data['students'] as $studentNum) {
            
            $student = User::where('snumber', $studentNum)->first();
            
            // Check if the student exists
            if ($student) {
                $studentId = $student->id;
            } 
            else {
                // If the student doesn't exist, create them
                // assign a default password as their snumber
                $newStudent = User::create([
                    'name' => $studentNum,
                    'snumber' => $studentNum,
                    'password' => Hash::make($studentNum),
                    'type' => 'student',
                    'remember_token' => Str::random(10),
                ]);       
                $studentId = $newStudent->id;
            }

            $course->users()->attach($studentId);
            foreach ($assessments as $assessment) {
                $assessment->students()->attach($studentId);
            }
        }
        
        return redirect("course/$course->id");
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        // TODO: $teachers, $assessments 필요?
        $teachers = $course->teachers;
        $assessments = $course->assessments()
                        ->with(['students' => function ($query) {
                            $query->where('users.id', Auth::id());
                        }])->get();
        return view('courses.show')->with('teachers', $teachers)->with('assessments', $assessments)->with('course', $course);
    }

    public function enrollPage(Course $course)
    {
        $enrolledStudentIds = $course->students->pluck('id');
        $unenrolledStudents = User::where('type', 'student')
                                ->whereNotIn('id', $enrolledStudentIds)
                                ->orderBy('snumber')
                                ->get();
    
        return view('courses.enroll')->with('students', $unenrolledStudents)->with('course', $course);
    }

    public function enroll(Request $request, Course $course)
    {
        $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:users,id',
        ]);
        
        $assessments = $course->assessments;
        foreach ($request->students as $student)
        {
            $course->users()->attach($student);
            foreach ($assessments as $assessment) {
                $assessment->students()->attach($student);
            }
        }

        return redirect("course/$course->id/enroll");
    }
}
