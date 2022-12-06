<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Helper\Storage;
use Models\Admin;
use Rakit\Validation\Validator;

try {
    $admin = Admin::findOrFail($_GET['id']);

    if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
        $validator = new Validator;
        $validation = $validator->validate($_POST + $_FILES, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
            'level' => 'required',
            'image' => 'nullable|uploaded_file:0,1M,png,jpg,jpeg',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();

            Flash::setFlash('error', $errors->firstOfAll()[array_key_first($errors->firstOfAll())]);
            return header('Location:' . base_url('admin/edit.php?id=' . $_GET['id']));
        }

        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $level = htmlspecialchars($_POST['level']);
        $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $admin->password;

        if (has_uploaded_file($_FILES['image'])) {
            if ($admin->getRawOriginal('image') != 'default.jpg') {
                Storage::delete('storage/images/admin/avatar', $admin->getRawOriginal('image'));
            }

            $file = Storage::upload($_FILES['image'], 'storage/images/admin/avatar');
        }

        $admin->update([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'level' => $level,
            'image' => $file ?? $admin->getRawOriginal('image'),
        ]);

        Flash::setFlash('success', 'Berhasil mengubah Admin');
        return header('Location:' . base_url('admin'));
    }
} catch (\Exception $e) {
    if ($e->getCode() == 23000) {
        Flash::setFlash('error', 'Email sudah digunakan');
        return header('Location:' . base_url('admin/edit.php?id=' . $_GET['id']));
    }

    Flash::setFlash('error', 'Admin tidak ditemukan');
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
                            <h5 class="card-title">Edit Admin</h5>
                            <p>Isi data dengan lengkap dan tepat</p>
                            <form method="post" enctype="multipart/form-data">
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
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <select class="js-states form-control" name="level" id="level" tabindex="-1" style="display: none; width: 100%">
                                        <?php foreach (Admin::LEVELS as $key => $value) : ?>
                                            <option value="<?= $key ?>" <?= $admin->level != $key ?: 'selected' ?>><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="image">Avatar</label>
                                    <input class="form-control" type="file" name="image" id="image">
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