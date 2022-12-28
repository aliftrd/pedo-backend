<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    const PENDING = 'pending';
    const APPROVED = 'accepted';
    const ADOPTED = 'adopted';
    const REJECTED = 'rejected';

    use SoftDeletes;

    protected $fillable = [
        'animal_type_id',
        'animal_breed_id',
        'user_meta_id',
        'title',
        'description',
        'is_paid',
        'price',
        'gender',
        'primary_color',
        'secondary_color',
        'status'
    ];

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

    public function scopeActive($query)
    {
        return $query->where('status', self::APPROVED);
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
}
