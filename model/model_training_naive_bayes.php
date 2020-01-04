<?php
require_once 'function/koneksi_procedural.php';
include_once 'function/f_naivebayes.php';

$nb = new Naive_bayes();
if (isset($_GET['btsubmit']) && $_GET['btsubmit']=='bayes') {
  $nb->set_probabilitas_kata_positif();
  $nb->set_probabilitas_kata_negatif();
}

function data_bobot_bayes_training() {
	GLOBAL $con;
	$query = "SELECT `id_kata`, `kata`, `bobot_bayes_positif`, `bobot_bayes_negatif` FROM `data_training_kata`";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}


?>
