<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
if (!isset($_SESSION['auth'])) {
    header('Location:' . base_url('login.php'));
}

use Helper\Flash;
use Models\Admin;
use Rakit\Validation\Validator;
use Helper\Storage;

$admin = Admin::find($_GET['id']);

$auth = Admin::find($_SESSION['auth']);
if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
    $validator = new Validator;
    $validation = $validator->validate($_POST + $_FILES, [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'level' => 'required',
        'image' => 'required',
    ]);

    Admin::find($_GET['id'])->update([
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => password_hash(($_POST['password']), PASSWORD_BCRYPT),
        'level' => $_POST['level'],
    ]);

    Flash::setFlash('success', 'Berhasil mengubah Admin');
    header('Location:' . base_url('admin/index.php'));
}


?>



<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Form Admin</h5>
                            <p>Isi data dengan lengkap dan tepat</p>
                            <form method="post">
                                <input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?= $admin->name ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?= $admin->email ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <select class="js-states form-control" name="level" id="level" tabindex="-1" style="display: none; width: 100%" value="<?= $admin->level ?>" required>
                                        <optgroup>
                                            <option value="Admin">Admin</option>
                                            <option value="Developer">Developer</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="file" name="image" id="image" required>
                                </div>

                                <button type="register" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/footer.inc.php') ?>