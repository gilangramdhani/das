<?php
include 'db.php';
function curl($url, $curl_header, $curl_data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
}

$sandbox_url = 'http://172.26.231.10/sandbox/index2.php';
$client_id = '36a3f70e918248671c438a81d478bf6c';
$secret_id = 'ed472d1bce3ed19f131f9feb8b9f4a77a3f29923f85648a27e3484c4e103bbc0';
$key = md5($client_id.$secret_id);
$curl_header = array(
        "key:$key"
);
$curl_data = array();

$now = date('Y-m-d H:i:00');

$query = mysqli_query($con, "select parameter_code from parameter");
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$parameter_code = $row['parameter_code'];
	$query2 = mysqli_query($con, "select value from data where parameter = '$parameter_code' order by waktu desc limit 1");
	$row2 = mysqli_fetch_array($query2, MYSQLI_ASSOC);
	$curl_data[$parameter_code] = $row2['value'];
}
$curl_data['status'] = 'valid';
$curl_data['waktu'] = $now;
$curl_data['cerobong_id'] = 1;

//$send = curl($sandbox_url, $curl_header, json_encode($curl_data));
//$response = json_decode($send, true);
//echo $send;
echo json_encode($curl_data);


?>
