<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use Helper\Flash;
use Helper\Storage;
use Models\User;

if (isset($_POST['_method']) && $_POST['_method'] == 'DELETE') {
    $user = User::find($_POST['id']);
    if ($user->getRawOriginal('image') != 'default.jpg') {
        unlink('../storage/images/user/avatar/' . $user->getRawOriginal('image'));
    }
    $user->delete();

    Flash::setFlash('success', 'Berhasil menghapus Data User');

    return header('Location:' . base_url('users'));
} else {
    return error_response('Method not allowed');
}