<?php
require_once 'function/koneksi_procedural.php';

function data_bobot_ig() {
	GLOBAL $con;
  $query1 = "SELECT `threshold` FROM `data_akurasi` ORDER BY `data_akurasi`.`akurasi` DESC LIMIT 1";
  $hasil1 = mysqli_query($con, $query1);
  $row = mysqli_fetch_assoc($hasil1);
  $batas = $row['threshold'];
	echo $query = "SELECT * FROM `data_training_kata` ORDER BY `data_training_kata`.`bobot_ig` DESC LIMIT $batas";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}


?>
