<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\Article;

$article = Article::get();
?>

<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <div class="row">
                <div class="col-md">
                    <?php if (Flash::has('success')) : ?>
                        <div class="alert alert-success"><?= Flash::display('success') ?></div>
                    <?php endif; ?>
                    <?php if (Flash::has('error')) : ?>
                        <div class="alert alert-danger"><?= Flash::display('error') ?></div>
                    <?php endif; ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Artikel</h5>
                                <a href="<?= base_url('articles/tambah.php') ?>" class="btn btn-primary">Tambah</a>
                            </div>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Judul</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>                  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($article->count() > 0) : ?>
                                        <?php foreach ($article as $type) : ?>
                                            <tr>
                                                <td><?= $type->id ?></td>
                                                <td><?= $type->title ?></td>
                                                <td><?= $type->created_at ?></td>
                                                <td>
                                                    <a href="<?= base_url('articles/edit.php?id=' . $type->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="<?= base_url('articles/hapus.php') ?>" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus?')">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="id" value="<?= $type->id ?>">
                                                        <button class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/footer.inc.php') ?>