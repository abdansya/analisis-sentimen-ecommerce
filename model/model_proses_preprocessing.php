<?php
require_once "function/koneksi_procedural.php";
require_once 'function/koneksi.php';
include_once 'function/f_preprocessing.php';

$o_koneksi = new Koneksi();
$o_preprocessing = new Preprocessing();

if (isset($_GET['btsubmit']) && $_GET['btsubmit'] == 'prepro'){
  $query = $o_koneksi->con->query("SELECT * FROM `data_testing` WHERE `tweet_preprocessing` IS NULL");
  while ($row = $query->fetch_array()) {
    $id = $row['id_tes'];
    $tweet = $o_preprocessing->input($row['tweet']);
    // $sentimen = $o_naivebayes->klasifikasi_sentimen_testing($tweet);
    $query_update = $o_koneksi->con->query("UPDATE `data_testing` SET `tweet_preprocessing` = '".$tweet."'  WHERE `id_tes` = ".$id."");
  }
}

function data_crawling_testing() {
	GLOBAL $con;
	$tanggal_crawling = date('Y-m-d', strtotime('-8 days', strtotime( date('Y-m-d') )));
	$query = "SELECT * FROM `data_testing` WHERE `tanggal` > '".$tanggal_crawling."' ORDER BY `data_testing`.`id_tes` DESC";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}


?>
