<?php
include_once 'koneksi.php';
/**
* Class Naive Bayes
*/
class Naive_bayes extends Koneksi {

	public function get_jml_kata_positif() {
		$i = 0;
		$query = $this->con->query("SELECT `id_training`, `tweet_preprocessing` FROM `data_training` WHERE `sentimen` = 'P'");
		while ($row = $query->fetch_array()) {
			$kata = $row['tweet_preprocessing'];
			$kata = explode(' ', $kata);
			foreach ($kata as $key) {
				$i += 1;
			}
		}
		return $i;
	}

	public function get_jml_kata_negatif() {
		$i = 0;
		$query = $this->con->query("SELECT `id_training`, `tweet_preprocessing` FROM `data_training` WHERE `sentimen` = 'N'");
		while ($row = $query->fetch_array()) {
			$kata = $row['tweet_preprocessing'];
			$kata = explode(' ', $kata);
			foreach ($kata as $key) {
				$i += 1;
			}
		}
		return $i;
	}

	public function get_jml_semua_kata_unik()	{
		$query = $this->con->query("SELECT count(id_kata) FROM data_training_kata");
    $row = $query->fetch_row();
    $jumlah = $row['0'];
    return $jumlah;
	}

	public function set_probabilitas_kata_positif() {
		$query = $this->con->query("SELECT `id_kata`, `kata` FROM `data_training_kata` ORDER BY `id_kata` ASC");
		while ($row_kata = $query->fetch_array()) {
			$ni = 0;
			$n = $this->get_jml_kata_positif();
			$kosakata = $this->get_jml_semua_kata_unik();

			$query_dokumen = $this->con->query("SELECT `id_training`, `tweet_preprocessing` FROM `data_training` WHERE `sentimen` = 'P' ORDER BY `id_training` ASC");
			while ($row_dok = $query_dokumen->fetch_array()) {
				$kata_dok = explode(' ',$row_dok['tweet_preprocessing']);
				foreach ($kata_dok as $key) {
					if ($row_kata['kata'] == $key) {
						$ni += 1;
					}
				}
			}

			$probabilitas_p = round(($ni+1)/($n+$kosakata),17);
			$query_simpan = $this->con->query("UPDATE `data_training_kata` SET `bobot_bayes_positif` = ".$probabilitas_p." WHERE `id_kata` = ".$row_kata['id_kata']."");
			if ($query_simpan) {
				echo $row_kata['id_kata']." => ";
				echo $probabilitas_p;
				echo " sukses";
				echo "<br>";
			}
		}
	}

	public function set_probabilitas_kata_negatif() {
		$query = $this->con->query("SELECT `id_kata`, `kata` FROM `data_training_kata` ORDER BY `id_kata` ASC");
		while ($row_kata = $query->fetch_array()) {
			$ni = 0;
			$n = $this->get_jml_kata_negatif();
			$kosakata = $this->get_jml_semua_kata_unik();

			$query_dokumen = $this->con->query("SELECT `id_training`, `tweet_preprocessing` FROM `data_training` WHERE `sentimen` = 'N' ORDER BY `id_training` ASC");
			while ($row_dok = $query_dokumen->fetch_array()) {
				$kata_dok = explode(' ',$row_dok['tweet_preprocessing']);
				foreach ($kata_dok as $key) {
					if ($row_kata['kata'] == $key) {
						$ni += 1;
					}
				}
			}

			$probabilitas_p = round(($ni+1)/($n+$kosakata),17);
			$query_simpan = $this->con->query("UPDATE `data_training_kata` SET `bobot_bayes_negatif` = ".$probabilitas_p." WHERE `id_kata` = ".$row_kata['id_kata']."");
			if ($query_simpan) {
				echo $row_kata['id_kata']." => ";
				echo $probabilitas_p;
				echo " sukses";
				echo "<br>";
			}
		}
	}

	public function get_probabilitas_kategori_positif() {
		$query = $this->con->query("SELECT count(id_training) FROM `data_training` WHERE `sentimen` = 'P'");
		$row = $query->fetch_row();
		$jumlah_p = $row[0];
		$query_semua = $this->con->query("SELECT count(id_training) FROM `data_training`");
		$row_semua = $query_semua->fetch_row();
		$jumlah_semua = $row_semua[0];
		return $probabilitas_kategori_p = $jumlah_p/$jumlah_semua;
	}

