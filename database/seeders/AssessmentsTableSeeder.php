<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AssessmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assessments for Course 1 (3 assessments with max scores: 30, 30, 40)
        DB::table('assessments')->insert([
            'title' => 'Course 1 Assessment 1',
            'instruction' => 'Instructions for Assessment 1 of Course 1.',
            'num_required_reviews' => 3,
            'max_score' => 30,
            'due_date' => now()->addDays(7), // Due in 7 days
            'type' => 'peer-review',
            'course_id' => 1,  // Course 1
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('assessments')->insert([
            'title' => 'Course 1 Assessment 2',
            'instruction' => 'Instructions for Assessment 2 of Course 1.',
            'num_required_reviews' => 3,
            'max_score' => 30,
            'due_date' => now()->addDays(14), // Due in 14 days
            'type' => 'peer-review',
            'course_id' => 1,  // Course 1
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('assessments')->insert([
            'title' => 'Course 1 Assessment 3',
            'instruction' => 'Instructions for Assessment 3 of Course 1.',
            'num_required_reviews' => 3,
            'max_score' => 40,
            'due_date' => now()->addDays(21), // Due in 21 days
            'type' => 'peer-review',
            'course_id' => 1,  // Course 1
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assessments for Course 2 (2 assessments with max scores: 50, 50)
        DB::table('assessments')->insert([
            'title' => 'Course 2 Assessment 1',
            'instruction' => 'Instructions for Assessment 1 of Course 2.',
            'num_required_reviews' => 3,
            'max_score' => 50,
            'due_date' => now()->addDays(7), // Due in 7 days
            'type' => 'peer-review',
            'course_id' => 2,  // Course 2
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('assessments')->insert([
            'title' => 'Course 2 Assessment 2',
            'instruction' => 'Instructions for Assessment 2 of Course 2.',
            'num_required_reviews' => 3,
            'max_score' => 50,
            'due_date' => now()->addDays(14), // Due in 14 days
            'type' => 'peer-review',
            'course_id' => 2,  // Course 2
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
