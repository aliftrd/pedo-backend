<?php
header('Content-Type: application/json');
require_once('../vendor/autoload.php');

use Models\Article;
use Models\UserAccessToken;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $authorization = get_bearer_token();
        if (!$authorization['status']) {
            return error_response($authorization['message'], null, 401);
        }

        $user = UserAccessToken::where('token', $authorization['message'])->count();
        if ($user < 1) {
            return error_response('Kredensial tidak valid', null, 401);
        }

        $queryType = $_GET['type'] ?? '';

        $total = Article::count(); // Total of records
        $current_page = $_GET['page'] ?? 1; // Page indicator
        $per_page = 5; // Limit per page
        $offset = ($current_page - 1) * $per_page; // Skip records
        $last_page = ceil($total / $per_page); // Total page

        $prev_page_url = $current_page < 2 ? null : base_url('api/articles.php?page=' .  ($current_page - 1)); // Previous page link
        $next_page_url = $current_page == $last_page ? null : base_url('api/articles.php?page=' . ($current_page + 1)); // Next page link

        $article_data = Article::with(['admin', 'categories']);
        $queryType == '' ?: $article_data->whereRelation('categories', 'title', $queryType); // Filter by category
        $article_data->offset($offset)
            ->limit($per_page)
            ->orderBy('id', 'DESC');

        $data = [
            'current_page' => $current_page,
            'data' => $article_data->get(),
            'form' => $offset + 1,
            'next_page_url' => $next_page_url,
            'per_page' => $per_page,
            'prev_page_url' => $prev_page_url,
            'to' => $offset + $per_page,
        ];

        return success_response('Berhasil mengambil data', $data);
    default:
        return error_response('Method Not Allowed');
}
