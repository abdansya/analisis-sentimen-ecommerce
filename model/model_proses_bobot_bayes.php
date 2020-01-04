<?php
require_once 'function/koneksi_procedural.php';
include_once 'function/f_naivebayes.php';
$o_koneksi = new Koneksi();
$o_naivebayes = new Naive_bayes();

if (isset($_GET['btsubmit']) && $_GET['btsubmit'] == 'bobot_bayes'){
  $query = $o_koneksi->con->query("SELECT * FROM `data_testing` WHERE `bobot_bayes_positif` IS NULL");
  while ($row = $query->fetch_array()) {
    $id = $row['id_tes'];
    $tweet = $row['tweet_preprocessing'];
    list($prob_pos, $prob_neg, $sentimen) =  $o_naivebayes->klasifikasi_sentimen_testing($tweet);
    $query_update = $o_koneksi->con->query("UPDATE `data_testing` SET `bobot_bayes_positif` = ".$prob_pos.", `bobot_bayes_negatif` = ".$prob_neg.", `sentimen` = '".$sentimen."'  WHERE `id_tes` = ".$id."");
  }
}

function data_bobot_bayes_testing() {
	GLOBAL $con;
	$tanggal_crawling = date('Y-m-d', strtotime('-8 days', strtotime( date('Y-m-d') )));
	$query = "SELECT `id_tes`, `tweet`, `bobot_bayes_positif`, `bobot_bayes_negatif`, `sentimen` FROM `data_testing` WHERE `tanggal` > '".$tanggal_crawling."' ORDER BY `data_testing`.`id_tes` DESC";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}


?>
