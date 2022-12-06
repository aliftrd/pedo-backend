<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use Helper\Flash;
use Models\AnimalBreed;

if (isset($_POST['_method']) && $_POST['_method'] == 'DELETE') {
    AnimalBreed::destroy($_POST['id']);
    Flash::setFlash('success', 'Berhasil menghapus ras hewan');

    return header('Location:' . base_url('animals/breeds'));
} else {
    return error_response('Method not allowed');
}
