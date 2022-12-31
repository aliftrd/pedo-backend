<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use Helper\Flash;
use Models\Animal;
use Models\UserMeta;
use Models\Notification;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $animalrequest = Animal::find($_POST['id']);

    $animalrequest->update([
        'status' => Animal::REJECTED,
    ]);

    $user = UserMeta::find($animalrequest->user_meta_id);

    Notification::create([
        'user_id' => $user->user_id,
        'description' => 'Maaf, permintaan hewan yang anda kirimkan ditolak silahkan perbaiki data anda dan coba lagi',
    ]);

    Flash::setFlash('success', 'Berhasil menolak permintaan');

    return header('Location:' . base_url('animals/request/'));
} else {
    return error_response('Method not allowed');
}