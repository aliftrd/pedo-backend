<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Models\AnimalType;

$animalType = AnimalType::get();
?>

<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/template/message.inc.php') ?>
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Animal types</h5>
                                <a href="<?= base_url('animals/types/tambah.php') ?>" class="btn btn-primary">Tambah</a>
                            </div>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipe Hewan</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($animalType->count() > 0) : ?>
                                        <?php foreach ($animalType as $type) : ?>
                                            <tr>
                                                <td><?= $type->id ?></td>
                                                <td><?= $type->title ?></td>
                                                <td><?= $type->created_at ?></td>
                                                <td>
                                                    <a href="<?= base_url('animals/types/edit.php?id=' . $type->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="<?= base_url('animals/types/hapus.php') ?>" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus?')">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="id" value="<?= $type->id ?>">
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