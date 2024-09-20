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
            ['code' => '7805ICT', 'name' => 'Software Design'],
            ['code' => '7004ICT', 'name' => 'Computer Networking Essentials'],
        ]);
    }
}
