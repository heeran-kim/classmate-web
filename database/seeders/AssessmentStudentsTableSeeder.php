<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AssessmentStudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all assessments
        $assessments = DB::table('assessments')->get();

        foreach ($assessments as $assessment) {
            // Get all students enrolled in the course associated with this assessment
            $students = DB::table('course_user')
                ->join('users', 'course_user.user_id', '=', 'users.id')
                ->where('course_user.course_id', $assessment->course_id)
                ->where('users.type', 'student')  // Ensure only students are included
                ->get();

            // Assign null scores to all students
            foreach ($students as $student) {
                DB::table('assessment_student')->insert([
                    'assessment_id' => $assessment->id,
                    'student_id' => $student->user_id,
                    'score' => null,  // Default score to null for all students
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Randomly select one student and assign a valid score
            $randomStudent = $students->random();
            DB::table('assessment_student')
                ->where('assessment_id', $assessment->id)
                ->where('student_id', $randomStudent->user_id)
                ->update([
                    'score' => rand(0, $assessment->max_score),  // Assign random score, ensuring it does not exceed the max score
                    'updated_at' => now(),
                ]);
        }
    }
}