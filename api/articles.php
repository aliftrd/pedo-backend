<?php
header('Content-Type: application/json');
require_once '../config.php';

$authorization = get_bearer_token();
if (!$authorization['status']) {
    return error_response($authorization['message'], null, 401);
}

$token = $authorization['message'];
$user = check_is_valid_user($token);
if (is_null($user) || !$user) {
    return error_response('Kredensial tidak valid', null, 401);
}

$slug = $_GET['slug'] ?? null;
$limit = $_GET['limit'] ?? null;

if (!is_null($slug)) {
    $query = "SELECT * FROM articles WHERE slug = '{$slug}' AND deleted_at IS NULL LIMIT 1";
    $articles = $db->query($query)->fetch();
    $articles['thumbnail'] = base_url('storage/images/' . $articles['thumbnail']);

    return success_response('Berhasil mendapatkan artikel', $articles, 200);
}

$query = "SELECT * FROM articles WHERE deleted_at IS NULL";

// Query for limit
if (!is_null($limit) && $limit != '') {
    $query = "{$query} LIMIT {$limit}";
}

$articles = $db->query($query)->fetchAll();

array_walk($articles, function (&$key) {
    return $key['thumbnail'] = base_url('storage/images/' . $key['thumbnail']);
});

return success_response('Berhasil mendapatkan artikel', $articles, 200);
