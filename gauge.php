<?php
$id = $_GET['id'];
include 'db.php';
$parameterQuery = mysqli_query($con, "select parameter_code from parameter where parameter_id = '$id'");
$parameterData = mysqli_fetch_array($parameterQuery, MYSQLI_ASSOC);
$parameter = $parameterData['parameter_code'];
$query = mysqli_query($con, "select value from data where parameter = '$parameter' order by id desc limit 1");
$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
$value = $data['value'];

$my_data = array();
$my_data['nilai'] = $value;
$my_data['chart'] = $value;
echo json_encode($my_data);
?>