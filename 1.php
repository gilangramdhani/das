<?php
date_default_timezone_set("Asia/Makassar");

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

$sandbox_url = 'http://localhost/donggi/enpoint.php';
$client_id = '36a3f70e918248671c438a81d478bf6c';
$secret_id = 'ed472d1bce3ed19f131f9feb8b9f4a77a3f29923f85648a27e3484c4e103bbc0';
$key = md5($client_id.$secret_id);
$curl_header = array(
	"key:$key"
);
$curl_data = array();

$serverName = "172.26.110.88";
$connectionInfo = array(
    "Uid" => "CEMSuser",
    "PWD" => "DSLNg2022@"
);
$conn = sqlsrv_connect($serverName, $connectionInfo);
if(!$conn) {
    die( print_r(sqlsrv_errors(), true));
}

function get_data($parameter, $tag) {
	global $conn;
	$tags = 'Root.All Tag.PVI.UNIT-051.'.$tag.'.PV.Value';
	$query = "exec [QConfig].[dbo].QTrendData ?, ?, ?, ?, ?, ?";
	$params = array(
		'Value, Timestamp',
		'NOW-1 MINUTES',
		'NOW',
		'00:0:00',
		'IncludeBounding',
		$tags
	);
	$stmt = sqlsrv_query($conn, $query, $params);
	if(!$stmt) {
		die(print_r(sqlsrv_errors(), true));
	}
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	$value = $tags.':Value';
	$timestamp = $tags.':Timestamp';
	$value = $row[$value];
	$timestamp = $row[$timestamp]->format('Y-m-d H:i:s');
	$result = array(
        'parameter' => $parameter,
        'value' => $value,
        'timestamp' => $timestamp
    );
	sqlsrv_free_stmt($stmt);
	return $result;
}

function rumus($parameter, $value) {
	$O2 = get_data('O2', '051AI1784E');
	$O2_Corr = $O2['value'];
	if ($parameter == 'NOx') {
		$corr = ($value * 1.88) * ((21-15) / (21 - $O2_Corr));
	}
	if ($parameter == 'SO2') {
		$corr = ($value * 2.62) * ((21-15) / (21 - $O2_Corr));
	}
	if ($parameter == 'CO') {
		$corr = ($value * 1.15) * ((21-15)/(21 - $O2_Corr));
	}
	if ($parameter == 'O2') {
		$corr = $value;
	}
	if ($parameter == 'PM') {
		$corr = $value * ((21-15)/(21 - $O2_Corr));
	}
	if ($parameter == 'Flow') {
		//$corr = $value * (1.0 + ($O2_Corr * -0.88 + 1.9) / (0.21 - $O2_Corr));
		$corr = ($value * 1.008085 * (1 + ((($O2_Corr / 100) + 1.886889) / (0.21 - ($O2_Corr / 100))))) / 3600;
	}
	return $corr;
}

$now = date('Y-m-d H:i:00');

/*
$parameter_array = [
	'NOx',
	'SO2',
	'CO',
	'O2',
	'PM',
	'Flow'
];

$tag_array = [
	'051AI1784A',						
	'051AI1784B',
	'051AI1784C',
	'051AI1784E',
	'051AI1785B',
	'051FI1081'
];
*/

$NOx = get_data('NOx', '051AI1784A');
//echo '<b>'.$NOx['parameter'].'</b><br>';
//echo 'Value : '.number_format($NOx['value'], 2).'<br>';
//echo 'Corr : '.number_format(rumus($NOx['parameter'], $NOx['value']), 2).'<br><br>';
$curl_data['NOx'] = number_format(rumus($NOx['parameter'], $NOx['value']), 2);

$SO2 = get_data('SO2', '051AI1784B');
//echo '<b>'.$SO2['parameter'].'</b><br>';
//echo 'Value : '.number_format($SO2['value'], 2).'<br>';
//echo 'Corr : '.number_format(rumus($SO2['parameter'], $SO2['value']), 2).'<br><br>';
$curl_data['SO2'] = number_format(rumus($SO2['parameter'], $SO2['value']), 2);

$CO = get_data('CO', '051AI1784C');
//echo '<b>'.$CO['parameter'].'</b><br>';
//echo 'Value : '.number_format($CO['value'], 2).'<br>';
//echo 'Corr : '.number_format(rumus($CO['parameter'], $CO['value']), 2).'<br><br>';
$curl_data['CO'] = number_format(rumus($CO['parameter'], $CO['value']), 2);

$O2 = get_data('O2', '051AI1784E');
//echo '<b>'.$O2['parameter'].'</b><br>';
//echo 'Value : '.number_format($O2['value'], 2).'<br>';
//echo 'Corr : '.number_format(rumus($O2['parameter'], $O2['value']), 2).'<br><br>';
$curl_data['O2'] = number_format(rumus($O2['parameter'], $O2['value']), 2);

$PM = get_data('PM', '051AI1785B');
//echo '<b>'.$PM['parameter'].'</b><br>';
//echo 'Value : '.number_format($PM['value'], 2).'<br>';
//echo 'Corr : '.number_format(rumus($PM['parameter'], $PM['value']), 2).'<br><br>';
$curl_data['PM'] = number_format(rumus($PM['parameter'], $PM['value']), 2);

$Flow = get_data('Flow', '051FI1081');
//echo '<b>'.$Flow['parameter'].'</b><br>';
//echo 'Value : '.number_format($Flow['value'], 2).'<br>';
//echo 'Corr : '.number_format(rumus($Flow['parameter'], $Flow['value']), 2).'<br><br>';
$curl_data['Flow'] = number_format(rumus($Flow['parameter'], $Flow['value']), 2);

$curl_data['waktu'] = $now;
$curl_data['cerobong'] = 1;

$send = curl($sandbox_url, $curl_header, json_encode($curl_data));
$response = json_decode($send, true);
echo $send;
//echo json_encode($curl_data);

sqlsrv_close($conn);
?>