<?php
header("Content-Type: application/json");
require_once('../vendor/autoload.php');

use Models\UserAccessToken;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $authorization = get_bearer_token();
        if (!$authorization['status']) {
            return error_response($authorization['message'], null, 401);
        }

        UserAccessToken::where('token', $authorization['message'])->delete();
        return success_response('Berhasil keluar', null, 200);
    default:
        return error_response('Method Not Allowed');
}
