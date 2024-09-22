<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Create a Faker instance

        // Seed 5 teachers
        for ($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,  // Use Faker to generate random name
                'email' => $faker->unique()->safeEmail,  // Use Faker to generate random unique email
                'type' => 'teacher',
                'snumber' => 'S1' . str_pad($i, 3, '0', STR_PAD_LEFT), // S1000, S1001, etc.
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }

        // Seed 50 students
        for ($i = 0; $i < 50; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,  // Use Faker to generate random name
                'email' => $faker->unique()->safeEmail,  // Use Faker to generate random unique email
                'type' => 'student',
                'snumber' => 'S0' . str_pad($i, 3, '0', STR_PAD_LEFT), // S0000, S0001, etc.
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
