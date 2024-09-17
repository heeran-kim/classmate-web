<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('course_users')->insert([
            ['course_id' => 1, 'user_id' => 1],  // Alice가 CS101 수강
            ['course_id' => 1, 'user_id' => 2],  // Bob이 CS101 수강
            ['course_id' => 1, 'user_id' => 3],  // Charlie가 CS101 수강
            ['course_id' => 1, 'user_id' => 4],  // Professor X가 CS101 강의
            ['course_id' => 2, 'user_id' => 1],  // Alice가 MATH201 수강
            ['course_id' => 2, 'user_id' => 2],  // Bob이 MATH201 수강
            ['course_id' => 2, 'user_id' => 4],  // Professor X가 MATH201 강의
        ]);
    }
}
