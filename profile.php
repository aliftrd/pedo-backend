<?php
session_start();
require_once('vendor/autoload.php');
if (!isset($_SESSION['auth'])) {
    header('Location:' . base_url('login.php'));
}

use Models\Admin;
use Helper\Flash;
use Rakit\Validation\Validator;

$admin = Admin::find($_SESSION['auth']);

if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
    $validator = new Validator;
    $validation = $validator->validate($_POST, [
        'name' => 'required',

    ]);

    $admin->update([
        'name' => $_POST['name'],
    ]);

    Flash::setFlash('success', 'Berhasil mengubah profile');
    header('Location:' . base_url('profile.php'));
}

?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <!-- profile -->
                            <img src="<?= $admin->image ?>" alt="<?= $admin->image; ?>" class="img-fluid">
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
                                    <input type="text" class="form-control" name="name" id="name" value="<?= $admin->name ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="judul" value=<?= $admin->email ?> readonly>
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