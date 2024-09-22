<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Course;
use App\Models\Assessment;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Auth::user()->courses;
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
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
            'jsonFile' => 'required|file|mimes:json', 
        ]);
        
        $file = $request->file('jsonFile');
        $jsonContents = file_get_contents($file->getPathName());
        $data = json_decode($jsonContents, true);

        if (Course::where('code', $data['code'])->exists()) {
            return back()->withErrors(['jsonFile' => 'Course code (' . $data['code'] . ') already exist.']);
        }
            
        $imageStore = null;
        if ($request->hasFile('image')) {
            $imageStore = $request->file('image')->store('courses_images', 'public');
        }
        
        $course = Course::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'image' => $imageStore ?? 'course_images/default.png',
        ]);

        // assessments
        foreach ($data['assessments'] as $assessmentData) {
            $assessment = Assessment::create([
                'title'                 => $assessmentData['title'],
                'instruction'           => $assessmentData['instruction'],
                'num_required_reviews'  => $assessmentData['num_required_reviews'],
                'max_score'             => $assessmentData['max_score'],
                'due_date'              => new DateTime($assessmentData['due_date']),
                'type'                  => $assessmentData['type'],
                'course_id'             => $course->id,
            ]);
        }
        
        // teachers
        foreach ($data['teachers'] as $teacherNum) {
            $teacher = User::where('snumber', $teacherNum)->firstOrFail();
            $course->users()->attach($teacher->id);
        }

        // students
        $assessments = $course->assessments;
        foreach ($data['students'] as $studentNum) {
            $student = User::firstOrCreate(
                ['snumber' => $studentNum],
                [
                    'name' => $studentNum,
                    'snumber' => $studentNum,
                    'password' => Hash::make($studentNum),
                    'type' => 'student',
                    'remember_token' => Str::random(10),
                ]
            );

            $course->users()->attach($student->id);
            
            foreach ($assessments as $assessment) {
                $assessment->students()->attach($student->id);
            }
        }
        
        return redirect()->route('course.show', $course->id);
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
