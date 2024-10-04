<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display highest reviewers
     */
    public function rank()
    {
        $students = User::where('type', 'student')->get();
        $ratings = [];
        foreach ($students as $student) {
            $reviews = $student->reviewsSubmitted()->orderBy('rating', 'desc')->limit(5)->get();
            $ratings[] = ['user' => $student,
                        'reviews' => $reviews,
                        'avg_rating' => $student->getAverageRating()
                        ];
        }
        usort($ratings, function ($a, $b) {
            return $b['avg_rating'] <=> $a['avg_rating'];
        });
        $top5 = array_slice($ratings, 0, 5);
        
        return view('users.rank', compact('top5'));
    }
}
