<?php
include_once 'model/model_proses_crawling.php';
$data = data_crawling_testing();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Analisis Ecommerce</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <script src="assets/js/jquery-3.2.1.min.js" charset="utf-8"></script>
    <script src="assets/js/bootstrap.min.js" charset="utf-8"></script>
    <!-- <script src="assets/js/zingchart.min.js" charset="utf-8"></script> -->
    <!-- <script src="assets/js/ansenchart.js" charset="utf-8"></script> -->
  </head>
  <body>
    <!-- Header -->
		<div class="container-fluid navigasi navbar-fixed-top">
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
    </div>

    <!-- Section -->
    <nav class="col-md-2 menu-kiri">
      <ul>
        <li>
					<a href="#subPages" data-toggle="collapse" class="active collapsed" aria-expanded="false"><i class="fa fa-gears fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Proses Training  <i class="fa fa-chevron-down pull-right" aria-hidden="true" style="padding:17px;"></i></a>
					<div id="subPages" class="collapse" aria-expanded="false" style="height: 0px;">
						<ul class="sub-nav">
							<li><a href="training-crawling.php" class="sub-menu"><i class="fa fa-search-plus fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Crawling</a></li>
							<li><a href="training-preprocessing.php" class="sub-menu"><i class="fa fa-retweet fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Preprocessing</a></li>
              <li><a href="training-information-gain.php" class="sub-menu"><i class="fa fa-balance-scale fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Information Gain</a></li>
              <li><a href="training-naive-bayes.php" class="sub-menu"><i class="fa fa-shopping-basket fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Naive Bayes</a></li>
              <li><a href="training-akurasi.php" class="sub-menu"><i class="fa fa-dashboard fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Akurasi</a></li>
						</ul>
					</div>
				</li>
        <li class="menu-terpilih"><a href="http://localhost/ansen-ecommerce/proses-crawling.php"><i class="fa fa-search-plus fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Crawling</a></li>
        <li><a href="http://localhost/ansen-ecommerce/proses-preprocessing.php"><i class="fa fa-retweet fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Preprocessing</a></li>
        <li><a href="http://localhost/ansen-ecommerce/proses-information-gain.php"><i class="fa fa-balance-scale fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Bobot IG</a></li>
        <li><a href="http://localhost/ansen-ecommerce/proses-bobot-bayes.php"><i class="fa fa-shopping-basket fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Bobot Bayes</a></li>
        <li><a href="http://localhost/ansen-ecommerce/proses-klasifikasi-bayes.php"><i class="fa fa-table fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Klasifikasi Sentimen</a></li>
        <li><a href="http://localhost/ansen-ecommerce/visualisasi.php"><i class="fa fa-area-chart fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Visualisasi</a></li>
      </ul>
    </nav>
    <main class="main container-fluid">
      <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-10">
          <h3>Crawling</h3>
          <hr>
          <form action="" method="get">
           <div class="input-group">
             <input type="text" class="form-control" placeholder="Search" name="katakunci">
             <div class="input-group-btn">
               <button class="btn btn-default" type="submit" name="btsubmit" value="crawling">
                 <i class="glyphicon glyphicon-search"></i>
               </button>
             </div>
           </div>
          </form>
          <br><br>
          <?php if ($data->num_rows > 0): ?>

          <table class="table table-striped">
            <thead>
              <tr>
                <th>Id Tweet</th>
                <th>Tweet</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($data)) { ?>
              <tr>
                <td class="col-md-2"><?php echo $row['id_tweet']; ?></td>
                <td class="col-md-9"><?php echo $row['tweet']; ?></td>
                <td class="col-md-1"><?php echo date("d-m-Y", strtotime($row['tanggal'])); ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
          <?php endif; ?>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <!-- <footer class="container-fluid text-center footer">
			<div>  	&copy; abdan syakuro [ ] dengan <span>❤</span> di Malang </div>
		</footer> -->

  </body>
</html>
