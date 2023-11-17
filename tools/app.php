<?php

use Model\CLinit;
require __DIR__.'/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require __DIR__.'/database.php';
require __DIR__.'/funciones.php';


$db = connectDB();

CLinit::setDB($db);

?>