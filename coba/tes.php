<?php

echo date('M Y', strtotime('1994/12/10'));
echo "<br>";
for ($i=0; $i <5 ; $i++) {
  $tanggal_crawling = date('M Y', strtotime('-'.$i.' month', strtotime( '2017/09/1' )));
  echo $tanggal_crawling;
  echo "<br>";
}

 ?>
