<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use Helper\Flash;
use Models\AnimalType;

if (isset($_POST['_method']) && $_POST['_method'] == 'DELETE') {
    AnimalType::destroy($_POST['id']);
    Flash::setFlash('success', 'Berhasil menghapus tipe hewan');

    header('Location:' . base_url('animals/types/index.php'));
} else {
    return error_response('Method not allowed');
}
