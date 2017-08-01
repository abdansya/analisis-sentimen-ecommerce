<?php
include_once 'koneksi.php';
/**
* Class Naive Bayes
*/
class Naive_bayes extends Koneksi {

	public function get_jml_kata_positif() {
		$i = 0;
		$query = $this->con->query("SELECT * FROM `data_training_tes` WHERE `sentimen` = 'P'");
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
		$query = $this->con->query("SELECT * FROM `data_training_tes` WHERE `sentimen` = 'N'");
		while ($row = $query->fetch_array()) {
			$kata = $row['tweet_preprocessing_ig'];
			$kata = explode(' ', $kata);
			foreach ($kata as $key) {
				$i += 1;
			}
		}
		return $i;
	}

	public function get_jml_semua_kata_unik()	{
		$query = $this->con->query("SELECT count(id_kata) FROM data_training_kata_ig");
    $row = $query->fetch_row();
    $jumlah = $row['0'];
    return $jumlah;
	}

	public function set_probabilitas_kata_positif() {
		$query = $this->con->query("SELECT `id_kata`, `kata` FROM `data_training_kata_ig` ORDER BY `id_kata` ASC");
		while ($row_kata = $query->fetch_array()) {
			$ni = 0;
			$n = $this->get_jml_kata_positif();
			$kosakata = $this->get_jml_semua_kata_unik();

			$query_dokumen = $this->con->query("SELECT `id_testing`, `tweet_preprocessing_ig` FROM `data_training_tes` WHERE `sentimen` = 'P' ORDER BY `id_testing` ASC");
			while ($row_dok = $query_dokumen->fetch_array()) {
				$kata_dok = explode(' ',$row_dok['tweet_preprocessing_ig']);
				foreach ($kata_dok as $key) {
					if ($row_kata['kata'] == $key) {
						$ni += 1;
					}
				}
			}

			$probabilitas_p = round(($ni+1)/($n+$kosakata),17);
			$query_simpan = $this->con->query("UPDATE `data_training_kata_ig` SET `bobot_bayes_positif` = ".$probabilitas_p." WHERE `id_kata` = ".$row_kata['id_kata']."");
			if ($query_simpan) {
				echo $row_kata['id_kata']." => ";
				echo $probabilitas_p;
				echo " sukses";
				echo "<br>";
			}
		}
	}

	public function set_probabilitas_kata_negatif() {
		$query = $this->con->query("SELECT `id_kata`, `kata` FROM `data_training_kata_ig` ORDER BY `id_kata` ASC");
		while ($row_kata = $query->fetch_array()) {
			$ni = 0;
			$n = $this->get_jml_kata_negatif();
			$kosakata = $this->get_jml_semua_kata_unik();

			$query_dokumen = $this->con->query("SELECT `id_testing`, `tweet_preprocessing_ig` FROM `data_training_tes` WHERE `sentimen` = 'N' ORDER BY `id_testing` ASC");
			while ($row_dok = $query_dokumen->fetch_array()) {
				$kata_dok = explode(' ',$row_dok['tweet_preprocessing_ig']);
				foreach ($kata_dok as $key) {
					if ($row_kata['kata'] == $key) {
						$ni += 1;
					}
				}
			}

			$probabilitas_p = round(($ni+1)/($n+$kosakata),17);
			$query_simpan = $this->con->query("UPDATE `data_training_kata_ig` SET `bobot_bayes_negatif` = ".$probabilitas_p." WHERE `id_kata` = ".$row_kata['id_kata']."");
			if ($query_simpan) {
				echo $row_kata['id_kata']." => ";
				echo $probabilitas_p;
				echo " sukses";
				echo "<br>";
			}
		}
	}

