<?php
header('Content-Type: application/json');
require_once '../config.php';

function getTags($article_id)
{
    $article_tags_query = "SELECT article_categories.*,
    article_has_category.article_id AS pivot_article_id,
    article_has_category.article_category_id AS pivot_article_category_id
    FROM article_categories
    INNER JOIN article_has_category ON article_categories.id = article_has_category.article_category_id
    WHERE article_has_category.article_id IN ($article_id) AND deleted_at IS NULL";

    $result = $GLOBALS['db']->query($article_tags_query)->fetchAll();

    return array_map(function ($result) {
        unset($result['created_at'], $result['updated_at'], $result['deleted_at']);
        return $result;
    }, $result);
}

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
    $article = $db->query($query)->fetch();
    $article_tags = getTags($article['id']);
    $article['categories'] = $article_tags;
    $article['thumbnail'] = base_url('storage/images/' . $article['thumbnail']);

    return success_response('Berhasil mendapatkan artikel', $article, 200);
}

$query = "SELECT * FROM articles WHERE deleted_at IS NULL";

// Query for limit
if (!is_null($limit) && $limit != '') {
    $query = "{$query} LIMIT {$limit}";
}

$articles = $db->query($query)->fetchAll();
$article_id = "";
for ($i = 0; $i < count($articles); $i++) {
    $article_id .= $articles[$i]['id'];
    if ($i != count($articles) - 1) {
        $article_id .= ",";
    }
}

$article_tags = getTags($article_id);

array_walk($articles, function (&$key) use ($article_tags) {
    $key['categories'] = [];
    foreach ($article_tags as $tag) {
        if ($tag['pivot_article_id'] == $key['id']) {
            $key['categories'][] = $tag;
        }
    }

    return $key['thumbnail'] = base_url('storage/images/' . $key['thumbnail']);
});

return success_response('Berhasil mendapatkan artikel', compact('articles'), 200);
