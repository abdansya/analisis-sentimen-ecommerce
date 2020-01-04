<?php include_once '../function/f_tampildata.php';  ?>
<!DOCTYPE html PUBLIC "-//W3C// DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Analisis Ecommerce</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <script src="../assets/js/jquery-3.2.1.min.js" charset="utf-8"></script>
    <script src="../assets/js/bootstrap.min.js" charset="utf-8"></script>
    <script src="../assets/js/zingchart.min.js" charset="utf-8"></script>
    <!-- <script src="../assets/js/ansenchart.js" charset="utf-8"></script> -->

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
        <li><a href="http://localhost/ansen-ecommerce/proses-crawling.php"><i class="fa fa-search-plus fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Crawling</a></li>
        <li><a href="http://localhost/ansen-ecommerce/proses-preprocessing.php"><i class="fa fa-retweet fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Preprocessing</a></li>
        <li><a href="http://localhost/ansen-ecommerce/proses-information-gain.php"><i class="fa fa-balance-scale fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Bobot IG</a></li>
        <li><a href="http://localhost/ansen-ecommerce/proses-bobot-bayes.php"><i class="fa fa-shopping-basket fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Bobot Bayes</a></li>
        <li><a href="http://localhost/ansen-ecommerce/proses-klasifikasi-bayes.php"><i class="fa fa-table fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Klasifikasi Sentimen</a></li>
        <li class="menu-terpilih"><a href="http://localhost/ansen-ecommerce/visualisasi.php"><i class="fa fa-area-chart fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;Visualisasi</a></li>
      </ul>
    </nav>
    <main class="main container-fluid">
      <div class="row">
        <!-- <div class="col-md-2">
        </div>
        <div class="col-md-10">
          <h3>Visualisasi</h3>
          <hr>
          <div class="row">
          </div>
          <div id="grafikArea" height="400px"></div>
          <div class="row">
            <div id="grafikPie" height="400px"></div>
          </div>
        </div> -->
      </div>
    </main>
    <div class="container">
      <div id="grafikArea"></div>
      <div id="grafikPie"></div>
    </div>

    <!-- Footer -->
    <!-- <footer class="container-fluid text-center footer">
			<div>  	&copy; abdan syakuro [ ] dengan <span>❤</span> di Malang </div>
		</footer> -->
    <!--Chart Placement[2]-->
    <script>
    var myConfigArea = {
      type: "area",
      "title":{
        "text":"Analisis 1 pekan"
      },
      "legend":{
        "background-color":"#ffe6e6",
        "border-width":2,
        "border-color":"red",
        "border-radius":"5px",
        "padding":"10%",
        "layout":"2x3",
        "x":"34%",
        "y":"10%",
      },
      plotarea: {
        /*Add an adjust-layout attribute for automatic margin adjustment*/
        "margin-top":"25%",
        "margin-right":"5%",
        "margin-left":"5%"
      },
      scaleX: {
        label:{  /*Add a scale title with a label object*/
          text:"Tanggal crawling",
        },
        /*Add your scale labels with a labels array*/
        labels: tanggal
      },
      series: [
        {
          values: lazada_p,
          text: "Lazada Positif"
        },
        {
          values: bukalapak_p,
          text: "Bukalapak Positif"

        },
        {
          values: tokopedia_p,
          text: "Tokopedia Positif"
        },
        {
          values: lazada_n,
          text: "Lazada Negatif"
        },
        {
          values: bukalapak_n,
          text: "Bukalapak Negatif"
        },
        {
          values: tokopedia_n,
          text: "Tokopedia Negatif"
        }
      ]
    };

    zingchart.render({
      id : 'grafikArea',
      data : myConfigArea,
      height: "100%",
      width: "100%"
    });

    // ============================================================================ //

    var myConfigPie = {
     	type: "pie",
     	plot: {
     	  borderColor: "#2B313B",
     	  borderWidth: 5,
     	  // slice: 90,
     	  valueBox: {
     	    placement: 'out',
     	    text: '%t\n%npv%',
     	    fontFamily: "Open Sans"
     	  },
     	  tooltip:{
     	    fontSize: '18',
     	    fontFamily: "Open Sans",
     	    padding: "5 10",
     	    text: "%npv%"
     	  },
     	  animation:{
          effect: 2,
          method: 5,
          speed: 900,
          sequence: 1,
          delay: 3000
        }
     	},
     	title: {
     	  fontColor: "#8e99a9",
     	  text: 'Persentase Sentimen',
     	  align: "left",
     	  offsetX: 10,
     	  fontFamily: "Open Sans",
     	  fontSize: 25
     	},
     	plotarea: {
     	  margin: "20 0 0 0"
     	},
    	series : [
    		{
    			values : [persenlp],
    			text: "Lazada Positif",
    		  backgroundColor: '#FFCB45',
    		},
    		{
    		  values: [persenln],
    		  text: "Lazada Negatif",
    		  backgroundColor: '#FF7965',
    		  detached:true
    		},
    		{
    		  values: [persenbp],
    		  text: 'Bukalapak Positif',
    		  backgroundColor: '#50ADF5',
    		  detached:true
    		},
    		{
    		  text: 'Bukalapak Negatif',
    		  values: [persenbn],
    		  backgroundColor: '#6877e5'
    		},
    		{
    		  text: 'Tokopedia Positif',
    		  values: [persentp],
    		  backgroundColor: '#52fe16'
    		},
    		{
    		  text: 'Tokopedia Negatif',
    		  values: [persentn],
    		  backgroundColor: '#6FB07F'
    		}
    	]
    };

    zingchart.render({
    	id : 'grafikPie',
    	data : myConfigPie,
    	height: '100%',
    	width: '100%'
    });

    </script>
  </body>
</html>
