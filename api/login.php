<?php
header("Content-Type: application/json");
require_once('../vendor/autoload.php');

use Models\User;
use Models\UserAccessToken;
use Rakit\Validation\Validator;

if (count($_POST) < 1) {
    $_POST = json_decode(file_get_contents('php://input'), true) ?? [];
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $validator = new Validator;
        $validation = $validator->validate($_POST, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();

            return error_response('Error Validasi', $errors->firstOfAll(), 400);
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = User::where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password']) || !is_null($user['deleted_at'])) {
            return error_response('Kredensial tidak valid', null, 401);
        }

        $token = generate_token();
        $user_agent = base64_encode($_SERVER['HTTP_USER_AGENT']);
        $timestamps = epoch_time();

        UserAccessToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'user_agent' => $user_agent,
            'created_at' => $timestamps,
            'updated_at' => $timestamps,
        ]);

        return success_response('Berhasil login', compact('token', 'user'));
    default:
        return error_response('Method Not Allowed');
}
