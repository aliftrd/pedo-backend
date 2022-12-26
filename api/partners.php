<?php
header('Content-Type: application/json');
require_once('../vendor/autoload.php');

use Models\Animal;
use Models\UserAccessToken;

$authorization = get_bearer_token();
if (!$authorization['status']) {
    return error_response($authorization['message'], null, 401);
}

$token = $authorization['message'];
$isLogin = UserAccessToken::where('token', $token)->first();
if (!$isLogin || is_null($isLogin)) {
    return error_response('Kredensial tidak valid', null, 401);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $total = Animal::count(); // Total of records
        $current_page = $_GET['page'] ?? 1; // Page indicator
        $per_page = 5; // Limit per page
        $offset = ($current_page - 1) * $per_page; // Skip records
        $last_page = ceil($total / $per_page); // Total page

        $prev_page_url = $current_page < 2 ? null : base_url('api/partners.php?page=' .  ($current_page - 1)); // Previous page link
        $next_page_url = $current_page == $last_page ? null : base_url('api/partners.php?page=' . ($current_page + 1)); // Next page link

        $animal_data = Animal::with(['user_meta.user', 'animal_images', 'animal_type', 'animal_breed'])
            ->findByPartner($isLogin->user_id)
            ->findByStatus($_GET['status'] ?? 'pending')
            ->offset($offset)
            ->limit($per_page)
            ->orderBy('id', 'DESC');

        $data = [
            'current_page' => $current_page,
            'data' => $animal_data->get(),
            'form' => $offset + 1,
            'next_page_url' => $next_page_url,
            'per_page' => $per_page,
            'prev_page_url' => $prev_page_url,
            'to' => $offset + $per_page,
        ];

        return success_response('Berhasil mengambil data', $data);
    default:
        return error_response('Method not allowed');
}
