<?php
require_once('../vendor/autoload.php');

use Models\Admin;

$admin = Admin::find(2);
echo '<pre>';
echo $admin;
echo '</pre>';
