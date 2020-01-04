<?php
include_once "koneksi.php";
require_once __DIR__.'/twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
/**
*
*/
class Crawling extends Koneksi {

	public function get_tweet($keyword, $id_akun) {

		// ganti dengan API twitter anda
		$key = '2IVubz2TIA1wc2iLnUn9t7Ta9';
		$secret_key = '1IJ4v6eWRnECQjztEnKGqw7HiZnCVRceeiFX6m067ptcP7gRsg';
		$token = '432207100-C0l0q86QA71zBhVmC40QwRIKxnhcD3smwrWnREeh';
		$secret_token = 'mxBhaUjEFx1RIDrOa8wBDnCfOHE33HQCuLSLbgtneby3r';

		$conn = new TwitterOAuth($key, $secret_key, $token, $secret_token);


		// menagmbil tweet berdasarkan keyword yang di tentukan
		// anda bisa merubah jumlah tweet yang akan di tampilkanb dengan merubah angka pada count
		for ($j=7; $j >= 0 ; $j--) {
			$tanggal_crawling = date('Y-m-d', strtotime('-'.$j.' days', strtotime( date('Y-m-d') )));
			$tweets = $conn->get('search/tweets', array('q'=>$keyword, 'count'=>100, 'lang'=>'in', 'until'=>$tanggal_crawling));

			// menampilkan hasil keyword yang di tentukan
			// echo '<h4>Keyword = \''.$keyword.'\'</h4><hr/>';
			foreach ($tweets->statuses as $tweet) {
			  static $i=0;
			  $i+=1;
			  // echo "$i => ";
			  $id_tweet = $tweet->id;
			  $user = $tweet->user->screen_name;
			  $text = $tweet->text;
			  $date = date('Y-m-d', strtotime($tweet->created_at));
			  // $date = ('2017-01-01 05:00:00', strtotime($tweet->created_at));

			  // echo '</strong>'.$date.'</strong><br/>';
			  // echo '<strong>'.$user.'</strong> : '.$text.'<br/>';
				// echo $id_tweet.'<br/>';
				$query = $this->con->query("INSERT INTO `data_testing` (`id_akun`, `id_tweet`, `tweet`, `tanggal`) VALUES (".$id_akun.", ".$id_tweet.", '".$text."', '".$date."')");
				// if ($query) {
				// 	echo " berhasil";
				// 	echo "<hr>";
				// } else {
				// 	echo "gagal";
				// 	echo "<hr>";
				// }
			}
		}
	}

}

?>
