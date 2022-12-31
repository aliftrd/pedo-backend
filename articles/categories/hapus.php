<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use Helper\Flash;
use Models\ArticleCategory;

if (isset($_POST['_method']) && $_POST['_method'] == 'DELETE') {
    ArticleCategory::destroy($_POST['id']);
    Flash::setFlash('success', 'Berhasil menghapus Kategori Artikel');

    header('Location:' . base_url('articles/categories/index.php'));
} else {
    return error_response('Method not allowed');
}
