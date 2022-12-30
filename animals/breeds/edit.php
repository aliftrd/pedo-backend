<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\AnimalBreed;
use Rakit\Validation\Validator;
use Models\AnimalType;

try {
    $animalBreed = AnimalBreed::findOrFail($_GET['id']);
    $animaltypes = AnimalType::get();
    if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
        $validator = new Validator;
        $validation = $validator->validate($_POST, [
            'animaltypes' => 'required',
            'title' => 'required',
        ]);

        $title = htmlspecialchars($_POST['title']);

        $animalBreed->update([
            'animaltypes' => $animaltypes,
            'title' => $title,
        ]);

        Flash::setFlash('success', 'Berhasil mengubah ras hewan');
        return header('Location:' . base_url('animals/breeds'));
    }
} catch (\Exception $th) {
    Flash::setFlash('error', 'Ras hewan tidak ditemukan');
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
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="animaltypes">Hewan</label>
                                    <select class="js-states form-control" name="animaltypes" id="animaltypes" tabindex="-1" style="display: none; width: 100%">
                                        <?php foreach ($animaltypes as $animaltype) : ?>
                                            <option value="<?= $animaltype->id ?>" ><?= $animaltype->title?></option>
                                            <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?= $animalBreed->title ?>" required>
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