<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\Faq;
use Rakit\Validation\Validator;

if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
    $validator = new Validator;
    $validation = $validator->validate($_POST, [
        'judul' => 'required',
        'deskripsi' => 'required',
    ]);

    if ($validation->fails()) {
        $errors = $validation->errors();

        Flash::setFlash('error', $errors->firstOfAll()[array_key_first($errors->firstOfAll())]);
        return header('Location:' . base_url('faq/edit.php?id=' . $_GET['id']));
    }

    Faq::find($_GET['id'])->update([
        'title' => $_POST['judul'],
        'description' => $_POST['deskripsi'],
    ]);

    Flash::setFlash('success', 'Berhasil mengubah FAQ');
    return header('Location:' . base_url('faq/index.php'));
}

$faq = Faq::find($_GET['id']);
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
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="judul">Judul</label>
                                    <input type="text" class="form-control" id="judul" name="judul" value="<?= $faq->title ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control"><?= $faq->description ?></textarea>
                                </div>
                                <button class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/footer.inc.php') ?>