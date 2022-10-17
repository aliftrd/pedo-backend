<?php

if (!function_exists('response_json')) {
    function response_json(array $data, int $code = 200): void
    {
        header("Content-Type: application/json");
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

if (!function_exists('success_response')) {
    function success_response(string $message, array $data = null, int $code = 200)
    {
        return response_json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}

if (!function_exists('error_response')) {
    function error_response(string $message, array $errors = null, int $code = 404)
    {
        return response_json([
            'code' => $code,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}

if (!function_exists('base_url')) {
    function base_url(string $uri)
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/{$uri}";
    }
}
