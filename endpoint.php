<?php
include 'db.php';
if (isset($_SERVER['HTTP_KEY'])) {
	$response = array();
	$data = json_decode(file_get_contents('php://input'), true);
	$waktu = $data['waktu'];
	$cerobong = $data['cerobong'];
	$query = mysqli_query($con, "select * from parameter");
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$parameter = $row['parameter_code'];
		$value = $data[$parameter];
		$status = $row['parameter_status'];
		if ($status == 'maintenance') {
			$value = 1;
		}
		if ($status == 'rusak') {
			$value = 0;
		}
		mysqli_query($con, "insert ignore into data (cerobong, parameter, value, waktu) values ('$cerobong', '$parameter', '$value', '$waktu')");
	}
	mysqli_query($con, "update notif set notif_status = 'success' where notif_date = '$waktu'");
	$response['code'] = 200;
	$response['status'] = 'OK';
	echo json_encode($response);
}