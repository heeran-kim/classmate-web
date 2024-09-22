<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Enroll teachers
        $numTeachers = User::where('type', 'teacher')->count();
        $teachers = range(0, $numTeachers - 1);

        $courses = Course::all();
        foreach ($courses as $course) {
            $randomUsers = array_rand($teachers, 3);
            
            foreach ($randomUsers as $randomUserIndex) {
                $userId = User::findOrFail($randomUserIndex)->first()->id;
                DB::table('course_user')->insert([
                    'course_id' => $course->id,
                    'user_id' => $userId,
                ]);
            }
        }

        // Enroll students
        $numUsers = User::all()->count();
        $students = range($numTeachers, $numUsers - 1);

        $courses = Course::all();
        foreach ($courses as $course) {
            $numStudentsToEnroll = rand(15, 45);
            $randomUsers = array_rand($students, $numStudentsToEnroll);
            
            foreach ($randomUsers as $randomUserIndex) {
                $userId = User::findOrFail($randomUserIndex)->first()->id;
                DB::table('course_user')->insert([
                    'course_id' => $course->id,
                    'user_id' => $userId,
                ]);
            }
        }
    }
}
