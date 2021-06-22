<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'fName',
        'lName',
        'studId',
        'idCourse',
        'admin',
        'tel',
        'registeredDate',
    ];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'registeredDate' => 'datetime',
    ];
}
