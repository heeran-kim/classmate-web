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
            ['snumber' => 'S0001', 'password' => bcrypt('password'), 'name' => 'Alice', 'email' => 'alice@example.com', 'type' => 'student'],
            ['snumber' => 'S0002', 'password' => bcrypt('password'), 'name' => 'Bob', 'email' => 'bob@example.com', 'type' => 'student'],
            ['snumber' => 'S0003', 'password' => bcrypt('password'), 'name' => 'Charlie', 'email' => 'charlie@example.com', 'type' => 'student'],
            ['snumber' => 'S1001', 'password' => bcrypt('password'), 'name' => 'Professor X', 'email' => 'professorx@example.com', 'type' => 'teacher'],
        ]);
    }
}
