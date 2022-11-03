<?php
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$database = new Capsule;
$database->addConnection(include 'config/database.php');

$database->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$database->setAsGlobal();
$database->bootEloquent();
