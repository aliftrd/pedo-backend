<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalBreed extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'animal_type_id',
        'title',
    ];

    public function animalType()
    {
        return $this->belongsTo(AnimalType::class);
    }
    
    public function scopeGetByAnimalType($query, $animal_type_id)
    {
        return $query->where('animal_type_id', $animal_type_id);
    }
}
