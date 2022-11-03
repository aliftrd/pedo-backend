<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/connection.php';

use \Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'level',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getCreatedAtAttribute()
    {
        return $this->attributes['created_at'];
    }
}
