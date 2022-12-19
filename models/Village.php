<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    public function scopeFindByDistrictId($query, $city)
    {
        $query->where('district_id', $city);
    }
}
