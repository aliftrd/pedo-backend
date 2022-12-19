<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;

class UserUpgradeRequest extends Model
{
    const PENDING = 'Pending';
    const ACCEPTED = 'Accepted';
    const REJECTED = 'Rejected';

    protected $fillable = [
        'user_id',
        'premise',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
