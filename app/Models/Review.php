<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    function assessmentStudent() {
        return $this->belongsTo(AssessmentStudent::class);
    }

    function reviewee() {
        return $this->belongsTo(User::class);
    }
}
