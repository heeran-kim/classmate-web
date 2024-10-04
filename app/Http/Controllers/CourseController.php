<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Course;
use App\Models\Assessment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the course.
     */
    public function index()
    {
        $courses = Auth::user()->courses;
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return view('courses.create');
    }

    private function validateCourseData(array $data)
    {
        Validator::make($data, [
            // Course validation
            'code'                                  => ['required', 'string', 'regex:/^\d{4}[A-Z]{3}$/', 'unique:courses,code'],
            'name'                                  => 'required|string|max:100',
            
            // Assessments validation
            'assessments'                           => 'required|array|min:1',
            'assessments.*.title'                   => 'required|string|max:20',
            'assessments.*.num_required_reviews'    => 'required|integer|min:1',
            'assessments.*.max_score'               => 'required|integer|min:1|max:100',
            'assessments.*.due_date'                => 'required|date',
            'assessments.*.type'                    => 'required|in:student-select,teacher-assign',
            
            // Teachers validation
            'teachers'                              => 'required|array|min:1',
            'teachers.*'                            => ['required', 'exists:users,snumber', 
                                                            Rule::exists('users', 'type')->where(function ($query) {
                                                                $query->where('type', 'teacher');
                                                            }),
                                                        ],

            // Students validation
            'students'                              => 'array',
            'students.*.snumber'                    => 'required|string|regex:/^S\d{4}$/',
        ], [
            'code.regex'                => 'The course code must be 4 digits followed by 3 uppercase letters.',
            'assessments.*.type.in'     => 'Assessment type must be either student-select or teacher-assign.',
            'students.*.snumber.regex'  => 'The student number must follow the format "S####".',
        ])->validate();
    }

    private function attachStudentsToCourse($course, $studentIds) {
        // Attach students to the course without creating duplicates
        $course->users()->syncWithoutDetaching($studentIds);
        
        // Attach students to the course assessments without creating duplicates
        $assessments = $course->assessments;
        foreach ($assessments as $assessment) {
            $assessment->students()->syncWithoutDetaching($studentIds);
        }
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request) 
    {
        // Validate the uploaded JSON file
        $request->validate([
            'jsonFile' => 'required|file|mimes:json', 
        ]);
        
        // Read and decode the contents of the JSON file
        $file = $request->file('jsonFile');
        $jsonContents = file_get_contents($file->getPathName());
        $data = json_decode($jsonContents, true);

        // Validate the data extracted from the JSON file (e.g., course, assessments, teachers, students)
        $this->validateCourseData($data);
            
        $imageStore = null;
        // Check if an image file is uploaded and store it
        if ($request->hasFile('image')) {
            $imageStore = $request->file('image')->store('courses_images', 'public');
        }
        
        // Create a new course using the validated data
        $course = Course::create([
            'code'  => $data['code'],
            'name'  => $data['name'],
            'image' => $imageStore,
        ]);

        // Create assessments for the course based on the provided data
        foreach ($data['assessments'] as $assessmentData) {
            Assessment::create([
                'title'                 => $assessmentData['title'],
                'instruction'           => $assessmentData['instruction'],
                'num_required_reviews'  => $assessmentData['num_required_reviews'],
                'max_score'             => $assessmentData['max_score'],
                'due_date'              => new DateTime($assessmentData['due_date']),
                'type'                  => $assessmentData['type'],
                'course_id'             => $course->id,
            ]);
        }
        
        // Attach teachers to the course using their staff number (snumber) without creating duplicates
        foreach ($data['teachers'] as $teacherNum) {
            $teacher = User::where('snumber', $teacherNum)->firstOrFail();
            $course->users()->syncWithoutDetaching($teacher->id);
        }

        // Array to collect student IDs
        $studentIds = [];

        // Create students or retrieve existing ones
        foreach ($data['students'] as $studentNum) {
            $student = User::firstOrCreate(
                ['snumber' => $studentNum],
                [
                    'name'              => $studentNum,
                    'snumber'           => $studentNum,
                    'password'          => Hash::make($studentNum), // Default password is the student's snumber
                    'type'              => 'student',
                    'remember_token'    => Str::random(10),
                ]
            );
            $studentIds[] = $student->id;
        }

        // Attach students to the course and associated assessments without creating duplicates
        $this->attachStudentsToCourse($course, $studentIds);
        
        // Redirect to the course details page after creation
        return redirect()->route('course.show', $course);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $teachers = $course->teachers;
        $assessments = $course->assessments()
                        ->with(['students' => function ($query) {
                            $query->where('users.id', Auth::id());
                        }])->get();
        return view('courses.show', compact('teachers', 'assessments', 'course'));
    }

    /**
     * Show the form to enroll students.
     */
    public function enrollPage(Course $course)
    {
        $enrolledStudentIds = $course->students->pluck('id');
        $unenrolledStudents = User::where('type', 'student')
                                ->whereNotIn('id', $enrolledStudentIds)
                                ->orderBy('snumber')
                                ->get();
    
        return view('courses.enroll', compact('unenrolledStudents', 'course'));
    }

    /**
     * Enroll students into the course.
     */
    public function enroll(Request $request, Course $course)
    {
        // Validate the students input
        $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:users,id',
        ]);
    
        // Attach students to the course and associated assessments without creating duplicates
        $this->attachStudentsToCourse($course, $request->students);
    
        return redirect()->route('course.show', $course);
    }
}
