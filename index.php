<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<title>Data Acquisition System</title>
		<meta name="robots" content="index, follow">
		<meta name="author" content="Titan Prabowo">
		<meta name="description" content="Data Acquisition System">
		<link rel="shortcut icon" type="image/png" href="assets/media/favicons/favicon.png"/>
		<link rel="stylesheet" id="css-main" href="assets/css/dashmix.min.css">
		<link rel="stylesheet" id="css-main" href="assets/css/themes/xeco.min.css">
	</head>
	<body>
		<div id="page-container" class="page-header-fixed page-header-dark">
			<header id="page-header">
				<div class="content-header">
					<div class="d-flex align-items-center">
						<a class="fw-semibold text-dual tracking-wide" href="./">
							DAS
						</a>
					</div>
					<div>
						<a href="report.php" class="btn btn-alt-secondary ms-2">
							<i class="fa fa-table"></i>
						</a>
					</div>
				</div>
			</header>
			<main id="main-container">
				<div class="row g-0 flex-md-grow-1">
					 <div class="col-md-4 col-lg-5 col-xl-3 bg-white">
						<div class="block block-rounded">
							<div class="block text-center bg-video" data-vide-bg="assets/media/videos/tunnel" data-vide-options="posterType: jpg">
								<div class="block-content block-content-full bg-black-50">
									<img class="img-avatar img-avatar-thumb img-avatar-rounded mb-4" src="assets/media/avatars/logo.jpg" alt="">
									<p class="fw-semibold text-white mb-0">PT. DONGGI SENORO LNG</p>
									<p class="fs-sm text-white-75 mb-0">Batui, Sulawesi Tengah</p>
								</div>
								<div class="block-content bg-white mt-0">
									<div class="row g-0 text-center">
										<div class="col-12 border-bottom fw-semibold pb-3">
											GTC C3
										</div>
									</div>
									<div class="row g-0 text-center mt-2">
										<div class="col-12 border-bottom">
											<sup><strong>MEASUREMENT INFO</strong></sup>
										</div>
									</div>
<?php
$query = mysqli_query($con, "select * from parameter");
while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	if ($data['parameter_status'] == '') {
		$button = '<button id="parent'.$data["parameter_id"].'" type="button" class="btn-block-option dropdown-toggle text-black" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Normal</button>';
	}
	if ($data['parameter_status'] == 'maintenance') {
		$button = '<button id="parent'.$data["parameter_id"].'" type="button" class="btn-block-option dropdown-toggle text-black" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Maintenance</button>';
	}
	if ($data['parameter_status'] == 'rusak') {
		$button = '<button id="parent'.$data["parameter_id"].'" type="button" class="btn-block-option dropdown-toggle text-black" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Rusak</button>';
	}
?>									
									<div class="row g-0 text-center mt-2">
										<div class="col-2 border-bottom mt-1">
											<sup><b><?php echo $data['parameter_code']; ?></b></sup>
										</div>
										<div class="col-6 border-bottom mt-1">	
											<sup>0 - <?php echo $data['parameter_threshold']; ?> <?php echo $data['parameter_unit']; ?></sup>
										</div>
										<div class="col-4 border-bottom mt-2">
<sup>
	<div class="dropdown">
		<?php echo $button; ?>
		<div class="dropdown-menu dropdown-menu-end">
			<button class="dropdown-item" href="status.php?id=<?php echo $data['parameter_id']; ?>&status=normal" action="<?php echo $data['parameter_id']; ?>" status="normal">
				<i class="fa fa-fw fa-circle-check me-1"></i> Normal
			</button>
			<button class="dropdown-item" href="status.php?id=<?php echo $data['parameter_id']; ?>&status=maintenance" action="<?php echo $data['parameter_id']; ?>" status="maintenance">
				<i class="fa fa-fw fa-wrench me-1"></i> Maintenance
			</button>
			<button class="dropdown-item" href="status.php?id=<?php echo $data['parameter_id']; ?>&status=rusak" action="<?php echo $data['parameter_id']; ?>" status="rusak">
				<i class="fa fa-fw fa-burst me-1"></i> Rusak
			</button>
		</div>
	</div>
</sup>
										</div>
									</div>
<?php
}
?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-8 col-lg-7 col-xl-9">
						<div class="block block-rounded">
							<div class="block-content p-0 bg-body-light">
								<div class="row g-0 text-center">
									<div class="col-12 col-xl-12 border-end border-bottom bg-body-dark">
										<div class="row g-0 text-center">
											<div class="col-12 p-1">
												<div class="fs-sm">
													RTDB Connection is <span class="fw-semibold text-success">Online</span>
