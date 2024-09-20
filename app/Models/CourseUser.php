<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    protected $table = 'course_user';
    use HasFactory;

    function user() {
        return $this->belongsTo(User::class);
    }
    
    function course() {
        return $this->belongsTo(Course::class);
    }
}
