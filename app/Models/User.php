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
        'email',
        'password',
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
        // This method defines a hasManyThrough relationship from User to Course through the CourseUser pivot table.
        return $this->hasManyThrough(
            Course::class,       // The final model we want to retrieve (Course model).
            CourseUser::class,   // The intermediate model that connects User and Course (CourseUser model).
            'user_id',           // Foreign key on the intermediate model.
            'id',                // Foreign key on the final model (Course) that links to the intermediate table (course_id).
            'id',                // Local key on the current model.
            'course_id'          // Local key on the intermediate model that links to the final model.
        );
    }
    
    function courseUsers() {
        return $this->hasMany(CourseUser::class);
    }

    function assessmentStudents() {
        return $this->hasMany(AssessmentStudent::class);
    }

    function reviews() {
        return $this->hasMany(Review::class);
    }
}
