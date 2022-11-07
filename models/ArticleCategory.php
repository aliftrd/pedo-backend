<?php

namespace Models;

require_once(realpath('vendor/autoload.php'));
require_once(realpath('connection.php'));

use \Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    public $timestamps = false;
}
