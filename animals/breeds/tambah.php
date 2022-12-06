<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\AnimalBreed;
use Rakit\Validation\Validator;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validator = new Validator;
    $validation = $validator->validate($_POST, [
        'title' => 'required',
    ]);

    AnimalBreed::create([
        'title' => htmlspecialchars($_POST['title']),
    ]);

    Flash::setFlash('success', 'Berhasil menambahkan ras hewan');
    return header('Location:' . base_url('animals/breeds'));
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
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
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