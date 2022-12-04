<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\Faq;
use Rakit\Validation\Validator;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validator = new Validator;
    $validation = $validator->validate($_POST, [
        'judul' => 'required',
        'deskripsi' => 'required',
    ]);

    if ($validation->fails()) {
        $errors = $validation->errors();

        Flash::setFlash('error', $errors->firstOfAll()[array_key_first($errors->firstOfAll())]);
        return header('Location:' . base_url('faq/tambah.php'));
    }

    Faq::create([
        'title' => $_POST['judul'],
        'description' => $_POST['deskripsi'],
    ]);

    Flash::setFlash('success', 'Berhasil menambahkan FAQ');
    return header('Location:' . base_url('faq/index.php'));
}
?>

<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/template/message.inc.php') ?>
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
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
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