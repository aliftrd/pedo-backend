<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
