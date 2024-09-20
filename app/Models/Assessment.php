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

    function reviews() {
        return $this->hasManyThrough(
            Review::class,       // The final model we want to retrieve.
            AssessmentStudent::class,   // The intermediate model that connects.
            'assessment_id',           // Foreign key on the intermediate model.
            'assessment_student_id',                // Foreign key on the final model that links to the intermediate table.
            'id',                // Local key on the current model.
            'id'          // Local key on the intermediate model that links to the final model.
        );
    }

    function students() {
        return $this->belongsToMany(User::class, 'assessment_student', 'assessment_id', 'student_id');
    }
}
