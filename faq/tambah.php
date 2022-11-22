<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
if (!isset($_SESSION['auth'])) {
    header('Location:' . base_url('login.php'));
}

use Helper\Flash;
use Models\Faq;
use Rakit\Validation\Validator;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validator = new Validator;
    $validation = $validator->validate($_POST, [
        'judul' => 'required',
        'deskripsi' => 'required',
    ]);

    Faq::create([
        'title' => $_POST['judul'],
        'description' => $_POST['deskripsi'],
    ]);

    Flash::setFlash('success', 'Berhasil menambahkan FAQ');
    header('Location:' . base_url('faq/index.php'));
}
?>


<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="judul">Judul</label>
                                    <input type="text" class="form-control" id="judul" name="judul" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                                </div>
                                <button class="btn btn-primary">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/footer.inc.php') ?>