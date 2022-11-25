<?php
header('Content-Type: application/json');
require_once('../vendor/autoload.php');

use Models\Animal;
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

        $animals = Animal::with('user_meta.user')->get();

        return success_response('Berhasil mengambil data', compact('animals'));
    default:
        return error_response('Method Not Allowed');
}
