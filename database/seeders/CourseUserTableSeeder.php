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
        $teachersIds = range(0, $numTeachers - 1);

        $courses = Course::all();
        foreach ($courses as $course) {
            $randomUsersIds = array_rand($teachersIds, 3);
            
            foreach ($randomUsersIds as $randomIndex) {
                DB::table('course_user')->insert([
                    'course_id' => $course->id,
                    'user_id' => $teachersIds[$randomIndex],
                ]);
            }
        }

        // Enroll students
        $numUsers = User::all()->count();
        $studentsIds = range($numTeachers, $numUsers - 1);

        $courses = Course::all();
        foreach ($courses as $course) {
            $numStudentsToEnroll = rand(15, 45);
            $randomUsersIds = array_rand($studentsIds, $numStudentsToEnroll);
            
            foreach ($randomUsersIds as $randomIndex) {
                DB::table('course_user')->insert([
                    'course_id' => $course->id,
                    'user_id' => $studentsIds[$randomIndex],
                ]);
            }
        }
    }
}
