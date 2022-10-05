<?php

session_start();

$host = "127.0.0.1";
$port = 3306;
$username = "root";
$password = "";
$dbname = "nyanko";

$db = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password, [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
]);

if (!function_exists('response_json')) {
    function response_json(array $data, int $code = 200): void
    {
        echo json_encode($data);
        http_response_code($code);
    }
}

if (!function_exists('generate_token')) {
    function generate_token($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $epoch = epoch_time();
        $string = $randomString . $epoch;
        $md5String = password_hash($string, PASSWORD_BCRYPT);
        return base64_encode($md5String);
    }
}

if (!function_exists('epoch_time')) {
    function epoch_time()
    {
        return round(microtime(true) * 1000);
    }
}
