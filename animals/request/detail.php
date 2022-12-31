<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php

use Models\Animal;

$animalRequests = Animal::with(['user_meta.user'])->findOrFail($_GET['id']);

?>
<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/template/message.inc.php') ?>
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Detail Permintaan Hewan</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>ID Request</th>
                                        <td>#<?= $animalRequests->id ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Hewan</th>
                                        <td><?= $animalRequests->title ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tipe Hewan</th>
                                        <td><?= $animalRequests->animal_type->title ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ras Hewan</th>
                                        <td><?= $animalRequests->animal_breed->title ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama Petowner</th>
                                        <td><?= $animalRequests->user_meta->user->name ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><span
                                                class="badge badge-<?= strtolower($animalRequests->status) == 'pending' ? 'warning' : (strtolower($animalRequests->status) == 'accepted' ? 'success' : 'danger') ?>">
                                                <?= $animalRequests->getRawOriginal('status') ?></span></td>
                                    </tr>
                                </table>
                            </div>
                            <?php if (strtolower($animalRequests->status) == 'pending') : ?>
                            <div class="text-center">
                                <form action="<?= base_url('animals/request/accept.php') ?>" method="POST"
                                    class="d-inline">
                                    <input type="hidden" name="id" value="<?= $animalRequests->id ?>">
                                    <button type="submit" class="btn btn-success">Terima</button>
                                </form>
                                <form action="<?= base_url('animals/request/decline.php') ?>" method="POST"
                                    class="d-inline">
                                    <input type="hidden" name="id" value="<?= $animalRequests->id ?>">
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