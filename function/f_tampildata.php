<?php
require_once 'koneksi.php';
/**
 *
 */
class Data_testing extends Koneksi {
  public $sentimen_lazada_p = [];
  public $sentimen_lazada_n = [];
  public $sentimen_bukalapak_p = [];
  public $sentimen_bukalapak_n = [];
  public $sentimen_tokopedia_p = [];
  public $sentimen_tokopedia_n = [];

  public $jml_sentimen_lazada_p = 0;
  public $jml_sentimen_lazada_n = 0;
  public $jml_sentimen_bukalapak_p = 0;
  public $jml_sentimen_bukalapak_n = 0;
  public $jml_sentimen_tokopedia_p = 0;
  public $jml_sentimen_tokopedia_n = 0;
  public $jml_semua_sentimen = 0;


  public function set_data_testing() {
    // header("Content-type:application/json");
    for ($i=7; $i>=0 ; $i--) {
      $query_tanggal = $this->con->query("SELECT `tanggal` FROM `data_testing` ORDER BY `tanggal` DESC LIMIT 1");
      while ($row = $query_tanggal->fetch_array()) {
        $last_date = $row['tanggal'];
      }
      $tanggal_crawling = date('Y-m-d', strtotime('-'.$i.' days', strtotime( $last_date )));
      $tampil_tanggal_crawling = date('d M Y', strtotime('-'.$i.' days', strtotime( $last_date )));

      $query_positif1 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'P' AND `id_akun` = 1");
      $row_positif1 = $query_positif1->fetch_row();
      $jumlah_positif1 = $row_positif1[0];
      $query_negatif1 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'N' AND `id_akun` = 1");
      $row_negatif1 = $query_negatif1->fetch_row();
      $jumlah_negatif1 = $row_negatif1[0];

      $query_positif2 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'P' AND `id_akun` = 2");
      $row_positif2 = $query_positif2->fetch_row();
      $jumlah_positif2 = $row_positif2[0];
      $query_negatif2 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'N' AND `id_akun` = 2");
      $row_negatif2 = $query_negatif2->fetch_row();
      $jumlah_negatif2 = $row_negatif2[0];

      $query_positif3 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'P' AND `id_akun` = 3");
      $row_positif3 = $query_positif3->fetch_row();
      $jumlah_positif3 = $row_positif3[0];
      $query_negatif3 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'N' AND `id_akun` = 3");
      $row_negatif3 = $query_negatif3->fetch_row();
      $jumlah_negatif3 = $row_negatif3[0];

      $this->sentimen_lazada_p["$tampil_tanggal_crawling"] = $jumlah_positif1;
      $this->sentimen_lazada_n["$tampil_tanggal_crawling"] = $jumlah_negatif1;
      $this->sentimen_bukalapak_p["$tampil_tanggal_crawling"] = $jumlah_positif2;
      $this->sentimen_bukalapak_n["$tampil_tanggal_crawling"] = $jumlah_negatif2;
      $this->sentimen_tokopedia_p["$tampil_tanggal_crawling"] = $jumlah_positif3;
      $this->sentimen_tokopedia_n["$tampil_tanggal_crawling"] = $jumlah_negatif3;
    }
    // $data_sentimen = ['lazadaidPositif'=>$sentimen_lazada_p, 'lazadaidNegatif'=>$sentimen_lazada_n, 'bukalapakPositif'=>$sentimen_bukalapak_p, 'bukalapakNegatif'=>$sentimen_bukalapak_n, 'tokopediaPositif'=>$sentimen_tokopedia_p, 'tokopediaNegatif'=>$sentimen_tokopedia_n];
    // print_r($data_sentimen);
    // echo json_encode($data_sentimen, JSON_PRETTY_PRINT);
    // print_r($this->sentimen_lazada_p);echo "<br>";
    // print_r($this->sentimen_lazada_n);echo "<br>";
    // print_r($this->sentimen_bukalapak_p);echo "<br>";
    // print_r($this->sentimen_bukalapak_n);echo "<br>";
    // print_r($this->sentimen_tokopedia_p);echo "<br>";
    // print_r($this->sentimen_tokopedia_n);echo "<br>";
  }

