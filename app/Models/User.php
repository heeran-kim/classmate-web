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
    
    function reviews() {
        return $this->hasManyThrough(
            Review::class,              // The final model we want to retrieve.
            AssessmentStudent::class,   // The intermediate model that connects.
            'student_id',               // Foreign key on the intermediate model.
            'assessment_student_id',    // Foreign key on the final model that links to the intermediate table.
            'id',                       // Local key on the current model.
            'id'                        // Local key on the intermediate model that links to the final model.
        );
    }

    function assessments() {
        return $this->belongsToMany(Assessment::class);
    }
    
}
