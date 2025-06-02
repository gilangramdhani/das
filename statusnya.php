<?php
include 'db.php';

$id = $_POST['action'];
$parameter_status = $_POST['status'];

if ($parameter_status == 'normal') {
	$parameter_status = '';
}
mysqli_query($con, "update parameter set parameter_status = '$parameter_status' where parameter_id = '$id'");

echo 'OK';
?>