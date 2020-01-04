<?php 

include_once "function/koneksi.php";

class Information_gain extends Koneksi{
  
  public function get_jumlah_tweet_positif() {
    $query = $this->con->query("SELECT count(id_training) FROM data_training WHERE sentimen = 'P'");
    $row = $query->fetch_row();
    $jumlah = $row['0'];
    return $jumlah;
  }

  public function get_jumlah_tweet_negatif() {
    $query = $this->con->query("SELECT count(id_training) FROM data_training WHERE sentimen = 'N'");
    $row = $query->fetch_row();
    $jumlah = $row['0'];
    return $jumlah;
  }

  public function get_jumlah_tweet_total() {
    $query = $this->con->query("SELECT count(id_training) FROM data_training");
    $row = $query->fetch_row();
    $jumlah = $row['0'];
    return $jumlah;
  }

  public function set_jumlah_kata_ya_p() {
    $jml_kata = [];
    $query_kata = $this->con->query("SELECT `kata` FROM data_training_kata ORDER BY `id_kata`");
    while ($row_kata = $query_kata->fetch_array()) {
      $i = 0;
      $kata = $row_kata['kata'];
      $query_dokumen = $this->con->query("SELECT `tweet_preprocessing`,`sentimen` FROM data_training WHERE `sentimen` = 'P' ORDER BY `id_training` ASC");
      while ($row_dokumen = $query_dokumen->fetch_array()) {
        $kata_dok = explode(' ', $row_dokumen['tweet_preprocessing']);
        foreach ($kata_dok as $key) {
          if ($kata == $key) {
            $i+=1;
            break;
          }
        }
      }
      $jml_kata[$kata] = $i;
    }
    foreach ($jml_kata as $kata => $bobot) {
      $query_simpan = $this->con->query("UPDATE data_training_kata SET `jumlah_ya_positif` = ".$bobot." WHERE `kata` = '".$kata."'");
      if ($query_simpan) {
        echo "$kata berhasil";
        echo "<br>";
      } else {
        echo $this->con->error;
        die();
      }
    }
  }

  public function set_jumlah_kata_ya_n() {
    $jml_kata = [];
    $query_kata = $this->con->query("SELECT `kata` FROM data_training_kata ORDER BY `id_kata`");
    while ($row_kata = $query_kata->fetch_array()) {
      $i = 0;
      $kata = $row_kata['kata'];
      $query_dokumen = $this->con->query("SELECT `tweet_preprocessing`,`sentimen` FROM data_training WHERE `sentimen` = 'N' ORDER BY `id_training` ASC");
      while ($row_dokumen = $query_dokumen->fetch_array()) {
        $kata_dok = explode(' ', $row_dokumen['tweet_preprocessing']);
        foreach ($kata_dok as $key) {
          if ($kata == $key) {
            $i+=1;
            break;
          }
        }
      }
      $jml_kata[$kata] = $i;
    }
    foreach ($jml_kata as $kata => $bobot) {
      $query_simpan = $this->con->query("UPDATE data_training_kata SET `jumlah_ya_negatif` = ".$bobot." WHERE `kata` = '".$kata."'");
      if ($query_simpan) {
        echo "$kata berhasil";
        echo "<br>";
      } else {
        echo $this->con->error;
        die();
      }
    }
  }

  public function set_jumlah_kata_tidak_p() {
    $jumlah_positif = $this->get_jumlah_tweet_positif();
    $query_tidak = $this->con->query("SELECT `id_kata`,`jumlah_ya_positif` FROM data_training_kata");
    while ($row = $query_tidak->fetch_array()) {
      $jumlah_kata_tidak_p = $jumlah_positif - $row['jumlah_ya_positif'];
      $query = $this->con->query("UPDATE `data_training_kata` SET `jumlah_tidak_positif` = ".$jumlah_kata_tidak_p." WHERE `id_kata` = ".$row['id_kata']."");
      if ($query) {
        echo $row['id_kata']." oke";
        echo "<br>";
      }
    }
  }

