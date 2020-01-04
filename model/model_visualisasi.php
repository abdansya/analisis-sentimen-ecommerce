<?php
require_once 'function/koneksi_procedural.php';
include_once 'function/f_tampildata.php';

$data = new Data_testing();
// penentuan tampilan bulan atau pekan
if (isset($_POST['pilihanvisual']) && $_POST['pilihanvisual'] == 'pekan') {
  $judul = 'Analisis 1 Pekan';
  $data->set_data_testing();
  $data->set_data_testing_pie();
} elseif (isset($_POST['pilihanvisual']) && $_POST['pilihanvisual'] == 'bulan') {
  $judul = 'Analisis 1 Bulan';
  $data->set_data_testing_bulan();
  $data->set_data_testing_pie();
} elseif (isset($_POST['pilihanvisual']) && $_POST['pilihanvisual'] == '6bulan') {
  $judul = 'Analisis 6 Bulan';
  $data->set_data_testing_6_bulan();
  $data->set_data_testing_pie();
} elseif (isset($_POST['pilihanvisual']) && $_POST['pilihanvisual'] == '12bulan') {
  $judul = 'Analisis 12 Bulan';
  $data->set_data_testing_12_bulan();
  $data->set_data_testing_pie();
} else {
  $judul = 'Analisis 1 Pekan';
  $data->set_data_testing();
  $data->set_data_testing_pie();
}

$data_lazada_p = $data->sentimen_lazada_p;
$data_lazada_n = $data->sentimen_lazada_n;
$data_bukalapak_p = $data->sentimen_bukalapak_p;
$data_bukalapak_n = $data->sentimen_bukalapak_n;
$data_tokopedia_p = $data->sentimen_tokopedia_p;
$data_tokopedia_n = $data->sentimen_tokopedia_n;

$tanggal = "[";
foreach ($data_lazada_p as $key => $value) {
	$tanggal = $tanggal."\" ".$key."\",";
}
$tanggal = substr($tanggal, 0, -1);
$tanggal = $tanggal." ]";


$datalp = "[";
foreach ($data_lazada_p as $keylp => $valuelp) {
	$datalp = $datalp." ".$valuelp.",";
}
$datalp = substr($datalp, 0, -1);
$datalp = $datalp." ]";

$dataln = "[";
foreach ($data_lazada_n as $keyln => $valueln) {
	$dataln = $dataln." ".$valueln.",";
}
$dataln = substr($dataln, 0, -1);
$dataln = $dataln." ]";

$databp = "[";
foreach ($data_bukalapak_p as $keybp => $valuebp) {
	$databp = $databp." ".$valuebp.",";
}
$databp = substr($databp, 0, -1);
$databp = $databp." ]";

$databn = "[";
foreach ($data_bukalapak_n as $keybn => $valuebn) {
	$databn = $databn." ".$valuebn.",";
}
$databn = substr($databn, 0, -1);
$databn = $databn." ]";

$datatp = "[";
foreach ($data_tokopedia_p as $keytp => $valuetp) {
	$datatp = $datatp." ".$valuetp.",";
}
$datatp = substr($datatp, 0, -1);
$datatp = $datatp." ]";

$datatn = "[";
foreach ($data_tokopedia_n as $keytn => $valuetn) {
	$datatn = $datatn." ".$valuetn.",";
}
$datatn = substr($datatn, 0, -1);
$datatn = $datatn." ]";

$persenlp = round(($data->jml_sentimen_lazada_p/$data->jml_semua_sentimen)*100, 2)."  ";
$persenln = round(($data->jml_sentimen_lazada_n/$data->jml_semua_sentimen)*100, 2)."  ";
$persenbp = round(($data->jml_sentimen_bukalapak_p/$data->jml_semua_sentimen)*100, 2)."  ";
$persenbn = round(($data->jml_sentimen_bukalapak_n/$data->jml_semua_sentimen)*100, 2)."  ";
$persentp = round(($data->jml_sentimen_tokopedia_p/$data->jml_semua_sentimen)*100, 2)."  ";
$persentn = round(($data->jml_sentimen_tokopedia_n/$data->jml_semua_sentimen)*100, 2)."  ";


$arr_threshold = [];
$arr_akurasi   = [];
$arr_waktu     = [];

function get_data_akurasi() {
  GLOBAL $con;
  GLOBAL $arr_threshold;
  GLOBAL $arr_akurasi;
  GLOBAL $arr_waktu;
  $query = "SELECT * FROM `data_akurasi`";
  $hasil = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($hasil)) {
    array_push($arr_threshold, $row['threshold']);
    array_push($arr_akurasi, $row['akurasi']);
    array_push($arr_waktu, $row['waktu']);
  }
}
get_data_akurasi();
$threshold = "";
$akurasi = "";
$waktu = "";
foreach ($arr_threshold as $value) {
  $threshold .= "'$value'".",";
}
foreach ($arr_akurasi as $value) {
  $akurasi .= "$value".",";
}
foreach ($arr_waktu as $value) {
  $waktu .= "$value".",";
}

$threshold_ = substr($threshold, 0, -1);
$akurasi_ = substr($akurasi, 0, -1);
$waktu_ = substr($waktu, 0, -1);

?>
