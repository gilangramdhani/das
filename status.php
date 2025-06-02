<?php
include 'db.php';

$id = $_GET['id'];
$status = $_GET['status'];

if ($status == '') {
	$parameter_status = 'normal';
}
if ($status == 'maintenance') {
	$parameter_status = 'maintenance';
}
if ($status == 'rusak') {
	$parameter_status = 'rusak';
}
mysqli_query($con, "update parameter set parameter_status = '$parameter_status' where parameter_id = '$id'");

header('Location: index.php');
?>