<?php
include_once "koneksi_procedural.php";
set_time_limit(0);
function pemisah_kata() {
	GLOBAL $con;
	$query = "SELECT `tweet_preprocessing` FROM `data_training`";
	$data = mysqli_query($con, $query);

	while ($dokumen = mysqli_fetch_array($data)) {
		$kalimat = $dokumen['tweet_preprocessing'];
		$kal = explode(' ', $kalimat);
		foreach ($kal as $kata) {
			$query_kata = "INSERT INTO `data_training_kata`(`kata`) VALUES ('".$kata."')";
			$simpan =mysqli_query($con, $query_kata);
			if ($simpan) {
				echo $kata;echo "<br>";
			}
		}
	}
}

function frekuensi_kata() {
	GLOBAL $con;
	$a=0;
	$query_kata = "SELECT `id_kata`,`kata` FROM `data_training_kata`";
	$hasil_kata = mysqli_query($con, $query_kata);
	$total=0;
	while ($hasil = mysqli_fetch_array($hasil_kata)) {
		$n = 0;
		$query_dokumen = "SELECT `tweet_preprocessing` FROM `data_training`";
		$data = mysqli_query($con, $query_dokumen);
		$tweet="";
		while ($dokumen = mysqli_fetch_array($data)) {
			$kalimat = $dokumen['tweet_preprocessing'];
			$kal = explode(' ', $kalimat);
			foreach ($kal as $kata) {
				if ($hasil['kata'] == $kata) {
					$n+=1;
					$total+=1;
				}
			}
			$tweet = $kalimat;
		}
		echo $hasil['kata']." = $n";

		$query_simpan = "UPDATE `data_training_kata` SET `frekuensi`= $n WHERE id_kata = ".$hasil['id_kata'];
		$simpan = mysqli_query($con, $query_simpan);
		if ($simpan) {
			echo " berhasil";
		}
		echo "<br>";
	}
	echo "<br>";
	echo "=========";
	echo $total;
	echo "=========";
}


function total_kata() {
	GLOBAL $con;
	$query = "SELECT `tweet_preprocessing` FROM `data_training`";
	$data = mysqli_query($con, $query);
	$n = 0;
	while ($dokumen = mysqli_fetch_array($data)) {
		$kalimat = $dokumen['tweet_preprocessing'];
		$kal = explode(' ', $kalimat);
		foreach ($kal as $kata) {
			$n+=1;
		}
	}
	echo "<br>";
	echo "++++++";
	echo $n;
	echo "++++++";
}


function urutkan_nomor() {
	GLOBAL $con;
	$query = "SELECT `id_training` FROM `data_training`";
	$hasil = mysqli_query($con, $query);
	$id_training = [];
	$a=0;
	while ($no = mysqli_fetch_array($hasil)) {
		array_push($id_training, $no['id_training']);
	}

	for ($i=1; $i < count($id_training); $i++) {

		echo $q = "UPDATE `data_training` SET `id_training`= $i WHERE `id_training` = ".$id_training[$a]."";
		$hasil = mysqli_query($con, $q);
		if ($hasil) {
			echo " Berhasil";
		}
		echo "<br>";
		$a+=1;
	}
}

function data_training() {
	GLOBAL $con;
	$query = "SELECT * FROM `data_training`";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}

function data_crawling() {
	GLOBAL $con;
	$tanggal_crawling = date('Y-m-d', strtotime('-8 days', strtotime( date('Y-m-d') )));
	$query = "SELECT * FROM `data_testing` WHERE `tanggal` > '".$tanggal_crawling."' ORDER BY `data_testing`.`id_tes` DESC";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}

function data_bobot() {
	GLOBAL $con;
	$query = "SELECT * FROM `data_training_kata` ORDER BY `id_kata` ASC";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}

function data_bobot_bayes_testing() {
	GLOBAL $con;
	$tanggal_crawling = date('Y-m-d', strtotime('-8 days', strtotime( date('Y-m-d') )));
	$query = "SELECT `id_tes`, `tweet`, `bobot_bayes_positif`, `bobot_bayes_negatif`, `sentimen` FROM `data_testing` WHERE `tanggal` > '".$tanggal_crawling."' ORDER BY `data_testing`.`id_tes` DESC";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}

function data_bobot_bayes_training() {
	GLOBAL $con;
	$query = "SELECT `id_kata`, `kata`, `bobot_bayes_positif`, `bobot_bayes_negatif` FROM `data_training_kata`";
	$hasil = mysqli_query($con, $query);
	return $hasil;
}

function update_data_training($field, $data, $rownum) {
	GLOBAL $con;
	$query = "UPDATE `data_training` SET `".$field."` = '".$data."' WHERE `id_training` = ".$rownum;
	mysqli_query($con, $query) or die(mysql_error());
}

// pemisah_kata();
// frekuensi_kata();
// total_kata();
// urutkan_nomor();
?>
