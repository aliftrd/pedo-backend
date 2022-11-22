<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Dashboard</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/font-awesome/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/toastr/toastr.min.css') ?>" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="<?= base_url('assets/css/lime.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet">
</head>

<body>
    <div class='loader'>
        <div class='spinner-grow text-primary' role='status'>
            <span class='sr-only'>Loading...</span>
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/template/sidebar.inc.php'); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/template/topbar.inc.php'); ?>