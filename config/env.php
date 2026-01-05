<?php 

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

//define("DATABASE_DRIVE",$_ENV[DATABASE_DRIVE]);

?>