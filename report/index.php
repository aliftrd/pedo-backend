<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.inc.php') ?>
<?php 
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
                                <h5 class="card-title">Report</h5>
                                <a target="_blank" href="<?= base_url('report/cetak.php') ?>" class="btn btn-primary"> <i class="fa fa-file-pdf-o"></i> Cetak</a>
                            </div>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pet Owner</th>    
                                        <th>Tipe Hewan</th>                                    
                                        <th>Ras Hewan</th>                                        
                                        <th>Nama Hewan</th>                                    
                                        <th>Harga</th>                                            
                                        <th>Tanggal Adopsi</th>              
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($animals->count() > 0) : ?>
                                        <?php foreach ($animals as $animal) : ?>
                                            <tr>
                                                <td><?= $animal->id ?></td>
                                                <td><?= $animal->user_meta->user->name ?></td>
                                                <td><?= $animal->animal_type->title?></td>
                                                <td><?= $animal->animal_breed->title?></td>
                                                <td><?= $animal->title ?></td>
                                                <td><?= $animal->price == 0 ? 'Gratis' : $animal->price ?></td>
                                                <td><?= $animal->updated_at ?></td>                                
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