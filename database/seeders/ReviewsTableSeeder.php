<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            // Alice가 작성한 리뷰
            ['text' => 'Great work, very thorough!', 'rating' => 5, 'reviewee_id' => 2, 'assessment_student_id' => 1],  // Alice가 Bob 리뷰
            ['text' => 'Good effort, but needs more detail.', 'rating' => 4, 'reviewee_id' => 3, 'assessment_student_id' => 1],  // Alice가 Charlie 리뷰
            // Bob이 작성한 리뷰 (추가됨)
            ['text' => 'Well organized, but a few errors.', 'rating' => 4, 'reviewee_id' => 1, 'assessment_student_id' => 2],  // Bob이 Alice 리뷰
            ['text' => 'Solid work, just a bit unclear in parts.', 'rating' => 4, 'reviewee_id' => 3, 'assessment_student_id' => 2],  // Bob이 Charlie 리뷰
            // Charlie가 작성한 리뷰 (추가됨)
            ['text' => 'Fantastic work!', 'rating' => 5, 'reviewee_id' => 1, 'assessment_student_id' => 3],  // Charlie가 Alice 리뷰
            ['text' => 'Keep practicing.', 'rating' => 3, 'reviewee_id' => 2, 'assessment_student_id' => 3],  // Charlie가 Bob 리뷰
        ]);
    }
}
