<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'title',
        'details',
        'idCategory',
        'idUser',
        'dateFin',
        'dateDebut',
        'public',
        'registeredDate',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'registeredDate' => 'datetime',
    ];

}
