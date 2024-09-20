<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CourseUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Enroll teachers
        // Teachers 1, 2, 3 for Course 1
        for ($i = 1; $i <= 3; $i++) {
            DB::table('course_user')->insert([
                'course_id' => 1,
                'user_id' => $i,  // Teachers 1, 2, 3 for Course 1
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Teachers 2, 3, 4 for Course 2
        for ($i = 2; $i <= 4; $i++) {
            DB::table('course_user')->insert([
                'course_id' => 2,
                'user_id' => $i,  // Teachers 2, 3, 4 for Course 2
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Enroll the first 8 students (IDs 5 to 12) in Course 1
        for ($i = 5; $i <= 47; $i++) {
            DB::table('course_user')->insert([
                'course_id' => 1,
                'user_id' => $i,  // Students 5 to 12 for Course 1
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Enroll the last 8 students (IDs 7 to 14) in Course 2
        for ($i = 7; $i <= 14; $i++) {
            DB::table('course_user')->insert([
                'course_id' => 2,
                'user_id' => $i,  // Students 7 to 14 for Course 2
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
