<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    function assessments() {
        return $this->hasMany(Assessment::class);
    }

    function teachers() {
        return $this->users()
                    ->where('type', 'teacher')
                    ->orderBy('name');
    }

    function students() {
        return $this->users()
                    ->where('type', 'student')
                    ->orderBy('name');
    }

    function users() {
        return $this->belongsToMany(User::class);
    }
}
