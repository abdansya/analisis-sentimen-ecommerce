<?php
require_once 'function/koneksi_procedural.php';
include_once 'function/f_informationgain.php';
$ig_entropy = new Information_gain();
if (isset($_GET['btsubmit'])) {
  $info_gain = new Information_gain();
  $info_gain->set_jumlah_kata_ya_p();
  $info_gain->set_jumlah_kata_ya_n();
  $info_gain->set_jumlah_semuakata_ya();
  $info_gain->set_jumlah_kata_tidak_p();
  $info_gain->set_jumlah_kata_tidak_n();
  $info_gain->set_jumlah_semuakata_tidak();
  $info_gain->set_entropy_kata_ya();
  $info_gain->set_entropy_kata_tidak();
  $info_gain->entropy_set();
  $info_gain->entropy_kata();
  $info_gain->set_info_gain();
}

function data_bobot_training() {
	GLOBAL $con;
	$query = "SELECT * FROM `data_training_kata` ORDER BY `id_kata` ASC";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}

?>
