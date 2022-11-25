<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;

class UserAccessToken extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'user_agent',
    ];
}
