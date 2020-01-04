<?php
require_once "function/koneksi_procedural.php";

function data_bayes_testing() {
	GLOBAL $con;
	$tanggal_crawling = date('Y-m-d', strtotime('-8 days', strtotime( date('Y-m-d') )));
	$query = "SELECT `id_tes`, `tweet`, `bobot_bayes_positif`, `bobot_bayes_negatif`, `sentimen` FROM `data_testing` WHERE `tanggal` > '".$tanggal_crawling."' ORDER BY `data_testing`.`id_tes` DESC";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}

?>
