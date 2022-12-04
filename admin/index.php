<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
if (!isset($_SESSION['auth'])) {
    header('Location:' . base_url('login.php'));
}

use Models\Admin;
use Helper\Flash;

$auth = Admin::find($_SESSION['auth']);
$admins = Admin::get();

//delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_DELETE = $_POST;
    if ($_DELETE['_method'] == "DELETE") {
        Admin::destroy($_DELETE['id']);
        header("Location: " . base_url('crudadmin.php'));
    }
}

?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <div class="row">
                <div class="col-xl">
                    <?php if (Flash::has('success')) : ?>
                    <div class="alert alert-success"><?= Flash::display('success') ?></div>
                    <?php endif; ?>
                    <?php if (Flash::has('error')) : ?>
                    <div class="alert alert-danger"><?= Flash::display('error') ?></div>
                    <?php endif; ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center mb-4">
                                <div class="col">
                                    <h5 class="card-title">Form Data Admin</h5>
                                </div>
                                <div class="col">
                                    <?php if ($auth->level == 'Developer') : ?>
                                    <a href="<?= base_url('admin/tambah.php') ?>"
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
                                        <?php foreach ($admins as $admin) : ?>
                                        <tr>
                                            <td> <?= $admin->id ?></td>
                                            <td> <?= $admin->name ?></td>
                                            <td> <?= $admin->email ?></td>
                                            <td> <?= $admin->level ?></td>
                                            <td> <?= $admin->created_at ?></td>
                                            <td>
                                                <?php if ($auth->level == 'Developer') : ?>
                                                <a href="<?= base_url('admin/edit.php?id=' . $admin->id) ?>"
                                                    class="btn btn-warning">Ubah</a>
                                                <form action="<?= base_url('admin/hapus.php') ?>" method="POST"
                                                    class='d-inline'
                                                    onsubmit="return confirm('Anda yakin ingin menghapus?')">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="id" value="<?= $admin->id ?>">
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