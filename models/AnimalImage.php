<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;

class AnimalImage extends Model
{
    protected $fillable = [
        'animal_id',
        'path',
    ];

    public function getPathAttribute($value)
    {
        return base_url($value);
    }
}
