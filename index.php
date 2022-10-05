<?php
header("Content-type: application/json");

require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = "SELECT * FROM users";

    $users = $db->query($query)->fetchAll(\PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "message" => "User berhasil di ambil",
        "data" => $users,
    ]);
    return;
}