  public function set_data_testing_pie() {

    foreach ($this->sentimen_lazada_p as $value) {
      $this->jml_sentimen_lazada_p += $value;
    }
    foreach ($this->sentimen_lazada_n as $value) {
      $this->jml_sentimen_lazada_n += $value;
    }
    foreach ($this->sentimen_bukalapak_p as $value) {
      $this->jml_sentimen_bukalapak_p += $value;
    }
    foreach ($this->sentimen_bukalapak_n as $value) {
      $this->jml_sentimen_bukalapak_n += $value;
    }
    foreach ($this->sentimen_tokopedia_p as $value) {
      $this->jml_sentimen_tokopedia_p += $value;
    }
    foreach ($this->sentimen_tokopedia_n as $value) {
      $this->jml_sentimen_tokopedia_n += $value;
    }
    $this->jml_semua_sentimen = $this->jml_sentimen_lazada_p+$this->jml_sentimen_lazada_n+$this->jml_sentimen_bukalapak_p+$this->jml_sentimen_bukalapak_n+$this->jml_sentimen_tokopedia_p+$this->jml_sentimen_tokopedia_n;
  }


  public function set_data_testing_bulan() {
    // header("Content-type:application/json");
    for ($i=30; $i>=0 ; $i--) {
      $query_tanggal = $this->con->query("SELECT `tanggal` FROM `data_testing` ORDER BY `tanggal` DESC LIMIT 1");
      while ($row = $query_tanggal->fetch_array()) {
        $last_date = $row['tanggal'];
      }
      $tanggal_crawling = date('Y-m-d', strtotime('-'.$i.' days', strtotime( $last_date )));
      $tampil_tanggal_crawling = date('d M Y', strtotime('-'.$i.' days', strtotime( $last_date )));
      
      $query_positif1 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'P' AND `id_akun` = 1");
      $row_positif1 = $query_positif1->fetch_row();
      $jumlah_positif1 = $row_positif1[0];
      $query_negatif1 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'N' AND `id_akun` = 1");
      $row_negatif1 = $query_negatif1->fetch_row();
      $jumlah_negatif1 = $row_negatif1[0];

      $query_positif2 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'P' AND `id_akun` = 2");
      $row_positif2 = $query_positif2->fetch_row();
      $jumlah_positif2 = $row_positif2[0];
      $query_negatif2 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'N' AND `id_akun` = 2");
      $row_negatif2 = $query_negatif2->fetch_row();
      $jumlah_negatif2 = $row_negatif2[0];

      $query_positif3 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'P' AND `id_akun` = 3");
      $row_positif3 = $query_positif3->fetch_row();
      $jumlah_positif3 = $row_positif3[0];
      $query_negatif3 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE `tanggal` = '".$tanggal_crawling."' AND `sentimen` = 'N' AND `id_akun` = 3");
      $row_negatif3 = $query_negatif3->fetch_row();
      $jumlah_negatif3 = $row_negatif3[0];

      $this->sentimen_lazada_p["$tampil_tanggal_crawling"] = $jumlah_positif1;
      $this->sentimen_lazada_n["$tampil_tanggal_crawling"] = $jumlah_negatif1;
      $this->sentimen_bukalapak_p["$tampil_tanggal_crawling"] = $jumlah_positif2;
      $this->sentimen_bukalapak_n["$tampil_tanggal_crawling"] = $jumlah_negatif2;
      $this->sentimen_tokopedia_p["$tampil_tanggal_crawling"] = $jumlah_positif3;
      $this->sentimen_tokopedia_n["$tampil_tanggal_crawling"] = $jumlah_negatif3;
    }
  }

