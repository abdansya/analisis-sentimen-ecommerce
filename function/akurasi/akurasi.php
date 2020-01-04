<?php
include_once '../koneksi.php';

class Akurasi extends Koneksi {
  
  public function cek_akurasi()	{
    $jumlah_sama = 0;
    $jumlah_tidak_sama = 0;
    $query_testing  = $this->con->query("SELECT `id_testing`, `sentimen_ig` FROM `data_training_tes` ORDER BY `id_testing`");
    while ($row_tes = $query_testing->fetch_array()) {
      $query_training = $this->con->query("SELECT count(id_training) FROM `data_training` WHERE `id_training` = ".$row_tes['id_testing']." AND `sentimen` = '".$row_tes['sentimen_ig']."' ORDER BY `id_training`");
      $row_train = $query_training->fetch_row();
      if ($row_train[0] == 1) {
        $jumlah_sama += 1;
      } else {
        $jumlah_tidak_sama += 1;
      }
    }
    $akurasi = round($jumlah_sama/($jumlah_sama+$jumlah_tidak_sama),2);
    echo "Jumlah sama : ".$jumlah_sama;
    echo "<br>";
    echo "Jumlah tidak sama : ".$jumlah_tidak_sama;
    echo "<br>";
    echo "Akurasi : ".$akurasi;
  }
}

?>
