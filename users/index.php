<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Models\User;

$users = User::when(isset($_GET['search']), function ($query) {
    $query->where('name', 'like', '%' . $_GET['search'] . '%');
})->get();

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
                                    <h5 class="card-title">Form Data User</h5>
                                </div>
                                <form action="<?= base_url('users/index.php') ?>">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="search"
                                            placeholder="Masukkan judul"
                                            value="<?= !isset($_GET['search']) ? "" : $_GET['search'] ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm" id="basic-addon2">Cari</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="col">
                                    <?php if ($auth->level == 'Developer') : ?>
                                    <a href="<?= base_url('users/tambah.php') ?>"
                                        class="btn btn-primary float-right ">Tambah</a>
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
                                        <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td> <?= $user->id ?></td>
                                            <td> <?= $user->name ?></td>
                                            <td> <?= $user->email ?></td>
                                            <td> <?= $user->level ?></td>
                                            <td> <?= $user->created_at ?></td>
                                            <td>
                                                <?php if ($auth->level == 'Developer') : ?>
                                                <a href="<?= base_url('users/edit.php?id=' . $user->id) ?>"
                                                    class="btn btn-warning">Ubah</a>
                                                <form action="<?= base_url('users/hapus.php') ?>" method="POST"
                                                    class='d-inline'
                                                    onsubmit="return confirm('Anda yakin ingin menghapus?')">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="id" value="<?= $user->id ?>">
                                                    <button class="btn btn-danger">Hapus</button>
                                                </form>
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