<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['snumber' => 'S001', 'password' => bcrypt('password'), 'name' => 'Alice', 'email' => 'alice@example.com', 'type' => 'student'],
            ['snumber' => 'S002', 'password' => bcrypt('password'), 'name' => 'Bob', 'email' => 'bob@example.com', 'type' => 'student'],
            ['snumber' => 'S003', 'password' => bcrypt('password'), 'name' => 'Charlie', 'email' => 'charlie@example.com', 'type' => 'student'],
            ['snumber' => 'T001', 'password' => bcrypt('password'), 'name' => 'Professor X', 'email' => 'professorx@example.com', 'type' => 'teacher'],
        ]);
    }
}
