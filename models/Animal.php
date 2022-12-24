<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const ADOPTED = 'adopted';
    const REJECTED = 'rejected';

    use SoftDeletes;

    protected $fillable = [];

    public function user_meta()
    {
        return $this->belongsTo(UserMeta::class);
    }

    public function animal_type()
    {
        return $this->belongsTo(AnimalType::class);
    }

    public function animal_breed()
    {
        return $this->belongsTo(AnimalBreed::class);
    }

    public function animal_images()
    {
        return $this->hasMany(AnimalImage::class);
    }

    public function scopeFindByPartner($query, $user_id)
    {
        return $query->whereHas('user_meta', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        });
    }

    public function scopeFindByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getImageAttribute($value)
    {
        return base_url('storage/images/animals/' . $value);
    }
}
