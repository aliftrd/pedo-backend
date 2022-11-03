<?php
header("Content-Type: application/json");
require_once '../config.php';
require_once '../vendor/autoload.php';

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

        $query = "SELECT * FROM users WHERE email = '{$email}' LIMIT 1";
        $user = $db->query($query)->fetch(\PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password']) || !is_null($user['deleted_at'])) {
            return error_response('Kredensial tidak valid', null, 401);
        }

        $token = generate_token();
        $user_agent = base64_encode($_SERVER['HTTP_USER_AGENT']);
        $timestamps = epoch_time();

        $query = "INSERT INTO user_access_tokens VALUES (NULL, '{$user['id']}', '{$token}', '{$user_agent}', '{$timestamps}', '{$timestamps}')";
        $db->prepare($query)->execute();

        unset($user['password']);
        return success_response('Berhasil login', compact('token', 'user'), 200);
    default:
        echo 'Method Not Allowed';
        http_response_code(404);
        return;
}
