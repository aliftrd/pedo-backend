<?php

namespace Models;

require_once(realpath('vendor/autoload.php'));
require_once(realpath('connection.php'));

use \Illuminate\Database\Eloquent\Model;
use Models\Article;

class Admin extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
