<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use Helper\Flash;
use Models\User;
use Models\UserMeta;
use Models\UserUpgradeRequest;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userUpgradeRequest = UserUpgradeRequest::find($_POST['id']);
    $userUpgradeRequest->update([
        'promise' => 'Selamat, permintaan upgrade anda berhasil diterima',
        'status' => 'accepted'
    ]);

    UserMeta::create([
        'user_id' => $userUpgradeRequest->user_id,
        'village_id' => $userUpgradeRequest->village_id,
        'phone' => $userUpgradeRequest->phone,
        'type' => UserMeta::PETOWNER,
    ]);

    User::find($userUpgradeRequest->user_id)->update([
        'level' => User::PETOWNER,
    ]);

    Flash::setFlash('success', 'Berhasil menerima permintaan');

    return header('Location:' . base_url('users/upgrade'));
} else {
    return error_response('Method not allowed');
}