<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    function course() {
        return $this->belongsTo(Course::class);
    }

    function assessmentStudents() {
        return $this->hasMany(AssessmentStudent::class);
    }
}
