<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Notes extends Eloquent
{
    /**
     * Connection name for this model.
     */
    protected $connection = 'mongodb';

    /**
     * MongoDB collection name.
     */
    protected $collection = 'notes';

    /**
     * Fillable attributes. Adjust to your schema.
     */
    protected $fillable = [
        'title',
        'content',
    ];

    /**
     * MongoDB uses _id as the primary key.
     */
    protected $primaryKey = '_id';

    /**
     * _id is not auto-incrementing and is an ObjectId (string cast).
     */
    public $incrementing = false;
    protected $keyType = 'string';
}

