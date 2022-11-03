<?php

require '../models/Admin.php';
$admin = Admin::find(2);
echo '<pre>';
echo $admin;
echo '</pre>';
