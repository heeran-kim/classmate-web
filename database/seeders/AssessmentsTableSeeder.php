<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssessmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assessments')->insert([
            ['title' => 'Week 1 Peer Review', 'instruction' => 'Submit your first draft for peer review.', 'num_required_reviews' => 2, 'max_score' => 40, 'due_date' => '2024-11-01 23:59:00', 'type' => 'peer_review', 'course_id' => 1],
            ['title' => 'Week 2 Peer Review', 'instruction' => 'Submit your final paper for peer review.', 'num_required_reviews' => 3, 'max_score' => 60, 'due_date' => '2024-12-01 23:59:00', 'type' => 'peer_review', 'course_id' => 1],
        ]);
    }
}