	public function get_probabilitas_kategori_negatif() {
		$query = $this->con->query("SELECT count(id_training) FROM `data_training` WHERE `sentimen` = 'N'");
		$row = $query->fetch_row();
		$jumlah_n = $row[0];
		$query_semua = $this->con->query("SELECT count(id_training) FROM `data_training`");
		$row_semua = $query_semua->fetch_row();
		$jumlah_semua = $row_semua[0];
		return $probabilitas_kategori_n = $jumlah_n/$jumlah_semua;
	}


	public function klasifikasi_sentimen() {
		$query_dok = $this->con->query("SELECT `id_training`, `tweet_preprocessing` FROM data_training_tes ORDER BY `id_training`");
		while ($row_dok = $query_dok->fetch_array()) {
			$prob_kata_positif = [];
			$prob_kata_negatif = [];
			$kata_dok = $row_dok['tweet_preprocessing'];
			$kata_hasil = explode(' ', $kata_dok);
			foreach ($kata_hasil as $key) {
				$query_bobot_kata = $this->con->query("SELECT `id_kata`, `kata`, `bobot_bayes_positif`, `bobot_bayes_negatif` FROM `data_training_kata` WHERE `kata` = '".$key."'");
				while ($row_kata = $query_bobot_kata->fetch_array()) {
					// echo $row_kata['kata']." ";
					if ($key == $row_kata['kata']) {
						$prob_kata_positif[$key] = round($row_kata['bobot_bayes_positif'], 8);
						$prob_kata_negatif[$key] = round($row_kata['bobot_bayes_negatif'], 8);
					} else {
						$prob_kata_positif[$key] = 1;
						$prob_kata_negatif[$key] = 1;
					}
				}
			}

			$prob_dokumen_positif = $this->get_probabilitas_kategori_positif();
			foreach ($prob_kata_positif as $kata_prob => $value) {
				$prob_dokumen_positif *= $value;
			}

			$prob_dokumen_negatif = $this->get_probabilitas_kategori_negatif();
			foreach ($prob_kata_negatif as $kata_prob => $value) {
				$prob_dokumen_negatif *= $value;
			}

			if ($prob_dokumen_positif > $prob_dokumen_negatif) {
				$sentimen = "P";
			} else if ($prob_dokumen_positif < $prob_dokumen_negatif) {
				$sentimen = "N";
			} else {
				$sentimen = "Tidak ada";
			}

			$query_simpan = $this->con->query("UPDATE `data_training_tes` SET `sentimen` = '".$sentimen."' WHERE `id_training` = ".$row_dok['id_training']."");
			if ($query_simpan) {
				// echo $row_dok['tweet_preprocessing'];
				// echo " Berhasil";
				// echo "<hr>";
			} else {
				// echo $row_dok['tweet_preprocessing'];
				// echo " Gagal";
				// echo "<hr>";
			}

			// echo $row_dok['tweet_preprocessing'];
			// echo "<br>";
			// print_r($prob_kata_positif);
			// echo "<br>";
			// print_r($prob_kata_negatif);
			// echo "<br>";
			// echo "Prob psoitif = ".$this->get_probabilitas_kategori_positif();
			// echo "<br>";
			// echo "Prob negatif = ".$this->get_probabilitas_kategori_negatif();
			// echo "<br>";
			// echo "probabilitas tweet positif = ".$prob_dokumen_positif;
			// echo "<br>";
			// echo "probabilitas tweet negatif = ".$prob_dokumen_negatif;
			// echo "<br>";
			// echo "Kategori : ".$sentimen;
			// echo "<hr>";


		}
	}


