<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\Admin;
use Rakit\Validation\Validator;
use Helper\Storage;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $validator = new Validator;
        $validation = $validator->validate($_POST + $_FILES, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'image' => 'nullable|uploaded_file:0,1M,png,jpg,jpeg',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();

            Flash::setFlash('error', $errors->firstOfAll()[array_key_first($errors->firstOfAll())]);
            return header('Location:' . base_url('admin/tambah.php'));
        }

        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $level = htmlspecialchars($_POST['level']);
        $password = password_hash(($_POST['password']), PASSWORD_BCRYPT);
        if (has_uploaded_file($_FILES['image'])) {
            $file = Storage::upload($_FILES['image'], 'storage/images/admin/avatar');
        }

        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'image' => $file ?? 'default.jpg',
            'level' => $level,
        ]);

        Flash::setFlash('success', 'Berhasil menambahkan Data Admin');
        return header('Location:' . base_url('admin'));
    }
} catch (Exception $e) {
    if ($e->getCode() == 23000) {
        Flash::setFlash('error', 'Email sudah digunakan');
        return header('Location:' . base_url('admin/tambah.php'));
    }

    Flash::setFlash('error', 'Terjadi kesalahan');
    return header('Location:' . base_url('admin'));
}

?>
<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/template/message.inc.php') ?>
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tambah Admin</h5>
                            <p>Isi data dengan lengkap dan tepat</p>
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <select class="js-states form-control" name="level" id="level" tabindex="-1" style="display: none; width: 100%">
                                        <?php foreach (Admin::LEVELS as $key => $value) : ?>
                                            <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="image">Avatar</label>
                                    <input class="form-control" type="file" name="image" id="image">
                                </div>

                                <button type="register" class="btn btn-primary">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/footer.inc.php') ?>