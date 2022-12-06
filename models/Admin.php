<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Models\Article;

class Admin extends Model
{
    use SoftDeletes;

    const DEVELOPER = 'Developer';
    const ADMIN = 'Admin';

    const LEVELS = [
        self::DEVELOPER => self::DEVELOPER,
        self::ADMIN => self::ADMIN,
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'level'
    ];

    protected $hidden = [
        'password',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function getImageAttribute($value)
    {
        return base_url('storage/images/admin/avatar/' . $value);
    }
}
