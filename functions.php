<?php

if (!function_exists('response_json')) {
    function response_json(mixed $data, int $code = 200): void
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

if (!function_exists('epoch_to_second')) {
    function epoch_to_second($value)
    {
        return round($value / 1000);
    }
}

if (!function_exists('success_response')) {
    function success_response(string $message, mixed $data = null, int $code = 200)
    {
        return response_json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}

if (!function_exists('has_uploaded_file')) {
    function has_uploaded_file($input)
    {
        return file_exists($input['tmp_name']) || is_uploaded_file($input['tmp_name']);
    }
}

if (!function_exists('error_response')) {
    function error_response(string $message, mixed $errors = null, int $code = 404)
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
