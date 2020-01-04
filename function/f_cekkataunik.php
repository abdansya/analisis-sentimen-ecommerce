<?php 

$kalimat = "sudah kami bantu remit silakan cek lebih lanjut baik, tunggu. terimakasih banyak silakan kami sudah respon pesan terimakasih mohon maaf, resi tidak valid tidak kenal, email tidak ada mohon maaf, mohon informasi";

function cek_kata($string) {
	$kalimat = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
	$kalimat = trimed($kalimat);
	$kata = explode(' ',$kalimat);
	$kata = array_unique($kata);
	$jml_kata = count($kata);
	return $jml_kata;
}

function trimed($txt){
	$txt = trim($txt);
	while( strpos($txt, '  ') ){
		$txt = str_replace('  ', ' ', $txt);
	}
	return $txt;
}

print_r(cek_kata($kalimat));

echo "<hr>";

?>