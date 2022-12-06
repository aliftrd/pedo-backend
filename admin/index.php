<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Models\Admin;

$admins = Admin::get();

?>
<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/template/message.inc.php') ?>
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center mb-4">
                                <div class="col">
                                    <h5 class="card-title">Form Data Admin</h5>
                                </div>
                                <div class="col">
                                    <?php if ($auth->level == 'Developer') : ?>
                                        <a href="<?= base_url('admin/tambah.php') ?>" class="btn btn-primary float-right ">Tambah</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Level</th>
                                        <th>Tanggal Bergabung</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($admins as $admin) : ?>
                                            <tr>
                                                <td> <?= $admin->id ?></td>
                                                <td> <?= $admin->name ?></td>
                                                <td> <?= $admin->email ?></td>
                                                <td> <?= $admin->level ?></td>
                                                <td> <?= $admin->created_at ?></td>
                                                <td>
                                                    <?php if ($auth->level == 'Developer') : ?>
                                                        <a href="<?= base_url('admin/edit.php?id=' . $admin->id) ?>" class="btn btn-warning">Ubah</a>
                                                        <?php if ($admins->count() > 1) : ?>
                                                            <form action="<?= base_url('admin/hapus.php') ?>" method="POST" class='d-inline' onsubmit="return confirm('Anda yakin ingin menghapus?')">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="id" value="<?= $admin->id ?>">
                                                                <button class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/footer.inc.php') ?>