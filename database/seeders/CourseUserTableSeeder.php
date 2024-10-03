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
        $teachersIds = range(1, $numTeachers);

        $courses = Course::all();
        foreach ($courses as $course) {
            shuffle($teachersIds);
            $randomUsersIds = array_slice($teachersIds, 0, 3);
            
            foreach ($randomUsersIds as $randomUserId) {
                DB::table('course_user')->insert([
                    'course_id' => $course->id,
                    'user_id' => $randomUserId,
                ]);
            }
        }

        // Enroll students
        $numUsers = User::all()->count();
        $studentsIds = range($numTeachers + 1, $numUsers);
        $numCourses = Course::all()->count();

        $courses = Course::where('id', '<', $numCourses)->get();
        foreach ($courses as $course) {
            $numStudentsToEnroll = rand(0, $numUsers - $numTeachers);
            shuffle($studentsIds);
            $randomUsersIds = array_slice($studentsIds, 0, $numStudentsToEnroll);
            
            foreach ($randomUsersIds as $randomUserId) {
                DB::table('course_user')->insert([
                    'course_id' => $course->id,
                    'user_id' => $randomUserId,
                ]);
            }
        }

        $course = Course::find($numCourses);
        foreach ($studentsIds as $studentIndex) {
            DB::table('course_user')->insert([
                'course_id' => $course->id,
                'user_id' => $studentIndex,
            ]);
        }
    }
}
