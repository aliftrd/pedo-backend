<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use Helper\Flash;
use Models\Admin;

if (isset($_POST['_method']) && $_POST['_method'] == 'DELETE') {
    Admin::destroy($_POST['id']);
    Flash::setFlash('success', 'Berhasil menghapus Data Admin');

    header('Location:' . base_url('admin/index.php'));
} else {
    return error_response('Method not allowed');
}
