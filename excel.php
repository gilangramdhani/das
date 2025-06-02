<?php
include 'db.php';
// Include autoloader PhpSpreadsheet
require 'vendor/autoload.php'; // pastikan path ini sesuai dengan lokasi autoloader composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$parameter = $_GET['parameter'];
$parameters = explode(',', $_GET['parameter']);
$safe_parameters = array_map(function($param) use ($con) {
	return "'".mysqli_real_escape_string($con, $param)."'";
}, $parameters);
$parameter_list = implode(',', $safe_parameters);
// Query untuk mengambil data
$sql = "SELECT * from data where parameter in ($parameter_list) and date(waktu) between '$from_date' and '$to_date'"; // sesuaikan dengan tabel dan kolom yang kamu inginkan
$query = mysqli_query($con, $sql);

// Membuat objek spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan header kolom
$sheet->setCellValue('A1', 'Parameter');
$sheet->setCellValue('B1', 'Value');
$sheet->setCellValue('C1', 'Waktu');

// Mengisi data dari query MySQL
$rowNum = 2; // Dimulai dari baris ke-2 setelah header
if (mysqli_num_rows($query) <> 0) {
    while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $sheet->setCellValue('A'.$rowNum, $data['parameter']);
        $sheet->setCellValue('B'.$rowNum, $data['value']);
        $sheet->setCellValue('C'.$rowNum, $data['waktu']);
        $rowNum++;
    }
}

$styleArray = array(
	'font' => array(
		'bold' => true
	)
);
$sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1:C1')->applyFromArray($styleArray);
foreach (range('A','C') as $col) {
	$sheet->getColumnDimension($col)->setAutoSize(true);
}

// Menyimpan file Excel (XLSX)
$writer = new Xlsx($spreadsheet);
$filename = $from_date.'_'.$to_date.'_'.$_GET['parameter'].'.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
?>
