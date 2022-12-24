<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use Helper\Flash;
use Models\Article;

if (isset($_POST['_method']) && $_POST['_method'] == 'DELETE') {
    Article::destroy($_POST['id']);
    Flash::setFlash('success', 'Berhasil menghapus article');

    return header('Location:' . base_url('articles'));
} else {
    return error_response('Method not allowed');
}
