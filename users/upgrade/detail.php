<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Models\UserUpgradeRequest;

$upgradeRequest = UserUpgradeRequest::with(['user', 'request_images'])->findOrFail($_GET['id']);

?>
<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/template/message.inc.php') ?>
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Detail Permintaan Upgrade</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>ID Request</th>
                                        <td>#<?= $upgradeRequest->id ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama / E-mail</th>
                                        <td><?= $upgradeRequest->user->name ?> / <?= $upgradeRequest->user->email ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><span class="badge badge-<?= $upgradeRequest->status == 'pending' ? 'warning' : ($upgradeRequest->status == 'accepted' ? 'success' : 'danger') ?>"> <?= $upgradeRequest->getRawOriginal('status') ?></span></td>
                                    </tr>
                                    <tr>
                                        <th>Images</th>
                                        <td>
                                            <?php foreach ($upgradeRequest->request_images as $image) : ?>
                                                <img src="<?= base_url('storage/images/user/upgrade/' . $image->path) ?>" alt="Image" class="img-thumbnail" style="width: 200px; height: 200px;object-fit: cover;margin: .8em;">
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php if ($upgradeRequest->status == 'pending') : ?>
                                <div class="text-center">
                                    <form action="<?= base_url('users/upgrade/accept.php') ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $upgradeRequest->id ?>">
                                        <button type="submit" class="btn btn-success">Terima</button>
                                    </form>
                                    <form action="<?= base_url('users/upgrade/decline.php') ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $upgradeRequest->id ?>">
                                        <button type="submit" class="btn btn-danger">Tolak</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/footer.inc.php') ?>