<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'jmbg';
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'gender',
        'date_of_birth',
        'phone_number',
        'address',
        'place_of_birth',
        'jmbg',
        'image',
        'type',
        'verified',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isType($role)
    {
        return $this->type == $role;
    }

    public function courses()
    {
        return $this->hasMany(Courses::class, 'user_id', 'jmbg');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lessons::class, 'lessons_user', 'user_id', 'lesson_id');
    }

    public function isTeacher($courseId)
    {
        $user = User::find(auth()->user()->jmbg);
        if ($user->courses->contains($courseId)) {
            return true;
        }
        return false;
    }

    public function isFollowing($course_id)
    {
        $user = User::find(auth()->user()->jmbg);
        $follows = CoursesUser::where('user_jmbg', $user->jmbg)->where('courses_id', $course_id)->first();
        if ($follows) {
            return true;
        }
        return false;
    }

    public function isUser(){
        $user = User::find(auth()->user()->jmbg);
        if ($user->type == "korisnik"){
            return true;
        }
        return false;
    }

    public function following(){
        return $this->belongsToMany(Courses::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'user_id', 'jmbg');
    }

}