	public function get_probabilitas_kategori_positf() {
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
		$query_dok = $this->con->query("SELECT `id_testing`, `tweet_preprocessing` FROM data_training_tes ORDER BY `id_testing`");
		while ($row_dok = $query_dok->fetch_array()) {
			$prob_kata_positif = [];
			$prob_kata_negatif = [];
			$kata_dok = $row_dok['tweet_preprocessing'];
			$kata_hasil = explode(' ', $kata_dok);
			foreach ($kata_hasil as $key) {
				$query_bobot_kata = $this->con->query("SELECT `id_kata`, `kata`, `bobot_bayes_positif`, `bobot_bayes_negatif` FROM `data_training_kata` WHERE `kata` = '".$key."'");
				while ($row_kata = $query_bobot_kata->fetch_array()) {
					echo $row_kata['kata']." ";
					if ($key == $row_kata['kata']) {
						$prob_kata_positif[$key] = round($row_kata['bobot_bayes_positif'], 8);
						$prob_kata_negatif[$key] = round($row_kata['bobot_bayes_negatif'], 8);	
					} else {
						$prob_kata_positif[$key] = 1;
						$prob_kata_negatif[$key] = 1;
					}
				}
			}

			$prob_dokumen_positif = $this->get_probabilitas_kategori_positf();
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

			$query_simpan = $this->con->query("UPDATE `data_training_tes` SET `sentimen` = '".$sentimen."' WHERE `id_testing` = ".$row_dok['id_testing']."");
			if ($query_simpan) {
				echo $row_dok['tweet_preprocessing'];
				echo " Berhasil";
				echo "<hr>";
			} else {
				echo $row_dok['tweet_preprocessing'];
				echo " Gagal";
				echo "<hr>";
			}

			// echo $row_dok['tweet_preprocessing'];
			// echo "<br>";
			// print_r($prob_kata_positif);
			// echo "<br>";
			// print_r($prob_kata_negatif);
			// echo "<br>";
			// echo "Prob psoitif = ".$this->get_probabilitas_kategori_positf();
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
		$query_dok = $this->con->query("SELECT `id_testing`, `tweet_preprocessing` FROM data_training_tes ORDER BY `id_testing`");
		while ($row_dok = $query_dok->fetch_array()) {
			$prob_kata_positif = [];
			$prob_kata_negatif = [];
			$kata_dok = $row_dok['tweet_preprocessing'];
			$kata_hasil = explode(' ', $kata_dok);
			foreach ($kata_hasil as $key) {
				$prob_kata_positif[$key] = 1;
				$prob_kata_negatif[$key] = 1;
				$query_bobot_kata = $this->con->query("SELECT `id_kata`, `kata`, `bobot_bayes_positif`, `bobot_bayes_negatif` FROM `data_training_kata_ig` ORDER BY `bobot_ig` DESC LIMIT ".$batas_ambang_ig."");
				while ($row_kata = $query_bobot_kata->fetch_array()) {
					if ($key == $row_kata['kata']) {
						$prob_kata_positif[$key] = round($row_kata['bobot_bayes_positif'], 8);
						$prob_kata_negatif[$key] = round($row_kata['bobot_bayes_negatif'], 8);
					}
				}
			}

			$prob_dokumen_positif = $this->get_probabilitas_kategori_positf();
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

			$query_simpan = $this->con->query("UPDATE `data_training_tes` SET `sentimen_ig` = '".$sentimen."' WHERE `id_testing` = ".$row_dok['id_testing']."");
			if ($query_simpan) {
				echo $row_dok['tweet_preprocessing'];
				echo " Berhasil";
				echo "<hr>";
			} else {
				echo $row_dok['tweet_preprocessing'];
				echo " Gagal";
				echo "<hr>";
			}

			// echo $row_dok['tweet_preprocessing'];
			// echo "<br>";
			// print_r($prob_kata_positif);
			// echo "<br>";
			// print_r($prob_kata_negatif);
			// echo "<br>";
			// echo "Prob psoitif = ".$this->get_probabilitas_kategori_positf();
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


	public function akurasi()	{
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