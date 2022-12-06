<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use Helper\Flash;
use Helper\Storage;
use Models\Admin;

if (isset($_POST['_method']) && $_POST['_method'] == 'DELETE') {
    $admin = Admin::find($_POST['id']);
    if ($admin->getRawOriginal('image') != 'default.jpg') {
        Storage::delete('storage/images/admin/avatar', $admin->getRawOriginal('image'));
    }

    if ($admin->id == $_SESSION['auth']) {
        $admin->delete();
        return header('Location:' . base_url('logout.php'));
    }

    $admin->delete();


    Flash::setFlash('success', 'Berhasil menghapus Data Admin');

    return header('Location:' . base_url('admin'));
} else {
    return error_response('Method not allowed');
}
