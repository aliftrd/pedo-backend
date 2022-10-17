<?php
header('Content-Type: application/json');
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    http_response_code(404);
    return;
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

return success_response('Berhasil mengambil user', [
    'token' => $token,
    'user' => $user,
], 200);
