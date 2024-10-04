<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'snumber',
        'email',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)
                    ->orderBy('code');
    }
    
    function reviewsSubmitted() {
        return $this->hasManyThrough(
            Review::class,              // The final model we want to retrieve.
            AssessmentStudent::class,   // The intermediate model that connects.
            'student_id',               // Foreign key on the intermediate model.
            'assessment_student_id',    // Foreign key on the final model that links to the intermediate table.
            'id',                       // Local key on the current model.
            'id'                        // Local key on the intermediate model that links to the final model.
        );
    }

    function reviewsSubmittedForAssessment($assessmentId) {
        return $this->reviewsSubmitted()->where('assessment_id', $assessmentId);
    }

    function reviewsReceived() {
        return $this->hasMany(Review::class, 'reviewee_id', 'id');
    }

    function reviewsReceivedForAssessment($assessmentId) {
        return $this->reviewsReceived()->whereHas('assessmentStudent', function ($query) use ($assessmentId) {
            $query->where('assessment_id', $assessmentId);
        });
    }

    function assessments() {
        return $this->belongsToMany(Assessment::class);
    }

    function getAverageRating() {
        $averageRatings = $this->reviewsSubmitted()->average('rating');
        return $averageRatings;
    }
}
