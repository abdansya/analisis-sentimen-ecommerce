<?php 
	set_time_limit(0);
	
	$host = 'localhost';
  $user = 'root';
  $pass = '';
  $db = 'ansen_ecommerce';
  $con = mysqli_connect($host, $user, $pass, $db) or die(mysql_error());
?>