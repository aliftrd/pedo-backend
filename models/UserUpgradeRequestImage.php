<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;

class UserUpgradeRequestImage extends Model
{
    protected $fillable = [
        'user_upgrade_request_id',
        'path',
    ];

    public function request()
    {
        return $this->belongsTo(UserUpgradeRequest::class);
    }
}
