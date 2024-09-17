<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    function courseUsers() {
        return $this->hasMany(CourseUser::class);
    }

    function assessments() {
        return $this->hasMany(Assessment::class);
    }
}
