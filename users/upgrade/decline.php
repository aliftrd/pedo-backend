<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use Helper\Flash;
use Models\Notification;
use Models\User;
use Models\UserUpgradeRequest;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userUpgradeRequest = UserUpgradeRequest::find($_POST['id']);
    $userUpgradeRequest->update([
        'promise' => 'Maaf, permintaan upgrade anda ditolak silahkan perbaiki data anda dan coba lagi',
        'status' => UserUpgradeRequest::REJECTED,
    ]);

    $user = User::find($userUpgradeRequest->user_id);

    Notification::create([
        'user_id' => $user->id,
        'description' => 'Maaf, permintaan upgrade anda ditolak silahkan perbaiki data anda dan coba lagi',
    ]);

    Flash::setFlash('success', 'Berhasil menolak permintaan');

    return header('Location:' . base_url('users/upgrade'));
} else {
    return error_response('Method not allowed');
}
