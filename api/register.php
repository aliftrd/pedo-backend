<?php
header('Content-Type: application/json');
require_once '../config.php';
require_once '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    http_response_code(404);
    return;
}

use Rakit\Validation\Validator;

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
    $query = "INSERT INTO users VALUES (NULL, :name, :email, :password, :image, :level, :created_at, :updated_at, NULL)";
    $result = $db->prepare($query)->execute([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'image' => 'default.jpg',
        'level' => 'petfinder',
        'created_at' => $timestamps,
        'updated_at' => $timestamps,
    ]);

    $query = "SELECT * FROM users WHERE id = '{$db->lastInsertId()}' LIMIT 1";
    $user = $db->query($query)->fetch();
    unset($user['password']);

    return success_response('Akun berhasil dibuat', [
        'user' => $user,
    ], 201);
} catch (\PDOException $e) {
    if ($e->getCode() == 23000) {
        return error_response('E-mail sudah digunakan', null, 409);
    }

    return error_response($e->getMessage(), null, 500);
}