	public function klasifikasi_sentimen_ig($batas_ambang_ig) {
		echo "Threshold = ".$batas_ambang_ig;
		echo "<br><br>";
		$this->con->query("UPDATE `data_training_tes` SET `sentimen_ig` = ''");
		$query_dok = $this->con->query("SELECT `id_training`, `tweet_preprocessing` FROM data_training_tes ORDER BY `id_training`");
		while ($row_dok = $query_dok->fetch_array()) {
			$prob_kata_positif = [];
			$prob_kata_negatif = [];
			$kata_dok = $row_dok['tweet_preprocessing'];
			$kata_hasil = explode(' ', $kata_dok);
			foreach ($kata_hasil as $key) {
				$prob_kata_positif[$key] = 1;
				$prob_kata_negatif[$key] = 1;
				$query_bobot_kata = $this->con->query("SELECT `id_kata`, `kata`, `bobot_bayes_positif`, `bobot_bayes_negatif` FROM `data_training_kata` ORDER BY `bobot_ig` DESC LIMIT ".$batas_ambang_ig."");
				while ($row_kata = $query_bobot_kata->fetch_array()) {
					if ($key == $row_kata['kata']) {
						$prob_kata_positif[$key] = round($row_kata['bobot_bayes_positif'], 8);
						$prob_kata_negatif[$key] = round($row_kata['bobot_bayes_negatif'], 8);
					}
				}
			}

			$prob_dokumen_positif = $this->get_probabilitas_kategori_positif();
			foreach ($prob_kata_positif as $kata_prob => $value) {
				$prob_dokumen_positif *= $value;
			}

			$prob_dokumen_negatif = $this->get_probabilitas_kategori_negatif();
			foreach ($prob_kata_negatif as $kata_prob => $value) {
				$prob_dokumen_negatif *= $value;
			}

			if ($prob_dokumen_positif > $prob_dokumen_negatif) {
				$sentimen = "P";
			} else if ($prob_dokumen_positif < $prob_dokumen_negatif) {
				$sentimen = "N";
			} else {
				$sentimen = "Tidak ada";
			}

			$query_simpan = $this->con->query("UPDATE `data_training_tes` SET `sentimen_ig` = '".$sentimen."' WHERE `id_training` = ".$row_dok['id_training']."");
			if ($query_simpan) {
				echo $row_dok['tweet_preprocessing'];
				echo " Berhasil";
				echo "<hr>";
			} else {
				echo $row_dok['tweet_preprocessing'];
				echo " Gagal";
				echo "string";
			}

			// echo $row_dok['tweet_preprocessing'];
			// echo "<br>";
			// print_r($prob_kata_positif);
			// echo "<br>";
			// print_r($prob_kata_negatif);
			// echo "<br>";
			// echo "Prob psoitif = ".$this->get_probabilitas_kategori_positif();
			// echo "<br>";
			// echo "Prob negatif = ".$this->get_probabilitas_kategori_negatif();
			// echo "<br>";
			// echo "probabilitas tweet positif = ".$prob_dokumen_positif;
			// echo "<br>";
			// echo "probabilitas tweet negatif = ".$prob_dokumen_negatif;
			// echo "<br>";
			// echo "Kategori : ".$sentimen;
			// echo "<hr>";


		}
	}

	public function klasifikasi_sentimen_testing($tweet) {

		$prob_kata_positif = [];
		$prob_kata_negatif = [];
		$kata_hasil = explode(' ', $tweet);
		foreach ($kata_hasil as $key) {
			$query_bobot_kata = $this->con->query("SELECT `id_kata`, `kata`, `bobot_bayes_positif`, `bobot_bayes_negatif` FROM `data_training_kata` WHERE `kata` = '".$key."'");
			while ($row_kata = $query_bobot_kata->fetch_array()) {
				// echo $row_kata['kata']." ";
				if ($key == $row_kata['kata']) {
					$prob_kata_positif[$key] = round($row_kata['bobot_bayes_positif'], 8);
					$prob_kata_negatif[$key] = round($row_kata['bobot_bayes_negatif'], 8);
				} else {
					$prob_kata_positif[$key] = 1;
					$prob_kata_negatif[$key] = 1;
				}
			}
		}

		$prob_dokumen_positif = $this->get_probabilitas_kategori_positif();
		foreach ($prob_kata_positif as $kata_prob => $value) {
			$prob_dokumen_positif *= $value;
		}

		$prob_dokumen_negatif = $this->get_probabilitas_kategori_negatif();
		foreach ($prob_kata_negatif as $kata_prob => $value) {
			$prob_dokumen_negatif *= $value;
		}

		if ($prob_dokumen_positif > $prob_dokumen_negatif) {
			$sentimen = "P";
		} else if ($prob_dokumen_positif < $prob_dokumen_negatif) {
			$sentimen = "N";
		} else {
			$sentimen = "F";
		}

		return array($prob_dokumen_positif, $prob_dokumen_negatif, $sentimen);
		// echo $row_dok['tweet_preprocessing'];
		// echo "<br>";
		// print_r($prob_kata_positif);
		// echo "<br>";
		// print_r($prob_kata_negatif);
		// echo "<br>";
		// echo "Prob psoitif = ".$this->get_probabilitas_kategori_positif();
		// echo "<br>";
		// echo "Prob negatif = ".$this->get_probabilitas_kategori_negatif();
		// echo "<br>";
		// echo "probabilitas tweet positif = ".$prob_dokumen_positif;
		// echo "<br>";
		// echo "probabilitas tweet negatif = ".$prob_dokumen_negatif;
		// echo "<br>";
		// echo "Kategori : ".$sentimen;
		// echo "<hr>";
	}



