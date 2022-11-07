<?php

namespace Models;

require_once(realpath('vendor/autoload.php'));
require_once(realpath('connection.php'));

use \Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'level',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
    ];
}