<?php
/*
$serverName = '172.26.110.88';
$connectionInfo = array(
    "Uid" => "CEMSuser1",
    "PWD" => "DSLNg2022@"
);
$koneksi = sqlsrv_connect($serverName, $connectionInfo);
if(!$koneksi) {
    echo 'RTDB Connection is <span class="fw-semibold text-danger">Offline</span>';
}
if ($koneksi) {
	echo 'RTDB Connection is <span class="fw-semibold text-success">Online</span>';
}
*/
?>
												</div>
											</div>
										</div>
									</div>
<?php
$query = mysqli_query($con, "select * from parameter");
while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
?>
									<div class="col-12 col-xl-4 border-end border-bottom">
										<div class="row g-0 text-center">
											<div class="col-12 p-3">
												<div class="fs-sm">
													<span class="fw-semibold"><?php echo $data['parameter_name']; ?></span>
													<br><br>
													<canvas id="gauge<?php echo $data['parameter_id']; ?>" class="img-fluid col-8"></canvas>
													<br>
													<span id="nilai<?php echo $data['parameter_id']; ?>" class="fs-4 fw-bold">0</span>
													<br>
													<sup><?php echo $data['parameter_unit']; ?></sup>
												</div>
											</div>
										</div>
									</div>
<?php
}
?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
		<script src="assets/js/dashmix.app.min.js"></script>
		<script src="assets/js/jquery-latest.min.js"></script>
		<script src="assets/js/plugins/gauge/gauge.min.js"></script>
		<script src="assets/js/plugins/peity/peity.min.js"></script>
		<script src="assets/js/plugins/vide/jquery.vide.min.js"></script>
		<script>
<?php
$query = mysqli_query($con, "select * from parameter");
while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$threshold = $data['parameter_threshold'];
?>
			var opts<?php echo $data['parameter_id']; ?> = {
				angle: 0,
				lineWidth: 0.25,
				radiusScale: 1,
				pointer: {
					length: 0.5,
					strokeWidth: 0.025,
					color: '#000'
				},
				limitMax: true,
				limitMin: true,
				generateGradient: true,
				highDpiSupport: true,
				staticZones: [
					{strokeStyle: '#6f9c40', min: <?php echo percentage(0, $threshold); ?>, max: <?php echo percentage(70, $threshold); ?>},
					{strokeStyle: '#e69f17', min: <?php echo percentage(70, $threshold); ?>, max: <?php echo percentage(100, $threshold); ?>},
					{strokeStyle: '#e04f1a', min: <?php echo percentage(100, $threshold); ?>, max: <?php echo percentage(120, $threshold); ?>}
				],
				staticLabels: {
					font: '10px sans-serif',
					labels: [<?php echo percentage(0, $threshold); ?>, <?php echo percentage(20, $threshold); ?>, <?php echo percentage(40, $threshold); ?>, <?php echo percentage(60, $threshold); ?>, <?php echo percentage(80, $threshold); ?>, <?php echo percentage(100, $threshold); ?>, <?php echo percentage(120, $threshold); ?>],
					color: '#000',
					fractionDigits: 0
				},
				renderTicks: {
					divisions: 10,
					divWidth: 1,
					divLength: 1,
					divColor: '#fff',
					subDivisions: 5,
					subLength: 0.5,
					subWidth: 0.5,
					subColor: '#f3f3f4'
				}
			};
			var target<?php echo $data['parameter_id']; ?> = document.getElementById('gauge<?php echo $data['parameter_id']; ?>');
			var gauge<?php echo $data['parameter_id']; ?> = new Gauge(target<?php echo $data['parameter_id']; ?>).setOptions(opts<?php echo $data['parameter_id']; ?>);
			gauge<?php echo $data['parameter_id']; ?>.maxValue = <?php echo percentage(120, $threshold); ?>;
			gauge<?php echo $data['parameter_id']; ?>.setMinValue(0);
			gauge<?php echo $data['parameter_id']; ?>.animationSpeed = 32;
			gauge<?php echo $data['parameter_id']; ?>.set(0);
<?php
}
?>
			setInterval(function() {
<?php
$query = mysqli_query($con, "select * from parameter");
while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$threshold = $data['parameter_threshold'];
?>
				$.getJSON('gauge.php?id=<?php echo $data['parameter_id']; ?>', function(response) {
					$('#nilai<?php echo $data['parameter_id']; ?>').html(response.nilai);
					gauge<?php echo $data['parameter_id']; ?>.set(response.chart);
				});
<?php
}
?>
			}, 1000);
			function ucfirst(str) {
				return str.charAt(0).toUpperCase() + str.slice(1);
			}
			$('body').on('click', '.dropdown-item', function() {
				var action = $(this).attr('action');
				var status = $(this).attr('status');
				$.ajax({
					'url' : 'statusnya.php',
					'method' : 'POST',
					'data' : {action:action, status:status},
					'success' : function(data) {
						$('#parent'+action).text(ucfirst(status));
					}
				});
			});
		</script>
	</body>
</html>
