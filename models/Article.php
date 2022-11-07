<?php

namespace Models;

require_once(realpath('vendor/autoload.php'));
require_once(realpath('connection.php'));

use \Illuminate\Database\Eloquent\Model;
use Models\Admin;

class Article extends Model
{
    public $timestamps = false;

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
        return base_url('storage/images/' . $value);
    }
}
