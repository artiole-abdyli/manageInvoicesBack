<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Mailings extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'from',
        'to',
        'message',
        'date',
        'subject',
        'title',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
}