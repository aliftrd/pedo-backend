<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
if (!isset($_SESSION['auth'])) {
    header('Location:' . base_url('login.php'));
}

use Helper\Flash;
use Models\AnimalType;
use Rakit\Validation\Validator;

if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
    $validator = new Validator;
    $validation = $validator->validate($_POST, [
        'title' => 'required',
    ]);

    AnimalType::find($_GET['id'])->update([
        'title' => $_POST['title'],
    ]);

    Flash::setFlash('success', 'Berhasil mengubah tipe hewan');
    header('Location:' . base_url('animal-types/index.php'));
}

$AnimalType = AnimalType::find($_GET['id']);
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
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?= $AnimalType->title ?>" required>
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