<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;

class AnimalBreed extends Model
{
    protected $fillable = [
        'title',
    ];
}
