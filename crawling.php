<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include_once 'function/f_crawlingtweet.php';
include_once 'function/f_preprocessing.php';
include_once 'function/f_naivebayes.php';
$o_koneksi = new Koneksi();
$o_crawling = new Crawling();
$o_preprocessing = new Preprocessing();
$o_naivebayes = new Naive_bayes();


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
  } elseif (isset($_GET['btsubmit'])) {

  } else {
    ?>
    <script type="text/javascript">
      alert("Maaf kata kunci yang anda masukkan salah");
    </script>
    <?php
    header("Location: http://localhost/ansen-ecommerce/");
  }
  if ($kata_kunci != "" && $id_akun != null && $_GET['btsubmit'] == 'crawindex') {
    $id_akun;
    $o_crawling->get_tweet($kata_kunci, $id_akun);
    $query = $o_koneksi->con->query("SELECT * FROM `data_testing` WHERE `sentimen` IS NULL");
    while ($row = $query->fetch_array()) {
      $id = $row['id_tes'];
      $tweet = $o_preprocessing->input($row['tweet']);
      list($prob_pos, $prob_neg, $sentimen) =  $o_naivebayes->klasifikasi_sentimen_testing($tweet);
      // $sentimen = $o_naivebayes->klasifikasi_sentimen_testing($tweet);
      $query_update = $o_koneksi->con->query("UPDATE `data_testing` SET `bobot_bayes_positif` = ".$prob_pos.", `bobot_bayes_negatif` = ".$prob_neg.", `sentimen` = '".$sentimen."'  WHERE `id_tes` = ".$id."");
      // $query_update = $o_koneksi->con->query("UPDATE `data_testing` SET `tweet_preprocessing` = '".$tweet."', `sentimen` = '".$sentimen."'  WHERE `id_tes` = ".$id."");
      // if ($query_update) {
      //   echo " berhasil";
      //   echo "<br>";
      // } else {
      //   echo mysqli_error($query_update);
      // }
    }
    header("Location: http://localhost/ansen-ecommerce/index.php");
  } else if ($kata_kunci != "" && $id_akun != null && $_GET['btsubmit'] == 'crawling') {
    $kata_kunci;
    $id_akun;
    $o_crawling->get_tweet($kata_kunci, $id_akun);
  } else if ($_GET['btsubmit'] == 'prepro'){
    $query = $o_koneksi->con->query("SELECT * FROM `data_testing` WHERE `tweet_preprocessing` IS NULL");
    while ($row = $query->fetch_array()) {
      $id = $row['id_tes'];
      $tweet = $o_preprocessing->input($row['tweet']);
      // $sentimen = $o_naivebayes->klasifikasi_sentimen_testing($tweet);
      $query_update = $o_koneksi->con->query("UPDATE `data_testing` SET `tweet_preprocessing` = '".$tweet."'  WHERE `id_tes` = ".$id."");
    }
  } else if ($_GET['btsubmit'] == 'bobot_bayes'){
    $query = $o_koneksi->con->query("SELECT * FROM `data_testing` WHERE `bobot_bayes_positif` IS NULL");
    while ($row = $query->fetch_array()) {
      $id = $row['id_tes'];
      $tweet = $row['tweet_preprocessing'];
      list($prob_pos, $prob_neg, $sentimen) =  $o_naivebayes->klasifikasi_sentimen_testing($tweet);
      $query_update = $o_koneksi->con->query("UPDATE `data_testing` SET `bobot_bayes_positif` = ".$prob_pos.", `bobot_bayes_negatif` = ".$prob_neg.", `sentimen` = '".$sentimen."'  WHERE `id_tes` = ".$id."");
    }
  }
}




// echo "<hr>";
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
// echo "Selesai dalam ".$total_time." detik";

?>
