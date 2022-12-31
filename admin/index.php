<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Models\Admin;

$total = Admin::count(); // Total of records
$current_page = $_GET['page'] ?? 1; // Page indicator
$per_page = 10; // Limit per page
$offset = ($current_page - 1) * $per_page; // Skip records
$last_page = ceil($total / $per_page); // Total page

// Previous page link
if ($current_page < 2) {
    $prev_page_url = null;
} else {
    $prev_page_url = 'admin/index.php?page=' .  ($current_page - 1);
    if (isset($_GET['search'])) {
        $prev_page_url .= '&search=' . urlencode($_GET['search']);
    }
    $prev_page_url = base_url($prev_page_url);
}

if ($current_page == $last_page) {
    $next_page_url = null;
} else {
    $next_page_url = 'admin/index.php?page=' . ($current_page + 1);
    if (isset($_GET['search'])) {
        $next_page_url .= '&search=' . urlencode($_GET['search']);
    }
    $next_page_url = base_url($next_page_url);
}


$admin = Admin::when(isset($_GET['search']), function ($query) {
    $query->where('name', 'like', '%' . $_GET['search'] . '%');
})
    ->offset($offset)
    ->limit($per_page)
    ->orderBy('id', 'DESC');

$data = [
    'current_page' => $current_page,
    'data' => $admin->get(),
    'form' => $offset + 1,
    'next_page_url' => $next_page_url,
    'per_page' => $per_page,
    'prev_page_url' => $prev_page_url,
    'to' => $offset + $per_page,
];

?>


<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/template/message.inc.php') ?>
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Data Admin</h5>
                                <form action="<?= base_url('admin/index.php') ?>">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="search" placeholder="Masukkan Nama Admin" value="<?= !isset($_GET['search']) ? "" : $_GET['search'] ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm" id="basic-addon2">Cari</button>
                                        </div>
                                    </div>
                                </form>
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
                                    <?php if (count($data['data']) > 1) : ?>

                                        <?php foreach ($data['data'] as $admin) : ?>
                                            <tr>
                                                <td> <?= $admin->id ?></td>
                                                <td> <?= $admin->name ?></td>
                                                <td> <?= $admin->email ?></td>
                                                <td> <?= $admin->level ?></td>
                                                <td> <?= $admin->created_at ?></td>
                                                <td>
                                                    <?php if ($auth->level == 'Developer') : ?>
                                                        <a href="<?= base_url('admin/edit.php?id=' . $admin->id) ?>" class="btn btn-warning">Ubah</a>
                                                        <?php if ($admin->count() > 1) : ?>
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
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <?php if (!is_null($data['prev_page_url'])) : ?>
                                    <li class="page-item"><a class="page-link" href="<?= $data['prev_page_url'] ?>">Previous</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (count($data['data']) > 1 && !is_null($data['next_page_url'])) : ?>
                                    <li class="page-item"><a class="page-link" href="<?= $data['next_page_url'] ?>">Next</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/footer.inc.php') ?>