<?php

namespace Models;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/connection.php');

use \Illuminate\Database\Eloquent\Model;
use Models\Admin;
use Illuminate\Database\Eloquent\SoftDeletes;


class Article extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'admin_id',
        'title',
        'slug',
        'description',
        'thumbnail',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(ArticleCategory::class, 'article_has_category', 'article_id', 'article_category_id');
    }

    public function getThumbnailAttribute($value)
    {
        return base_url('storage/images/articles/thumbnail/' . $value);
    }
}
