<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\ArticleCategory;
use Rakit\Validation\Validator;


$article_categories = ArticleCategory::find($_GET['id']);

if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
    $validator = new Validator;
    $validation = $validator->validate($_POST, [
        'judul' => 'required',
    ]);

    if ($validation->fails()) {
        $errors = $validation->errors();

        Flash::setFlash('error', $errors->firstOfAll()[array_key_first($errors->firstOfAll())]);
        return header('Location:' . base_url('articles/categories/edit.php?id=' . $_GET['id']));
    }

    $title = htmlspecialchars($_POST['judul']);

    $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST["judul"])));
    $slug .= '-' . uniqid();

    ArticleCategory::find($_GET['id'])->update([
        'title' => $title,
        'slug' => $slug,
    ]);

    Flash::setFlash('success', 'Berhasil mengubah Kategori Artikel');
    return header('Location:' . base_url('articles/categories/index.php'));
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
                                    <label for="judul">Judul</label>
                                    <input type="text" class="form-control" id="judul" name="judul" value="<?= $article_categories->title ?>" required>
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