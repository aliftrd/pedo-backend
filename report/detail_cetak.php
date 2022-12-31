<?php
use Models\Animal;
$animals = Animal::with(['user_meta.user', 'animal_images', 'animal_type', 'animal_breed'])->where('status', 'Adopted')->get();

?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title_pdf;?></title>
        <style>
            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #table td, #table th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #table tr:nth-child(even){background-color: #f2f2f2;}

            #table tr:hover {background-color: #ddd;}

            #table th {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: left;
                background-color: #fdff7a;
                color: black;
            }
        </style>
    </head>
    <div class="row">
    <body>
        <div style="text-align:center">
            <h3>Laporan Adopsi Hewan</h3>
            <h3>Jumlah Keseluruhan Data = <?= $animals_count = Animal::with(['user_meta.user', 'animal_images', 'animal_type', 'animal_breed'])->where('status', 'Adopted')->count();?></h3>
        </div>
        <table id="table">
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
</body>
</div>
</html>
