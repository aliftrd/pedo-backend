<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Models\UserUpgradeRequest;

$upgradeRequests = UserUpgradeRequest::with(['user'])->get();

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
                                <h5 class="card-title">Pemintaan Mitra</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($upgradeRequests->count() > 0) : ?>

                                            <?php foreach ($upgradeRequests as $upgradeRequest) : ?>
                                                <tr>
                                                    <td> <?= $upgradeRequest->id ?></td>
                                                    <td> <?= $upgradeRequest->user->name ?></td>
                                                    <td> <span class="badge badge-<?= $upgradeRequest->status == 'pending' ? 'warning' : ($upgradeRequest->status == 'accepted' ? 'success' : 'danger') ?>"> <?= $upgradeRequest->getRawOriginal('status') ?></span></td>
                                                    <td> <?= $upgradeRequest->created_at ?></td>
                                                    <td>
                                                        <a href="<?= base_url('users/upgrade/detail.php?id=' . $upgradeRequest->id) ?>" class="btn btn-primary">Detail</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data</td>
                                            </tr>
                                        <?php endif; ?>
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