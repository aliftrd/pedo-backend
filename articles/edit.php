<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\Article;
use Models\ArticleCategory;
use Rakit\Validation\Validator;
use Helper\Storage;
    
    $categories = ArticleCategory::get();
    $article = Article::with(['categories'])->findOrFail($_GET['id']);
   
    if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
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
            return header('Location:' . base_url('articles/edit.php?id=' . $_GET['id']));
        }

        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $categories = $_POST['categories']; 

        if (has_uploaded_file($_FILES['thumbnail'])) {
            $foto = $_FILES['thumbnail']['tmp_name'];
            $nama_file = md5($_FILES['foto']['name']) . '-' . time() .'.jpg';
            if ($article->getRawOriginal('thumbnail') != 'default.jpg'){
                unlink('storage/images/articles/thumbnail/' . $article->getRawOriginal('thumbnail'));
            }
            move_uploaded_file($foto, 'storage/images/articles/thumbnail/' . $nama_file);
        }


        $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST["title"])));
        $slug .= '-' . uniqid(); 

        $article->update([
        'admin_id' => $auth->id,
        'title' =>  $title,
        'slug' => $slug,
        'description' => $description,
        'thumbnail' => $nama_file ?? $article->getRawOriginal('thumbnail'),
        ]);
        $article->categories()->sync($categories); 

        Flash::setFlash('success', 'Berhasil mengubah artikel');
        return header('Location:' . base_url('articles'));
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
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?= $article->title ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" id="description" class="form-control" required><?= $article->description ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail</label>
                                    <input class="form-control" type="file" name="thumbnail" id="thumbnail">
                                </div>
                                <div class="form-group">
                                    <label for="categories">kategori</label>
                                    <select name="categories[]" class="js-states form-control" tabindex="-1" style="display: none; width: 100%" multiple="multiple">
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category->id ?>" <?= $article->categories->contains($category->id) ? 'selected' : '' ?>><?= $category->title ?></option>
                                    <?php endforeach; ?> 
                                    </select>
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