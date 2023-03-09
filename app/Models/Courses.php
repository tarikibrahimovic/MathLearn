<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'user_id',
        'status',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'jmbg');
    }
}
