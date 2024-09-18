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
        return $this->hasManyThrough(
            User::class,       // The final model we want to retrieve (Course model).
            CourseUser::class,   // The intermediate model that connects User and Course (CourseUser model).
            'course_id',           // Foreign key on the intermediate model.
            'id',                // Foreign key on the final model (Course) that links to the intermediate table (course_id).
            'id',                // Local key on the current model.
            'user_id'          // Local key on the intermediate model that links to the final model.
        )
        ->where('type', 'teacher')
        ->orderBy('name');
    }

    function students() {
        return $this->hasManyThrough(
            User::class,       // The final model we want to retrieve (Course model).
            CourseUser::class,   // The intermediate model that connects User and Course (CourseUser model).
            'course_id',           // Foreign key on the intermediate model.
            'id',                // Foreign key on the final model (Course) that links to the intermediate table (course_id).
            'id',                // Local key on the current model.
            'user_id'          // Local key on the intermediate model that links to the final model.
        )
        ->where('type', 'student')
        ->orderBy('name');
    }

}
