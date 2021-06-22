<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'idEvent',
        'registeredDate',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'registeredDate' => 'datetime',
    ];

}
