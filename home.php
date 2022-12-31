<?php include('template/header.inc.php') ?>
<?php

use Models\Admin;
use Models\UserUpgradeRequest;
use Models\User;
use Models\Animal;

$admin = Admin::find($_SESSION['auth']);
$users = User::limit(7)->latest()->get();
$animalRequests = Animal::with(['user_meta'])->where('status', 'pending')->latest()->limit(5)->get();


?>

<div class="lime-container">
    <div class="lime-body">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="dashboard-info row">
                                <div class="info-text col-md-6">
                                    <h5 class="card-title">Halo, Selamat datang kembali
                                        <?php echo $admin->name; ?></h5>
                                    <p>Berikut adalah tampilan Dashboard Pet Adoption</p>
                                    <ul>
                                        <li>Anda sekarang memiliki akses pada website</li>
                                        <li>Tekan tombol berikut untuk pemahaman lebih lanjut</li>
                                    </ul>
                                    <a href="https://shorturl.at/vINRS" class="btn btn-warning m-t-xs">Pelajari lebih
                                        lanjut</a>
                                </div>
                                <div class="info-image col-md-6"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-paw"></i> Daftar 7 User yang terakhir mendaftar
                            </h5>
                            <ul>
                                <?php foreach ($users as $user) : ?>
                                <li><?= $user->name ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card stat-card" onclick="location.href='<?= base_url('users') ?>'">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-user"></i> Total User (Pet Finder)</h5>
                            <h2 class="float-right"><?= $userCount = User::count(); ?></h2>
                            <p>Total user terdaftar</p>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"
                                    aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card" onclick="location.href='<?= base_url('users/upgrade') ?>'">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-handshake"></i> Permintaan Upgrade ke Mitra</h5>
                            <h2 class="float-right">
                                <?= $mitraCount = UserUpgradeRequest::where('status', 'pending')->count(); ?></h2>
                            <p>Permintaan menunggu</p>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 100%"
                                    aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card" onclick="location.href='<?= base_url('users') ?>'">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-handshake"></i> Total Mitra (Pet Owner)</h5>
                            <h2 class="float-right"><?= $mitra = User::where('level', 'petowner')->count(); ?></h2>
                            <p>Total mitra yang telah disetujui</p>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 100%"
                                    aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center mb-4">
                                <div class="col">
                                    <h5 class="card-title">Permintaan Hewan</h5>
                                </div>
                            </div>
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
                                        <?php foreach ($animalRequests as $animalRequests) : ?>
                                        <tr>
                                            <td> <?= $animalRequests->id ?></td>
                                            <td> <?= $animalRequests->title ?></td>
                                            <td> <?= $animalRequests->user_meta->user->name ?></td>
                                            <td><span
                                                    class="badge badge-<?= strtolower($animalRequests->status) == 'pending' ? 'warning' : (strtolower($animalRequests->status) == 'accepted' ? 'success' : 'danger') ?>">
                                                    <?= $animalRequests->getRawOriginal('status') ?></span></td>
                                            <td> <?= $animalRequests->created_at ?></td>
                                            <td>
                                                <a href="<?= base_url('animals/detail.php?id=' . $animalRequests->id) ?>"
                                                    class="btn btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col text-center">
                                    <?php if ($auth->level == 'Developer') : ?>
                                    <a href="<?= base_url('animals') ?>" class="btn btn-primary mx-auto">Tampilkan
                                        Semua</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('template/footer.inc.php') ?>