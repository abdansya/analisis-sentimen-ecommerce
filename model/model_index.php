<?php

$data = new Data_testing();
$data->set_data_testing();
$data->set_data_testing_pie();
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



?>
