<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use Helper\Flash;
use Models\Faq;

if (isset($_POST['_method']) && $_POST['_method'] == 'DELETE') {
    Faq::destroy($_POST['id']);
    Flash::setFlash('success', 'Berhasil menghapus FAQ');

    header('Location:' . base_url('faq/index.php'));
} else {
    return error_response('Method not allowed');
}
