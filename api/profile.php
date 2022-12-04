<?php
header('Content-Type: application/json');
require_once('../vendor/autoload.php');

use Models\User;
use Models\UserAccessToken;
use Rakit\Validation\Validator;

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
        $user = User::find($isLogin->user_id);

        return success_response('Berhasil mengambil user', compact('token', 'user'), 200);
    case 'PUT':
    case 'PATCH':
        parse_str(file_get_contents("php://input"), $_PUT);

        $validator = new Validator;
        $validation = $validator->validate($_PUT, [
            'name' => 'required',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();

            return error_response('Error Validasi', $errors->firstOfAll(), 400);
        }

        $user = User::find($isLogin->user_id);
        $name = $_PUT['name'];

        $user->update([
            'name' => $name,
        ]);

        return success_response('Berhasil mengubah user', $user);
    default:
        return error_response('Method Not Allowed');
}
