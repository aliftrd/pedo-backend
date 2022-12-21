<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function scopeFindByCityId($query, $city)
    {
        $query->where('city_id', $city);
    }
}