  public function set_jumlah_kata_tidak_n() {
    $jumlah_negatif = $this->get_jumlah_tweet_negatif();
    $query_tidak = $this->con->query("SELECT `id_kata`,`jumlah_ya_negatif` FROM data_training_kata");
    while ($row = $query_tidak->fetch_array()) {
      $jumlah_kata_tidak_n = $jumlah_negatif - $row['jumlah_ya_negatif'];
      $query = $this->con->query("UPDATE `data_training_kata` SET `jumlah_tidak_negatif` = ".$jumlah_kata_tidak_n." WHERE `id_kata` = ".$row['id_kata']."");
      if ($query) {
        echo $row['id_kata']." oke";
        echo "<br>";
      }
    }
  }

  public function set_jumlah_semuakata_ya() {
    $query_ya = $this->con->query("SELECT `id_kata`,`jumlah_ya_positif`, `jumlah_ya_negatif`  FROM `data_training_kata`");
    while ($row = $query_ya->fetch_array()) {
      $jumlah_ya = $row['jumlah_ya_positif'] + $row['jumlah_ya_negatif'];
      $query = $this->con->query("UPDATE `data_training_kata` SET `jumlah_semua_ya` = ".$jumlah_ya." WHERE `id_kata` = ".$row['id_kata']."");
      if ($query) {
        echo $row['id_kata']." berhasil";
        echo "<br>";
      }
    }
  }

  public function set_jumlah_semuakata_tidak() {
    $query_tidak = $this->con->query("SELECT `id_kata`,`jumlah_tidak_positif`, `jumlah_tidak_negatif` FROM `data_training_kata`");
    while ($row = $query_tidak->fetch_array()) {
      $jumlah_tidak = $row['jumlah_tidak_positif'] + $row['jumlah_tidak_negatif'];
      $query = $this->con->query("UPDATE `data_training_kata` SET `jumlah_semua_tidak` = ".$jumlah_tidak." WHERE `id_kata` = ".$row['id_kata']."");
      if ($query) {
        echo $row['id_kata']." berhasil";
        echo "<br>";
      } else {
        die($this->con->error());
      }
    }
  }


  public function entropy_set() {
    $jml_p = $this->get_jumlah_tweet_positif();
    $jml_n = $this->get_jumlah_tweet_negatif();
    $jml_t = $this->get_jumlah_tweet_total();
    $entropy_set = round((-((($jml_p/$jml_t)*log($jml_p/$jml_t,2))+($jml_n/$jml_t)*log($jml_n/$jml_t,2))),4);
    return $entropy_set;
  }

  public function set_entropy_kata_ya() {
    $query_ya = $this->con->query("SELECT `id_kata`, `jumlah_ya_positif`, `jumlah_ya_negatif`, `jumlah_semua_ya` FROM data_training_kata");
    while ($row = $query_ya->fetch_array()) {
      $jml_p = $row['jumlah_ya_positif'];
      $jml_n = $row['jumlah_ya_negatif'];
      $jml_t = $row['jumlah_semua_ya'];
      $entropy_set = round((-((($jml_p/$jml_t)*log($jml_p/$jml_t,2))+($jml_n/$jml_t)*log($jml_n/$jml_t,2))),6);
      if (is_nan($entropy_set)) {
        $entropy_set = 0;
      }

      $query_entropy = $this->con->query("UPDATE `data_training_kata` SET `entropy_ya` = ".$entropy_set." WHERE `id_kata` = ".$row['id_kata']."");
      if ($query_entropy) {
        echo $entropy_set;
        echo "  berhasil";
        echo "<br>";
      }
    }
    
  }

