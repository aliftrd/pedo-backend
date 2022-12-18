<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function scopeFindByProvinceId($query, $province_id)
    {
        $query->where('province_id', $province_id);
    }
}
