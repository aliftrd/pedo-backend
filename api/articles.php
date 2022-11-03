<?php
header('Content-Type: application/json');
require '../models/User.php';
require '../models/Article.php';
require '../functions.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $articles = Article::with(['admin', 'categories']);
        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
            $articles->limit($limit);
        }
        $articles->get();

        return success_response('Berhasil mengambil data', compact('articles'));
    default:
        return error_response('Method Not Allowed');
}
