<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentStudent extends Model
{
    use HasFactory;

    function assessment() {
        return $this->belongsTo(Assessment::class);
    }

    function student() {
        return $this->belongsTo(User::class);
    }

    function reviews() {
        return $this->hasMany(Review::class);
    }

}