  public function set_entropy_kata_tidak() {
  	$query_ya = $this->con->query("SELECT `id_kata`, `jumlah_tidak_positif`, `jumlah_tidak_negatif`, `jumlah_semua_tidak` FROM data_training_kata");
    while ($row = $query_ya->fetch_array()) {
      $jml_p = $row['jumlah_tidak_positif'];
      $jml_n = $row['jumlah_tidak_negatif'];
      $jml_t = $row['jumlah_semua_tidak'];
      $entropy_set = round((-((($jml_p/$jml_t)*log($jml_p/$jml_t,2))+($jml_n/$jml_t)*log($jml_n/$jml_t,2))),6);
      if (is_nan($entropy_set)) {
        $entropy_set = 0;
      }

      $query_entropy = $this->con->query("UPDATE `data_training_kata` SET `entropy_tidak` = ".$entropy_set." WHERE `id_kata` = ".$row['id_kata']."");
      if ($query_entropy) {
        echo $entropy_set;
        echo "  berhasil";
        echo "<br>";
      }
    }
  }

  public function entropy_kata() {
  	$query = $this->con->query("SELECT `id_kata`, `jumlah_semua_ya`, `jumlah_semua_tidak`, `entropy_ya`, `entropy_tidak` FROM data_training_kata ORDER BY `id_kata`");
    while ($row = $query->fetch_array()) {
      $jml_ya       = $row['jumlah_semua_ya'];
      $jml_tidak    = $row['jumlah_semua_tidak'];
      $entropy_ya   = $row['entropy_ya'];
      $entropy_tidak= $row['entropy_tidak'];
      $jml_ya_tidak = $jml_ya + $jml_tidak;
      $entropy_kata = round((($jml_ya/$jml_ya_tidak)*$entropy_ya)+(($jml_tidak/$jml_ya_tidak)*$entropy_tidak), 9);
      $query_simpan = $this->con->query("UPDATE `data_training_kata` SET `entropy_kata` = ".$entropy_kata." WHERE `id_kata` = ".$row['id_kata']."");
      if ($query_simpan) {
        echo $row['id_kata']." ";
        echo $entropy_kata;
        echo "<br>";
      }
    }
  }

  public function set_info_gain() {
    $entropy_set = $this->entropy_set();
    $query = $this->con->query("SELECT `id_kata`, `entropy_kata` FROM `data_training_kata` ORDER BY `id_kata` ASC");
    while ($row = $query->fetch_array()) {
      $ig = round($entropy_set - $row['entropy_kata'],9);
      $query_simpan = $this->con->query("UPDATE `data_training_kata` SET `bobot_ig` = ".$ig." WHERE `id_kata` = ".$row['id_kata']."");
      if ($query_simpan) {
        echo $row['id_kata']." ";
        echo $ig;
        echo "<br>";
      }
    }
  }

  public function prepro_info_gain($batas_ambang_ig) {
    $query_dok= $this->con->query("SELECT `id_testing`, `tweet_preprocessing` FROM data_training_tes ORDER BY `id_testing` ASC");
    while ($row_dok = $query_dok->fetch_array()) {
      $dokumen_tweet = [];
      $kata_dok = explode(' ', $row_dok['tweet_preprocessing']);
      foreach ($kata_dok as $kata_d) {
        $query_kata = $this->con->query("SELECT `id_kata`, `kata` FROM `data_training_kata` ORDER BY `bobot_ig` DESC LIMIT ".$batas_ambang_ig."");
        while ($kata = $query_kata->fetch_array()) {
          if ($kata_d == $kata['kata']) {
            array_push($dokumen_tweet, $kata_d);
          }
        }
      }
      $dokumen_hasil = implode(' ', $dokumen_tweet);
      $query_simpan = $this->con->query("UPDATE `data_training_tes` SET `tweet_preprocessing_ig` = '".$dokumen_hasil."' WHERE `id_testing` = ".$row_dok['id_testing']."");
      if ($query_simpan) {
        echo $dokumen_hasil;
        echo " berhasil";
        echo "<br>";
      }
    }
  }

}

?>