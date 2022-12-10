<?php
header('Content-Type: application/json');
require_once('../vendor/autoload.php');

use Helper\Storage;
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
    case 'POST':
        try {
            if (count($_POST) < 1) {
                $_POST = json_decode(file_get_contents('php://input'), true) ?? [];
            }

            $validator = new Validator;
            $validation = $validator->validate($_POST + $_FILES, [
                'name' => 'required',
                'image' => 'nullable',
                'confirm_password' => 'required',
            ]);

            if ($validation->fails()) {
                $errors = $validation->errors();

                return error_response('Error Validasi', $errors->firstOfAll(), 400);
            }

            $user = User::findOrFail($isLogin->user_id);
            $name = htmlspecialchars($_POST['name']);
            $confirm_password = $_POST['confirm_password'];

            if ($_POST['image'] != null) {
                $image = Storage::uploadFromBase64($_POST['image'], 'storage/images/user/avatar');

                // Delete old image
                if ($user->getRawOriginal('image') != 'default.jpg') {
                    Storage::delete('storage/images/user/avatar', $user->getRawOriginal('image'));
                }
            }

            if (!password_verify($confirm_password, $user->password)) {
                return error_response('Password salah', null, 401);
            }

            $user->update([
                'name' => $name,
                'image' => $image ?? $user->getRawOriginal('image'),
            ]);

            return success_response('Berhasil mengubah user', $user);
        } catch (\Exception $e) {
            return error_response('Method Not Allowed, ' . $e->getMessage() . ' Code : ' . $e->getCode());
        }
    default:
        return error_response('Method Not Allowed');
}
