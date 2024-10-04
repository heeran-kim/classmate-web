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
        
        return view('users.rank', compact('reviewers'));
    }
    
}
