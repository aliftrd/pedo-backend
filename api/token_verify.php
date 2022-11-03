<?php
header('Content-Type: application/json');
require_once '../config.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $authorization = get_bearer_token();
        if (!$authorization['status']) {
            return error_response($authorization['message'], null, 401);
        }

        $token = $authorization['message'];
        $user = check_is_valid_user($token);
        if (is_null($user) || !$user) {
            return error_response('Kredensial tidak valid', null, 401);
        }

        return success_response('Berhasil mengambil user', compact('token', 'user'), 200);
    default:
        echo 'Method Not Allowed';
        http_response_code(404);
        return;
}
