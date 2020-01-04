<?php 
// function preprocessing($tabelc, $tabelt){
    // GLOBAL $conn;
require_once "../function/koneksi.php";
    // if($tabelc!='' && $tabelt!=''){
      $jumlah_row = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `".$tabelt."`"));
      $q_tweet = "SELECT * FROM `".$tabelc."`";
      $c_tweet = mysqli_query($conn, $q_tweet);
      $j = $jumlah_row+1;

      while ($row = mysqli_fetch_array($c_tweet)) {
        $id = $row['id_tes'];
        $tanggal = $row['tanggal'];
        $tweet = $row['tweet'];
        
        $id_crawling = trim($id);
        $p_tweet = case_folding($tweet);
        // echo "<br>";
        $p_tweet = cleansing($p_tweet);
        //echo "<br>";
        $p_tweet = convert_emoticon($p_tweet);
        //echo "<br>";
        // echo $p_tweet = convert_negation($p_tweet);
        // echo "<br>";
        $p_tweet = tokenizer($p_tweet);
        //echo "<br>";
        $p_tweet = normalization($p_tweet);
        //echo "<br>";
        $p_tweet = stopword_removal($p_tweet);
        //echo "<br>";
        $p_tweet = stemming($p_tweet);
        //echo "<br>";
        //sleep(0.1);
        if ($p_tweet!='') {
          $query = "INSERT INTO ".$tabelt." (id_tes, tweet, hasil_preprocessing, tanggal) VALUES ($j, '$tweet','$p_tweet','$tanggal')";
        }
        $hasil = mysqli_query($conn, $query);
        if ($hasil) {
          //echo "  <b style='color: blue'>Berhasil</b>";
          $data_tweet[$tweet]=$p_tweet;
          $j++;
        } else {
          //echo "  <b style='color: red'>Gagal</b>";
        }
        //echo "<hr>"; 

      // }
    // }

?>