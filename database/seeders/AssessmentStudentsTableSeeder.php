<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssessmentStudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assessment_students')->insert([
            ['assessment_id' => 1, 'student_id' => 1, 'score' => 90],
            ['assessment_id' => 1, 'student_id' => 2, 'score' => 85],
            ['assessment_id' => 1, 'student_id' => 3, 'score' => 88],
            ['assessment_id' => 2, 'student_id' => 1, 'score' => null],
            ['assessment_id' => 2, 'student_id' => 2, 'score' => null],
            ['assessment_id' => 2, 'student_id' => 3, 'score' => null]
        ]);
    }
}
