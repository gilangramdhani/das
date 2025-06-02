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
		<link rel="stylesheet" href="assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
		<link rel="stylesheet" href="assets/js/plugins/select2/css/select2.min.css">
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
						<a href="./" class="btn btn-alt-secondary ms-2">
							<i class="fa fa-home"></i>
						</a>
					</div>
				</div>
			</header>
			<main id="main-container">
				<div class="content">
					<form id="form" method="post">
						<div class="content">
							<div class="block block-rounded">
								<div class="block-header block-header-default">
									<h3 class="block-title">Report</h3>
								</div>
								<div class="block-content">
									<div class="row items-push">
										<div class="col-md-3">
											<input id="from_date" type="text" class="form-control" name="from_date" placeholder="Start Date" autocomplete="off" onkeydown="return false" onclick="return false" required="required">
										</div>
										<div class="col-md-3">
											<input id="to_date" type="text" class="form-control" name="to_date" placeholder="End Date" autocomplete="off" onkeydown="return false" onclick="return false" required="required">
										</div>
										<div class="col-md-3">
											<select id="parameter" class="form-select select2" name="parameter[]" multiple="multiple" required="required" style="width: 100%;">
												<option></option>
<?php
$query = mysqli_query($con, "select * from parameter");
while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		?>
												<option value="<?php echo $data['parameter_code']; ?>"><?php echo $data['parameter_name']; ?></option>
<?php
}
?>
											</select>
										</div>
										<div class="col-md-3">
											<button id="submit_btn" type="submit" class="btn btn-primary w-100">Search</button>
										</div>
									</div>
								</div>
								<div class="block-content" id="result"></div>
							</div>
						</div>
					</form>
				</div>
			</main>
		</div>
		<script src="assets/js/dashmix.app.min.js"></script>
		<script src="assets/js/jquery-latest.min.js"></script>
		<script src="assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/plugins/select2/js/select2.full.min.js"></script>
		<script>
			$(document).ready(function () {
				$('#to_date').attr('disabled', true);

				$('#from_date').datepicker({
					format: 'yyyy-mm-dd',
					autoclose: true,
					endDate: "today",
					todayHighlight: true
				}).on('changeDate', function(selected) {
					var minDate = new Date(selected.date.valueOf());
					var maxDate = new Date(selected.date.valueOf() + (1000 * 60 * 60 * 24 * 7));
					$('#to_date').datepicker('clearDates');
					$('#to_date').datepicker('setStartDate', minDate);
					$('#to_date').datepicker('setEndDate', maxDate);
					$('#to_date').attr('disabled', false);
				});

				$('#to_date').datepicker({
					format: 'yyyy-mm-dd',
					autoclose: true,
				}).on('changeDate', function(selected) {
					
				});

				$('.select2').select2({
					placeholder: 'Parameter',
				});
				
				$('body').on('submit', '#form', function(e) {
					e.preventDefault();
					$.ajax({
						'url': 'fetch.php',
						'method': 'POST',
						'data': $('#form').serialize(),
						'beforeSend': function() {
							$('#submit_btn').text('Loading');
							$('#submit_btn').attr('disabled', true);
						},
						'success': function(data) {
							$('#submit_btn').text('Search');
							$('#submit_btn').attr('disabled', false);
							$('#result').html(data);
						},
					});
				});
			});
		</script>
	</body>
</html>