	// public function akurasi()	{
	// 	$jumlah_sama = 0;
	// 	$jumlah_tidak_sama = 0;
	// 	$query_testing  = $this->con->query("SELECT `id_testing`, `sentimen_ig` FROM `data_training_tes` ORDER BY `id_testing`");
	// 	while ($row_tes = $query_testing->fetch_array()) {
	// 		$query_training = $this->con->query("SELECT count(id_training) FROM `data_training` WHERE `id_training` = ".$row_tes['id_testing']." AND `sentimen` = '".$row_tes['sentimen_ig']."' ORDER BY `id_training`");
	// 		$row_train = $query_training->fetch_row();
	// 		if ($row_train[0] == 1) {
	// 			$jumlah_sama += 1;
	// 		} else {
	// 			$jumlah_tidak_sama += 1;
	// 		}
	// 	}
	// 	$akurasi = round($jumlah_sama/($jumlah_sama+$jumlah_tidak_sama),2);
	// 	echo "Jumlah sama : ".$jumlah_sama;
	// 	echo "<br>";
	// 	echo "Jumlah tidak sama : ".$jumlah_tidak_sama;
	// 	echo "<br>";
	// 	echo "Akurasi : ".$akurasi;
	// }

	public function akurasi($threshold, $time)	{
		$true_positif = 0;
		$true_negatif = 0;
		$false_positif = 0;
		$false_negatif = 0;
		$query_testing_p  = $this->con->query("SELECT `id_training`, `sentimen_ig` FROM `data_training_tes` WHERE `sentimen_ig` = 'P' ORDER BY `id_training`");
		while ($row_tes_p = $query_testing_p->fetch_array()) {
			$query_training_p = $this->con->query("SELECT count(`id_training`) FROM `data_training` WHERE `id_training` = ".$row_tes_p['id_training']." AND `sentimen` = '".$row_tes_p['sentimen_ig']."' ORDER BY `id_training`");
			$row_train_p = $query_training_p->fetch_row();
			if ($row_train_p[0] == 1) {
				$true_positif += 1;
			} elseif ($row_train_p[0] == 0) {
				$false_positif += 1;
			}
		}
		$query_testing_n  = $this->con->query("SELECT `id_training`, `sentimen_ig` FROM `data_training_tes` WHERE `sentimen_ig` = 'N' ORDER BY `id_training`");
		while ($row_tes_n = $query_testing_n->fetch_array()) {
			$query_training_n = $this->con->query("SELECT count(id_training) FROM `data_training` WHERE `id_training` = ".$row_tes_n['id_training']." AND `sentimen` = '".$row_tes_n['sentimen_ig']."' AND `sentimen` = 'N' ORDER BY `id_training`");
			$row_train_n = $query_training_n->fetch_row();
			if ($row_train_n[0] == 1) {
				$true_negatif += 1;
			} elseif ($row_train_n[0] == 0){
				$false_negatif += 1;
			}
		}
		$akurasi = round((($true_positif+$true_negatif)/($true_positif+$true_negatif+$false_positif+$false_negatif)),4)*100;
		echo "True Positif : ".$true_positif;
		echo "<br>";
		echo "True Negatif : ".$true_negatif;
		echo "<br>";
		echo "False Positif : ".$false_positif;
		echo "<br>";
		echo "False Negatif : ".$false_negatif;
		echo "<br>";
		echo "Akurasi : ".$akurasi;
		$query_simpan = $this->con->query("INSERT INTO `data_akurasi` (`threshold`, `true_positif`, `true_negatif`, `false_positif`, `false_negatif`, `akurasi`, `waktu`) VALUES ($threshold, $true_positif, $true_negatif, $false_positif, $false_negatif, $akurasi, $time)");
	}


}

?>
