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
            // Get all students with scores for this assessment (only students, no teachers)
            $studentsWithScores = DB::table('assessment_student')
                ->join('users', 'assessment_student.student_id', '=', 'users.id')  // Join with users to ensure the type
                ->where('assessment_student.assessment_id', $assessment->id)
                ->where('users.type', 'student')  // Ensure only students are included
                ->whereNotNull('assessment_student.score')  // Only students with scores
                ->select('assessment_student.*')  // Select only the necessary columns
                ->get();

            // Get the required number of reviews for this assessment
            $numRequiredReviews = $assessment->num_required_reviews;

            foreach ($studentsWithScores as $studentWithScore) {
                // Get all students enrolled in the same course who are potential reviewees
                $studentsInCourse = DB::table('course_user')
                    ->join('users', 'course_user.user_id', '=', 'users.id')
                    ->where('course_user.course_id', $assessment->course_id)
                    ->where('users.type', 'student')  // Ensure only students are included
                    ->where('course_user.user_id', '!=', $studentWithScore->student_id)  // Exclude the reviewer (student with score)
                    ->pluck('course_user.user_id')->toArray();  // Get only student IDs

                // Shuffle and select the required number of reviewees
                shuffle($studentsInCourse);
                $selectedReviewees = array_slice($studentsInCourse, 0, $numRequiredReviews);

                foreach ($selectedReviewees as $revieweeId) {
                    // Insert the review with varied review text
                    DB::table('reviews')->insert([
                        'text' => $faker->sentence(10),  // Generate random sentence with 10 words
                        'rating' => rand(1, 5),  // Random rating between 1 and 5
                        'reviewee_id' => $revieweeId,
                        'assessment_student_id' => $studentWithScore->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}