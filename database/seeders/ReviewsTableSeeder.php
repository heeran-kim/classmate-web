<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();  // Create a Faker instance

        // Get all assessments
        $assessments = DB::table('assessments')->get();

        foreach ($assessments as $assessment) {
            // Get all students enrolled in the same course
            $studentsInCourse = DB::table('course_user')
                ->join('users', 'course_user.user_id', '=', 'users.id')
                ->where('course_user.course_id', $assessment->course_id)
                ->where('users.type', 'student')  // Ensure only students are included
                ->pluck('course_user.user_id')->toArray();  // Get only student IDs

            // Shuffle and select a random number of reviewees
            shuffle($studentsInCourse);

            // Generate a large number of reviews for each assessment
            for ($i = 0; $i < 50; $i++) {  // Adjust the number of reviews to generate here
                $reviewerId = $faker->randomElement($studentsInCourse);  // Pick a random reviewer
                $revieweeId = $faker->randomElement($studentsInCourse);  // Pick a random reviewee

                // Ensure that the reviewer is not the same as the reviewee
                while ($reviewerId === $revieweeId) {
                    $revieweeId = $faker->randomElement($studentsInCourse);
                }

                // Insert the review with varied review text
                DB::table('reviews')->insert([
                    'text' => $faker->sentence(10),  // Generate random sentence with 10 words
                    'rating' => rand(1, 5),  // Random rating between 1 and 5
                    'reviewee_id' => $revieweeId,
                    'assessment_student_id' => $faker->randomElement($studentsInCourse),  // Random assessment_student_id
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}