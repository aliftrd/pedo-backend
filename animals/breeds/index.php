<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Helper\Flash;
use Models\Animal;

$animals = Animal::with(['user_meta.user', 'animal_images', 'animal_type', 'animal_breed'])->where('status', 'Adopted')->get();
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
                                <h5 class="card-title">Ras Hewan</h5>
                                <a href="<?= base_url('animals/breeds/tambah.php') ?>" class="btn btn-primary">Tambah</a>
                            </div>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ras Hewan</th>
                                        <th>Tipe Hewan</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($animals->count() > 0) : ?>
                                        <?php foreach ($animals as $animal) : ?>
                                                                                                            
                                            <tr>
                                                <td><?= $animal->id ?></td>
                                                <td><?= $animal->animal_breed->title ?></td>
                                                <td><?= $animal->animal_type->title?></td>
                                                <td><?= $animal->created_at ?></td>
                                                <td>
                                                    <a href="<?= base_url('animals/breeds/edit.php?id=' . $animal->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="<?= base_url('animals/breeds/hapus.php') ?>" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus?')">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="id" value="<?= $animal->id ?>">
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