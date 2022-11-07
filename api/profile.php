<?php

require_once('../vendor/autoload.php');

use Models\User;
use Models\UserAccessToken;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $authorization = get_bearer_token();
        if (!$authorization['status']) {
            return error_response($authorization['message'], null, 401);
        }

        $token = $authorization['message'];
        $isLogin = UserAccessToken::where('token', $token)->first();
        if (!$isLogin || is_null($isLogin)) {
            return error_response('Kredensial tidak valid', null, 401);
        }

        $user = User::find($isLogin->user_id);

        return success_response('Berhasil mengambil user', compact('token', 'user'), 200);
    case 'PUT':
        $email = json_decode(file_get_contents("php://input"), true);

        return success_response('PUT', $email);
    default:
        return error_response('Method Not Allowed');
}
