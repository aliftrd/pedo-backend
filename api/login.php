<?php
header("Content-Type: application/json");
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    http_response_code(404);
    return;
}

// ========= Token Checker Start ========= //
$headers = apache_request_headers();

if ($headers['Authorization']) {
    $authorization = explode(" ", $headers['Authorization']);
    if ($authorization[0] !== 'Bearer') {
        return response_json([
            'status' => false,
            'message' => 'Authorization type invalid',
            'data' => null,
        ], 401);
    }

    $token = $authorization[1];
    $query = "SELECT * FROM users WHERE id = (SELECT user_id FROM user_access_tokens WHERE token = '{$token}')";
    $user = $db->query($query)->fetch();

    if (is_null($user)) {
        return response_json([
            'status' => false,
            'message' => 'Kredensial tidak valid',
            'data' => null,
        ], 401);
    }

    return response_json([
        'status' => true,
        'message' => 'Berhasil mengambil user',
        'data' => [
            'token' => $token,
            'user' => $user,
        ]
    ], 200);
}
// ========= Token Checker End ========= //


if (count($_POST) < 1) {
    $_POST = json_decode(file_get_contents('php://input'), true);
}

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    return response_json([
        'status' => false,
        'message' => 'E-mail dan password tidak boleh kosong',
        'data' => null,
    ], 401);
}


$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email = '{$email}' LIMIT 1";
$user = $db->query($query)->fetch(\PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password']) || !is_null($user['deleted_at'])) {
    return response_json([
        'status' => false,
        'message' => 'Kredensial tidak valid',
        'data' => false
    ], 401);
}

$token = generate_token();
$user_agent = base64_encode($_SERVER['HTTP_USER_AGENT']);
$query = "INSERT INTO user_access_tokens VALUES (NULL, '{$user['id']}', '{$token}', '{$user_agent}')";
$db->prepare($query)->execute();


unset($user['password']);
return response_json([
    'status' => true,
    'message' => 'Berhasil login',
    'data' => [
        'token' => $token,
        'user' => $user
    ],
], 200);
