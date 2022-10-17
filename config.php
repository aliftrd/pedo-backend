<?php
require_once 'functions.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

$host = "127.0.0.1";
$port = 3306;
$username = "root";
$password = "";
$dbname = "pedo";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password, [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    error_response('An error occurred', null, $e->getCode());
    return exit();
}

if (!function_exists('get_bearer_token')) {
    function get_bearer_token()
    {
        $headers = apache_request_headers();
        if ($headers['Authorization']) {
            $authorization = explode(" ", $headers['Authorization']);
            if ($authorization[0] !== 'Bearer') {
                return [
                    'status' => false,
                    'message' => 'Authorization type invalid'
                ];
            }
            return [
                'status' => true,
                'message' => $authorization[1]
            ];
        }
        // Return need header authorization
        return [
            'status' => false,
            'message' => 'Authorization needed'
        ];
    }
}

if (!function_exists('check_is_valid_user')) {
    function check_is_valid_user(string $token)
    {
        global $db;
        $query = "SELECT * FROM users WHERE id = (SELECT user_id FROM user_access_tokens WHERE token = '{$token}' LIMIT 1)";
        return $db->query($query)->fetch();
    }
}
