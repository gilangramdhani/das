<?php
include 'db.php';
$from =  date('Y-m-d H:i:s', strtotime('+1 hour', strtotime(date('Y-m-d H:00:00'))));
$to = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($from)));
do {
	$from = date('Y-m-d H:i:s', strtotime('+1 minutes', strtotime($from)));
	mysqli_query($con, "insert ignore into notif (notif_date, notif_status) values ('$from', '')");
	//echo $from.'<br>';
}
while ($from < $to);
?>