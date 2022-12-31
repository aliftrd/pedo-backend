<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Rakit\Validation\Validator;
use Models\Admin;
use Helper\Storage;

    if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
        $validator = new Validator;
        $validation = $validator->validate($_POST + $_FILES, [
            'name' => 'required',
            'image' => 'nullable|uploaded_file:0,1M,png,jpg,jpeg',
        ]);

        if ($validation->fails()) { 
            $errors = $validation->errors();
    
            Flash::setFlash('error', $errors->firstOfAll()[array_key_first($errors->firstOfAll())]);
            return header('Location:' . base_url('profile.php'));
        }

        $name = htmlspecialchars($_POST['name']);       

        if (has_uploaded_file($_FILES['image'])) {
            $foto = $_FILES['image']['tmp_name'];
            $nama_file = md5($_FILES['image']['name']) . '-' . time() .'.jpg';
            if ($auth->getRawOriginal('image') != 'default.jpg'){
                unlink('storage/images/admin/avatar/' . $auth->getRawOriginal('image'));
            }
            move_uploaded_file($foto, 'storage/images/admin/avatar/' . $nama_file);
        }


        $auth->update([
            'name' => $name,
            'image' => $nama_file ?? $auth->getRawOriginal('image'),
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
                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="image">Avatar</label>
                                    <input class="form-control" type="file" name="image" id="image" value="<?= $auth->image ?>" >
                                </div>
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