  public function set_data_testing_6_bulan() {
    for ($i=5; $i>=0 ; $i--) {
      $query_tanggal = $this->con->query("SELECT `tanggal` FROM `data_testing` ORDER BY `tanggal` DESC LIMIT 1");
      while ($row = $query_tanggal->fetch_array()) {
        $last_date = $row['tanggal'];
      }
      $tanggal_crawling = date('Y-m-d', strtotime('-'.$i.' month', strtotime( $last_date )));
      $bulan_crawling = date('M Y', strtotime('-'.$i.' month', strtotime( $last_date )));

      $query_positif1 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'P' AND `id_akun` = 1");
      $row_positif1 = $query_positif1->fetch_row();
      $jumlah_positif1 = $row_positif1[0];
      $query_negatif1 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'N' AND `id_akun` = 1");
      $row_negatif1 = $query_negatif1->fetch_row();
      $jumlah_negatif1 = $row_negatif1[0];

      $query_positif2 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'P' AND `id_akun` = 2");
      $row_positif2 = $query_positif2->fetch_row();
      $jumlah_positif2 = $row_positif2[0];
      $query_negatif2 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'N' AND `id_akun` = 2");
      $row_negatif2 = $query_negatif2->fetch_row();
      $jumlah_negatif2 = $row_negatif2[0];

      $query_positif3 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'P' AND `id_akun` = 3");
      $row_positif3 = $query_positif3->fetch_row();
      $jumlah_positif3 = $row_positif3[0];
      $query_negatif3 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'N' AND `id_akun` = 3");
      $row_negatif3 = $query_negatif3->fetch_row();
      $jumlah_negatif3 = $row_negatif3[0];

      $this->sentimen_lazada_p["$bulan_crawling"] = $jumlah_positif1;
      $this->sentimen_lazada_n["$bulan_crawling"] = $jumlah_negatif1;
      $this->sentimen_bukalapak_p["$bulan_crawling"] = $jumlah_positif2;
      $this->sentimen_bukalapak_n["$bulan_crawling"] = $jumlah_negatif2;
      $this->sentimen_tokopedia_p["$bulan_crawling"] = $jumlah_positif3;
      $this->sentimen_tokopedia_n["$bulan_crawling"] = $jumlah_negatif3;
    }
  }

  public function set_data_testing_12_bulan() {
    for ($i=11; $i>=0 ; $i--) {
      $query_tanggal = $this->con->query("SELECT `tanggal` FROM `data_testing` ORDER BY `tanggal` DESC LIMIT 1");
      while ($row = $query_tanggal->fetch_array()) {
        $last_date = $row['tanggal'];
      }
      $tanggal_crawling = date('Y-m-d', strtotime('-'.$i.' month', strtotime( $last_date )));
      $bulan_crawling = date('M Y', strtotime('-'.$i.' month', strtotime( $last_date )));

      $query_positif1 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'P' AND `id_akun` = 1");
      $row_positif1 = $query_positif1->fetch_row();
      $jumlah_positif1 = $row_positif1[0];
      $query_negatif1 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'N' AND `id_akun` = 1");
      $row_negatif1 = $query_negatif1->fetch_row();
      $jumlah_negatif1 = $row_negatif1[0];

      $query_positif2 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'P' AND `id_akun` = 2");
      $row_positif2 = $query_positif2->fetch_row();
      $jumlah_positif2 = $row_positif2[0];
      $query_negatif2 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'N' AND `id_akun` = 2");
      $row_negatif2 = $query_negatif2->fetch_row();
      $jumlah_negatif2 = $row_negatif2[0];

      $query_positif3 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'P' AND `id_akun` = 3");
      $row_positif3 = $query_positif3->fetch_row();
      $jumlah_positif3 = $row_positif3[0];
      $query_negatif3 = $this->con->query("SELECT count(id_tes) FROM data_testing WHERE MONTH(`tanggal`) = MONTH('".$tanggal_crawling."') AND `sentimen` = 'N' AND `id_akun` = 3");
      $row_negatif3 = $query_negatif3->fetch_row();
      $jumlah_negatif3 = $row_negatif3[0];

      $this->sentimen_lazada_p["$bulan_crawling"] = $jumlah_positif1;
      $this->sentimen_lazada_n["$bulan_crawling"] = $jumlah_negatif1;
      $this->sentimen_bukalapak_p["$bulan_crawling"] = $jumlah_positif2;
      $this->sentimen_bukalapak_n["$bulan_crawling"] = $jumlah_negatif2;
      $this->sentimen_tokopedia_p["$bulan_crawling"] = $jumlah_positif3;
      $this->sentimen_tokopedia_n["$bulan_crawling"] = $jumlah_negatif3;
    }
  }
}

