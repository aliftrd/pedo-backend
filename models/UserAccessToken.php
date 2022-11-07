<?php

namespace Models;

require_once(realpath('vendor/autoload.php'));
require_once(realpath('connection.php'));

use \Illuminate\Database\Eloquent\Model;

class UserAccessToken extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'token',
        'user_agent',
        'created_at',
        'updated_at',
    ];
}
