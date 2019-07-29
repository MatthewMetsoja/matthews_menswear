<?php

require_once  './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create('./');
$dotenv->load();

$connection = mysqli_connect(getenv(Hst),getenv(Usr),getenv(Pw),getenv(Db));


if(mysqli_connect_errno())
{ 
    die('db connection failed with following errors'.mysqli_connect_error() );
}


    date_default_timezone_set('Europe/London');

?>