<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/connection.php';

include 'Admin.php';
include 'ArticleCategory.php';

use \Illuminate\Database\Eloquent\Model;

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
}
