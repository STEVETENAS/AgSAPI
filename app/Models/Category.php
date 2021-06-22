<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'registeredDate',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'registeredDate' => 'datetime',
    ];
}
