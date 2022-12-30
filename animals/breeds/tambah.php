<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\AnimalBreed;
use Models\AnimalType;
use Rakit\Validation\Validator;

$animaltypes = AnimalType::get();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validator = new Validator;
    $validation = $validator->validate($_POST, [
        'animaltypes' => 'required',
        'title' => 'required',
    ]);
    if ($validation->fails()) {
        $errors = $validation->errors();

        Flash::setFlash('error', $errors->firstOfAll()[array_key_first($errors->firstOfAll())]);
        return header('Location:' . base_url('animals/breeds/tambah.php'));
    }

    $title = htmlspecialchars($_POST['title']);
    

    $animalBreed = AnimalBreed::create([        
        'title' => $title,
    ]);
    $animalBreed->animaltype()->associate($_POST['animaltypes']);
    $animalBreed->save();


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
                                    <label for="animaltypes">Hewan</label>
                                    <select class="js-states form-control" name="animaltypes" id="animaltypes" tabindex="-1" style="display: none; width: 100%">
                                        <?php foreach ($animaltypes as $animaltype) : ?>
                                            <option value="<?= $animaltype->id ?>" ><?= $animaltype->title?></option>
                                            <?php endforeach ?>
                                    </select>
                                </div>
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