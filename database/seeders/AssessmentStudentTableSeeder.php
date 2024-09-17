<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssessmentStudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assessment_student')->insert([
            // Assignment 1 참여 (모두 리뷰 완료)
            ['assessment_id' => 1, 'student_id' => 1, 'grade' => 90],  // Alice가 Assignment 1에서 90점
            ['assessment_id' => 1, 'student_id' => 2, 'grade' => 85],  // Bob이 Assignment 1에서 85점
            ['assessment_id' => 1, 'student_id' => 3, 'grade' => 88],  // Charlie가 Assignment 1에서 88점
            // Assignment 2 참여 (Bob과 Charlie는 리뷰를 작성하지 않았으므로 점수 미부여)
            ['assessment_id' => 2, 'student_id' => 1, 'grade' => null],  // Alice가 리뷰를 완료해야 점수 부여
            ['assessment_id' => 2, 'student_id' => 2, 'grade' => null],  // Bob이 리뷰를 완료해야 점수 부여
            ['assessment_id' => 2, 'student_id' => 3, 'grade' => null],  // Charlie가 리뷰를 완료해야 점수 부여
        ]);
    }
}
