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

    public function courses(){
        return $this->hasMany(Courses::class, 'user_id', 'jmbg');
    }
}
