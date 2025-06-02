<?php
date_default_timezone_set("Asia/Makassar");

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'das';

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

include 'function.php';
?>