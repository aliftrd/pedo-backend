<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\Faq;

$faqs = Faq::get();
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
                                <h5 class="card-title">FAQ</h5>
                                <a href="<?= base_url('faq/tambah.php') ?>" class="btn btn-primary">Tambah</a>
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
                                    <?php if ($faqs->count() > 0) : ?>
                                        <?php foreach ($faqs as $faq) : ?>
                                            <tr>
                                                <td><?= $faq->id ?></td>
                                                <td><?= $faq->title ?></td>
                                                <td><?= $faq->created_at ?></td>
                                                <td>
                                                    <a href="<?= base_url('faq/edit.php?id=' . $faq->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="<?= base_url('faq/hapus.php') ?>" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus?')">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="id" value="<?= $faq->id ?>">
                                                        <button class="btn btn-danger"> Hapus</button>
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