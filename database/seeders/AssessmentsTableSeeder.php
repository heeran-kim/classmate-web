<?php

namespace Database\Seeders;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assessments for 3 courses (3 assessments with max scores: 30, 30, 40)
        $courses = Course::where('id', '<', '3')->get();
        foreach ($courses as $course) {
            DB::table('assessments')->insert([
                'title' => 'Assessment 1',
                'instruction' => 'Instructions for Assessment 1.',
                'num_required_reviews' => 3,
                'max_score' => 30,
                'due_date' => now()->addDays(7),
                'type' => 'student-select',
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('assessments')->insert([
                'title' => 'Assessment 2',
                'instruction' => 'Instructions for Assessment 2.',
                'num_required_reviews' => 3,
                'max_score' => 30,
                'due_date' => now()->addDays(14),
                'type' => 'student-select',
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('assessments')->insert([
                'title' => 'Assessment 3',
                'instruction' => 'Instructions for Assessment 3.',
                'num_required_reviews' => 3,
                'max_score' => 40,
                'due_date' => now()->addDays(21), // Due in 21 days
                'type' => 'student-select',
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Assessments for 2 courses (2 assessments with max scores: 50, 50)
        $courses = Course::where('id', '>=', '3')->get();
        foreach ($courses as $course) {
            DB::table('assessments')->insert([
                'title' => 'Course 2 Assessment 1',
                'instruction' => 'Instructions for Assessment 1 of Course 2.',
                'num_required_reviews' => 3,
                'max_score' => 50,
                'due_date' => now()->addDays(7), // Due in 7 days
                'type' => 'student-select',
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('assessments')->insert([
                'title' => 'Course 2 Assessment 2',
                'instruction' => 'Instructions for Assessment 2 of Course 2.',
                'num_required_reviews' => 3,
                'max_score' => 50,
                'due_date' => now()->addDays(14), // Due in 14 days
                'type' => 'student-select',
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
