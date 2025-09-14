<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Note extends Eloquent
{
    /**
     * Use MongoDB connection and notes collection.
     */
    protected $connection = 'mongodb';
    protected $collection = 'notes';

    /**
     * Allow mass assignment.
     */
    protected $fillable = ['date', 'title', 'description'];

    /**
     * Mongo uses _id as primary key; not incrementing.
     */
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
