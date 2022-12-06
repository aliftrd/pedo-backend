<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\AnimalType;
use Rakit\Validation\Validator;

try {
    $animalType = AnimalType::findOrFail($_GET['id']);
    if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
        $validator = new Validator;
        $validation = $validator->validate($_POST, [
            'title' => 'required',
        ]);

        $animalType->update([
            'title' => htmlspecialchars($_POST['title']),
        ]);

        Flash::setFlash('success', 'Berhasil mengubah tipe hewan');
        return header('Location:' . base_url('animals/types'));
    }
} catch (\Exception $e) {
    Flash::setFlash('error', 'Tipe hewan tidak ditemukan');
    return header('Location:' . base_url('animals/types'));
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
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?= $animalType->title ?>" required>
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