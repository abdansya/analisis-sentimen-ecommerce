<?php
require_once 'function/koneksi_procedural.php';
require_once 'function/f_preprocessing.php';
require_once 'function/vendor/autoload.php';

$data_tweet = [];
if (isset($_GET['btsubmit']) && $_GET['btsubmit'] == 'prepro') {
  $query = "SELECT id_training, tweet FROM data_training ORDER BY `id_training`";
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_array($result)) {
    $id_tweet = trim($row['id_training']);
    $p_tweet = $row['tweet'];
    // $p_tweet = "mana blm sampai juga barangnya :( mana pesanan org barangnya :( ";
    $p_tweet = convert_emoticon($p_tweet);
    $p_tweet = case_folding($p_tweet);
    $p_tweet = cleansing($p_tweet);
    $p_tweet = convert_negation($p_tweet);
    $p_tweet = tokenizer($p_tweet);
    $p_tweet = normalization($p_tweet);
    $p_tweet = stemming($p_tweet);
    $p_tweet = stopword_removal($p_tweet);
    $p_tweet = trimed($p_tweet);
    //sleep(0.2);
    echo $query_simpan = "UPDATE `data_training` SET `tweet_preprocessing` = '".$p_tweet."' WHERE `id_training` = $id_tweet";
    $hasil = mysqli_query($con, $query_simpan);
    if ($hasil) {
      // echo "  <b style='color: blue'> Berhasil</b>";
    } else {
      // echo "  <b style='color: red'> Gagal</b>";
    }
  }
}

function data_training() {
	GLOBAL $con;
	$query = "SELECT * FROM `data_training`";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}

?>