// $data = new Data_testing();
// $data->set_data_testing();
// $data->set_data_testing_pie();
// $data_lazada_p = $data->sentimen_lazada_p;
// $data_lazada_n = $data->sentimen_lazada_n;
// $data_bukalapak_p = $data->sentimen_bukalapak_p;
// $data_bukalapak_n = $data->sentimen_bukalapak_n;
// $data_tokopedia_p = $data->sentimen_tokopedia_p;
// $data_tokopedia_n = $data->sentimen_tokopedia_n;
//
// $tanggal = "[";
// foreach ($data_lazada_p as $key => $value) {
// 	$tanggal = $tanggal."\" ".$key."\",";
// }
// $tanggal = substr($tanggal, 0, -1);
// $tanggal = $tanggal." ]";
//
//
// $datalp = "[";
// foreach ($data_lazada_p as $keylp => $valuelp) {
// 	$datalp = $datalp." ".$valuelp.",";
// }
// $datalp = substr($datalp, 0, -1);
// $datalp = $datalp." ]";
//
// $dataln = "[";
// foreach ($data_lazada_n as $keyln => $valueln) {
// 	$dataln = $dataln." ".$valueln.",";
// }
// $dataln = substr($dataln, 0, -1);
// $dataln = $dataln." ]";
//
// $databp = "[";
// foreach ($data_bukalapak_p as $keybp => $valuebp) {
// 	$databp = $databp." ".$valuebp.",";
// }
// $databp = substr($databp, 0, -1);
// $databp = $databp." ]";
//
// $databn = "[";
// foreach ($data_bukalapak_n as $keybn => $valuebn) {
// 	$databn = $databn." ".$valuebn.",";
// }
// $databn = substr($databn, 0, -1);
// $databn = $databn." ]";
//
// $datatp = "[";
// foreach ($data_tokopedia_p as $keytp => $valuetp) {
// 	$datatp = $datatp." ".$valuetp.",";
// }
// $datatp = substr($datatp, 0, -1);
// $datatp = $datatp." ]";
//
// $datatn = "[";
// foreach ($data_tokopedia_n as $keytn => $valuetn) {
// 	$datatn = $datatn." ".$valuetn.",";
// }
// $datatn = substr($datatn, 0, -1);
// $datatn = $datatn." ]";
//
// $persenlp = round(($data->jml_sentimen_lazada_p/$data->jml_semua_sentimen)*100, 2)."  ";
// $persenln = round(($data->jml_sentimen_lazada_n/$data->jml_semua_sentimen)*100, 2)."  ";
// $persenbp = round(($data->jml_sentimen_bukalapak_p/$data->jml_semua_sentimen)*100, 2)."  ";
// $persenbn = round(($data->jml_sentimen_bukalapak_n/$data->jml_semua_sentimen)*100, 2)."  ";
// $persentp = round(($data->jml_sentimen_tokopedia_p/$data->jml_semua_sentimen)*100, 2)."  ";
// $persentn = round(($data->jml_sentimen_tokopedia_n/$data->jml_semua_sentimen)*100, 2)."  ";

?>
