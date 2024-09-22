<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'text',
        'reviewee_id',
    ];

    function assessmentStudent()
    {
        return $this->belongsTo(AssessmentStudent::class);
    }

    function reviewee() {
        return $this->belongsTo(User::class);
    }

    function reviewer() {
        return $this->hasOneThrough(
            User::class,       // The final model we want to retrieve.
            AssessmentStudent::class,   // The intermediate model that connects.
            'id',           // Foreign key on the intermediate model.
            'id',                // Foreign key on the final model that links to the intermediate table.
            'assessment_student_id',                // Local key on the current model.
            'student_id'          // Local key on the intermediate model that links to the final model.
        );
    }
}
