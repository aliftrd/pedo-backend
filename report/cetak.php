<?php 
include('../config/database.php'); 
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;
use Models\Animal;

$animals = Animal::with(['user_meta.user', 'animal_images', 'animal_type', 'animal_breed'])->where('status', 'Adopted')->get();

// Instantiate and use the dompdf class
$dompdf = new Dompdf();

ob_start();
require('detail_cetak.php');
$html = ob_get_clean();

// Load HTML content
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('print-details.pdf', ['Attachment' => false]);

$output = $dompdf->output();

?>
