<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mailings extends Model
{
    use HasFactory;

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
