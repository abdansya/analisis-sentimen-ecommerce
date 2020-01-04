<?php
include_once 'function/f_tampildata.php';
include_once 'model/model_index.php';
include_once 'crawling.php';
?>

<!DOCTYPE html>
<html lang="en">
<html>
	<head>
		<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Analisis Ecommerce</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css">
		<link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
		<script src="assets/js/jquery-3.2.1.min.js" charset="utf-8"></script>
		<script src="assets/js/bootstrap.min.js" charset="utf-8"></script>
		<script src="assets/js/zingchart.min.js" charset="utf-8"></script>
		<script src="assets/js/ansenchart.js" charset="utf-8"></script>
		<script type="text/javascript">
			var tanggal = <?php echo $tanggal; ?>;
			var lazada_p = <?php echo $datalp; ?>;
			var lazada_n = <?php echo $dataln; ?>;
			var bukalapak_p = <?php echo $databp; ?>;
			var bukalapak_n = <?php echo $databn; ?>;
			var tokopedia_p = <?php echo $datatp; ?>;
			var tokopedia_n = <?php echo $datatn; ?>;

			var persenlp = <?php echo $persenlp; ?>;
			var persenln = <?php echo $persenln; ?>;
			var persenbp = <?php echo $persenbp; ?>;
			var persenbn = <?php echo $persenbn; ?>;
			var persentp = <?php echo $persentp; ?>;
			var persentn = <?php echo $persentn; ?>;
		</script>
	</head>
	<body>
		<!-- Header -->
		<div class="container-fluid bg-1">
			<div class="row">
				<div class="navbar">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
						<a class="navbar-brand" href="index.php">Analisis E-Commerce</a>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav navbar-right">
							<li><a href="http://localhost/ansen-ecommerce/">Beranda</a></li>
							<li><a href="http://localhost/ansen-ecommerce/proses-crawling.php">Proses</a></li>
							<li><a href="http://localhost/ansen-ecommerce/visualisasi.php">Visualisasi</a></li>
							<li><a href="http://localhost/ansen-ecommerce/tentang-kami.php">Tentang Kami</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center judul">
					<h1>ANALISIS SENTIMEN MASYARAKAT<br>TERHADAP ECOMMERCE</h1>
					<form class="" action="" method="get">
						<div id="custom-search-input">
              <div class="input-group col-md-12">
                <input type="text" class="form-control input-lg" placeholder="Cari" name="katakunci">
                <span class="input-group-btn">
                  <button class="btn btn-info btn-lg" type="submit" name="btsubmit" value="crawindex">
                    <i class="glyphicon glyphicon-search"></i>
                  </button>
                </span>
              </div>
            </div>
					</form>
				</div>
			</div>
		</div>

		<!-- Section 1 -->
		<div class="container-fluid text-center bg-2">
			<div class="row">
				<div class="col-md-3">
				</div>
				<div class="col-md-2">
					<img src="assets/img/logo-lazada.png" alt="lazada">
				</div>
				<div class="col-md-2">
					<img src="assets/img/logo-bukalapak.png" alt="bukalapak">
				</div>
				<div class="col-md-2">
					<img src="assets/img/logo-tokopedia.png" alt="tokopedia">
				</div>
				<div class="col-md-3">
				</div>
			</div>
		</div>

		<!-- Section 2 -->
		<div class="container-fluid text-center bg-3">
			<!-- <img src="assets/img/chart.png" alt="Chart" class="gambar"> -->
			<div id='myChart'></div>
		</div>

		<!-- Section 3 -->
		<div class="container-fluid text-center bg-4">
			<!-- <img src="assets/img/chart-pie.jpg" alt="Chart" class="gambar"> -->
			<div id='myChartPie'></div>
		</div>

		<!-- Footer -->
		<footer class="container-fluid text-center footer">
			<div>  	&copy; abdan syakuro [ ] dengan <span>❤</span> di Malang </div>
		</footer>

	</body>
</html>
