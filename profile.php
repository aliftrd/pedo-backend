<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Rakit\Validation\Validator;

if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
    $validator = new Validator;
    $validation = $validator->validate($_POST, [
        'name' => 'required',

    ]);

    $auth->update([
        'name' => $_POST['name'],
    ]);

    Flash::setFlash('success', 'Berhasil mengubah profile');
}

?>

<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/template/message.inc.php') ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <!-- profile -->
                            <img src="<?= $auth->image ?>" alt="<?= $auth->image; ?>" style="width: 100%;object-fit: cover;">
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <!-- Input -->
                            <form method="post">
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="<?= $auth->name ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="judul" value=<?= $auth->email ?> readonly>
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