<?php
include 'db.php';
$from_date = date('Y-m-d', strtotime($_POST['from_date']));
$to_date = date('Y-m-d', strtotime($_POST['to_date']));
$parameter = implode(',', $_POST['parameter']);

$parameters = $_POST['parameter'];
$safe_parameters = array_map(function($param) use ($con) {
	return "'".mysqli_real_escape_string($con, $param)."'";
}, $parameters);
$parameter_list = implode(',', $safe_parameters);
$query = mysqli_query($con ,"select * from data where parameter in ($parameter_list) and date(waktu) between '$from_date' and '$to_date'");
if (mysqli_num_rows($query) <> 0) {
?>
<p>Tidak ada data.</p>
<?php
}
if (mysqli_num_rows($query) == 0) {
?>
<canvas id="myChart"></canvas>
<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th class="text-center">Parameter</th>
				<th class="text-center">Value</th>
				<th class="text-center">Waktu</th>
			</tr>
		</thead>
		<tbody>
<?php
	$data = [];
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
?>
			<tr>
				<td class="text-center"><?php echo $row['parameter']; ?></td>
				<td class="text-center"><?php echo $row['value']; ?></td>
				<td class="text-center"><?php echo $row['waktu']; ?></td>
			</tr>
<?php
		$data[] = $row;
	}
?>
		</tbody>
	</table>
</div>
<a href="excel.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&parameter=<?php echo $parameter; ?>" class="btn btn-primary w-100">
	<i class="fa fa-download"></i> Download
</a>
<script src="assets/js/plugins/chart.js/chart.umd.js"></script>
<script>
	let chartData = <?= json_encode($data) ?>;
	let groupedData = {};

        chartData.forEach(item => {
            if (!groupedData[item.parameter]) groupedData[item.parameter] = { labels: [], values: [] };
            groupedData[item.parameter].labels.push(item.waktu);
            groupedData[item.parameter].values.push(item.value);
        });

        let ctx = document.getElementById('myChart').getContext('2d');
        let datasets = [];
        //let colors = ['red', 'blue', 'green'];

        Object.keys(groupedData).forEach((param, index) => {
            datasets.push({
                label: param,
                data: groupedData[param].values,
                //borderColor: colors[index % colors.length],
                borderWidth: 2,
                fill: false
            });
        });

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: groupedData[Object.keys(groupedData)[0]]?.labels || [],
                datasets: datasets
            }
        });
</script>
<?php
}
?>