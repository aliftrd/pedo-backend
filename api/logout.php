<?php
header("Content-Type: application/json");
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    http_response_code(404);
    return;
}

$headers = apache_request_headers();

if ($headers['Authorization']) {
    $authorization = explode(" ", $headers['Authorization']);
    if ($authorization[0] !== 'Bearer') {
        return error_response('Authorization type invalid', null, 401);
    }

    $token = $authorization[1];
    $query = "DELETE FROM user_access_tokens WHERE token = :token";
    $requestDB = $db->prepare($query);
    $requestDB->bindValue(':token', $token, \PDO::PARAM_STR);
    $requestDB->execute();

    return success_response('Berhasil keluar', null, 200);
}
