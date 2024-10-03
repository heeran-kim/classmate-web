<?php

namespace Database\Seeders;

use App\Models\Assessment;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\AssessmentStudent;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();  // Create a Faker instance

        // Get assessments with their students
        $totalCount = Assessment::all()->count();
        $assessments = Assessment::where('id', '<', $totalCount)
                                    ->with('students')->get();

        foreach ($assessments as $assessment) {
            // Get all students in the current assessment
            $studentsInAssessment = $assessment->students->pluck('id')->toArray();

            // Generate reviews for each student in the assessment
            foreach ($studentsInAssessment as $reviewerId) {
                // Shuffle the list of students and remove the reviewer from potential reviewees
                $possibleReviewees = array_diff($studentsInAssessment, [$reviewerId]);
                shuffle($possibleReviewees);

                // Pick the first 3 unique reviewees from the shuffled list
                $reviewees = array_slice($possibleReviewees, 0, 3);

                // Get the AssessmentStudent record for the current reviewer
                $assessmentStudent = AssessmentStudent::where('assessment_id', $assessment->id)
                                                        ->where('student_id', $reviewerId)
                                                        ->first();

                // Create a review for each of the 3 selected reviewees
                foreach ($reviewees as $revieweeId) {
                    DB::table('reviews')->insert([
                        'text' => $faker->sentence(10),  // Generate random sentence with 10 words
                        'rating' => rand(1, 5),  // Random rating between 1 and 5
                        'reviewee_id' => $revieweeId,  // Assign the reviewee
                        'assessment_student_id' => $assessmentStudent->id,  // Assign the assessment_student_id of the reviewer
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}