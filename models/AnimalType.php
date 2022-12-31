<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
    ];
    public function animalType()
    {
        return $this->belongsTo('AnimalType');
    }
}
