<?php
header('Content-Type: application/json');
require_once('../vendor/autoload.php');

use Models\User;
use Rakit\Validation\Validator;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (count($_POST) < 1) {
            $_POST = json_decode(file_get_contents('php://input'), true) ?? [];
        }

        $validator = new Validator;
        $validation = $validator->validate($_POST, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();

            return error_response('Error Validasi', $errors->firstOfAll(), 400);
        }

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
        $timestamps = epoch_time();

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'image' => 'default.jpg',
                'level' => 'petfinder',
                'created_at' => $timestamps,
                'updated_at' => $timestamps,
            ]);

            return success_response('Akun berhasil dibuat', compact('user'), 201);
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return error_response('E-mail sudah digunakan', null, 409);
                default:
                    return error_response($e->getMessage(), null, 500);
            }
        }
    default:
        return error_response('Method Not Allowed');
}
