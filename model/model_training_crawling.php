<?php
require_once 'function/koneksi_procedural.php';

if(isset($_POST['rownum'])) {
	update_data_training($_POST['field'],$_POST['value'],$_POST['rownum']);
}

function data_training() {
	GLOBAL $con;
	$query = "SELECT * FROM `data_training`";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}

function update_data_training($field, $data, $rownum) {
	GLOBAL $con;
	$query = "UPDATE `data_training` SET `".$field."` = '".$data."' WHERE `id_training` = ".$rownum;
	mysqli_query($con, $query) or die(mysql_error());
}

?>
