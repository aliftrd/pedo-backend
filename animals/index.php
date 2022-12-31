<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Models\Animal;

$total = Animal::count(); // Total of records
$current_page = $_GET['page'] ?? 1; // Page indicator
$per_page = 10; // Limit per page
$offset = ($current_page - 1) * $per_page; // Skip records
$last_page = ceil($total / $per_page); // Total page

$prev_page_url = $current_page < 2 ? null : base_url('animals/index.php?page=' .  ($current_page - 1)); // Previous page link
$next_page_url = $current_page == $last_page ? null : base_url('animals/index.php?page=' . ($current_page + 1)); // Next page link

$animal_data = Animal::with(['user_meta.user'])
    ->where('status', '!=', 'pending')
    ->offset($offset)
    ->limit($per_page)
    ->orderBy('id', 'DESC');

$data = [
    'current_page' => $current_page,
    'data' => $animal_data->get(),
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
                            <h5 class="card-title">Data Hewan</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Hewan</th>
                                        <th>Nama Pemilik</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['data'] as $animalRequests) : ?>
                                            <tr>
                                                <td> <?= $animalRequests->id ?></td>
                                                <td> <?= $animalRequests->title ?></td>
                                                <td> <?= $animalRequests->user_meta->user->name ?></td>
                                                <td><span class="badge badge-<?= strtolower($animalRequests->status) == 'adopted' ? 'primary' : (strtolower($animalRequests->status) == 'accepted' ? 'success' : 'danger') ?>">
                                                        <?= $animalRequests->getRawOriginal('status') ?></span></td>
                                                <td> <?= $animalRequests->created_at ?></td>
                                                <td>
                                                    <a href="<?= base_url('animals/detail.php?id=' . $animalRequests->id) ?>" class="btn btn-primary">Detail</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <?php if (!is_null($data['prev_page_url'])) : ?>
                                        <li class="page-item"><a class="page-link" href="<?= $data['prev_page_url'] ?>">Previous</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (count($data['data']) > 1 || !is_null($data['next_page_url'])) : ?>
                                        <li class="page-item"><a class="page-link" href="<?= $data['next_page_url'] ?>">Next</a></li>
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