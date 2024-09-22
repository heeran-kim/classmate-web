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
            ['code' => '7805ICT', 'name' => 'Software Design', 'image' => 'courses_images/software_design.png'],
            ['code' => '7004ICT', 'name' => 'Computer Networking Essentials', 'image' => 'courses_images/7004ICT.png'],
        ]);
    }
}
