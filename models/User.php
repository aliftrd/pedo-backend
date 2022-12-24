<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    const PETFINDER = 'Petfinder';
    const PETOWNER = 'Petowner';

    const LEVELS = [
        self::PETFINDER => self::PETFINDER,
        self::PETOWNER => self::PETOWNER,
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'level',
    ];

    protected $hidden = [
        'password',
    ];

    public function getImageAttribute($value)
    {
        return base_url('storage/images/user/avatar/' . $value);
    }
}
