<?php
require_once 'function/koneksi_procedural.php';
include_once 'function/f_crawlingtweet.php';

$o_crawling = new Crawling();

if (isset($_GET['btsubmit'])) {
  $kata_kunci = "";
  $id_akun = null;
  if (isset($_GET['katakunci']) && $_GET['katakunci'] == 'lazadaid' && $_GET['btsubmit']) {
    $kata_kunci = $_GET['katakunci'];
    $id_akun = 1;
  } elseif (isset($_GET['katakunci']) && $_GET['katakunci'] == 'bukalapak' && $_GET['btsubmit']) {
    $kata_kunci = $_GET['katakunci'];
    $id_akun = 2;
  } elseif (isset($_GET['katakunci']) && $_GET['katakunci'] == 'tokopedia' && $_GET['btsubmit']) {
    $kata_kunci = $_GET['katakunci'];
    $id_akun = 3;
  } else {
    ?>
    <script type="text/javascript">
      alert("Maaf kata kunci yang anda masukkan salah");
    </script>
    <?php
    // header("Location: http://localhost/ansen-ecommerce/proses-crawling.php");
  }
  if ($kata_kunci != "" && $id_akun != null && $_GET['btsubmit'] == 'crawling') {
    $o_crawling->get_tweet($kata_kunci, $id_akun);
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
