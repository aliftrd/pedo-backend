<?php
require_once('vendor/autoload.php');

use Models\User;

$users = User::get();
echo $users;
