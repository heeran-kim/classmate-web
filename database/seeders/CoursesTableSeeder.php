<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            ['code' => 'CS101', 'name' => 'Introduction to Computer Science'],
            ['code' => 'MATH201', 'name' => 'Calculus II'],
        ]);
    }
}
