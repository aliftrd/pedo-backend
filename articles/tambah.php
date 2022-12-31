<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\Article;
use Models\ArticleCategory;
use Rakit\Validation\Validator;
use Helper\Storage;

$categories = ArticleCategory::get();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validator = new Validator;
    $validation = $validator->validate($_POST + $_FILES, [
        'title' => 'required',
        'description' => 'required',
        'thumbnail' => 'nullable|uploaded_file:0,1M,png,jpg,jpeg',
        'categories' => 'required',
    ]);

    if ($validation->fails()) {
        $errors = $validation->errors();

        Flash::setFlash('error', $errors->firstOfAll()[array_key_first($errors->firstOfAll())]);
        return header('Location:' . base_url('articles/tambah.php'));
    }

    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $categories = $_POST['categories']; 
    if (has_uploaded_file($_FILES['thumbnail'])) {
        $file = Storage::upload($_FILES['thumbnail'], '../storage/images/articles/thumbnail');
    }

    $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST["title"])));
    $slug .= '-' . uniqid(); 

    $article = Article::create([
        'admin_id' => $auth->id,
        'title' =>  $title,
        'slug' => $slug,
        'description' => $description,
        'thumbnail' => $file ?? 'default.jpg',
    ]);
    $article->categories()->sync($categories);    

    Flash::setFlash('success', 'Berhasil menambahkan artikel');
    return header('Location:' . base_url('articles/index.php'));
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
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="title">Judul</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" id="description" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail</label>
                                    <input class="form-control" type="file" name="thumbnail" id="thumbnail">
                                </div>
                                <div class="form-group">
                                    <label for="categories">kategori</label>
                                    <select name="categories[]" class="js-states form-control" tabindex="-1" style="display: none; width: 100%" multiple="multiple">
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category->id ?>" ><?= $category->title?></option>
                                            <?php endforeach ?>
                                    </select>
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