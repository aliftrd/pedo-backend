<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;
use Models\Article;

class Admin extends Model
{
    public $timestamps = false;

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
