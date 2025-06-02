<?php
function percentage($a, $b) {
	$result = ($a / 100) * $b;
	return $result;
}

function ping($host, $timeout = 1) {
	$output = null;
	$status = null;
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		$cmd = "ping -n 1 -w " . ($timeout * 1000) . " " . escapeshellarg($host);
	} else {
		$cmd = "ping -c 1 -W " . escapeshellarg($timeout) . " " . escapeshellarg($host);
	}
	exec($cmd, $output, $status);
    return $status === 0;
}
?>