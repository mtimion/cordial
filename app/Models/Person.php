<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Person extends Model
{
    protected $collection = "people";
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'birthdate', 'timezone',
    ];

    protected $hidden = [
        '_id', 'created_at', 'updated_at'
    ];

}
