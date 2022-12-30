<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    const PETOWNER = 'petowner';
    const PETFINDER = 'petfinder';

    protected $fillable = [
        'user_id',
        'village_id',
        'phone',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
