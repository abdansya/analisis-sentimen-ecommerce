<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		#preloader_1{
      position: relative;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 1;
		}
		.popup{
			display: none;
		}
		.bg{
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: #ddd;
		}
		.content{
			position: absolute;
			top:100px;
			left: 40%;
			width: 300px;
			background: #fff;
			padding: 10px 20px;
			border-radius: 10px;
			border: black 2px dashed;
		}
		.content-text{
		 
		}
		.close{
			display: block;
			margin : 20px auto;
			width: 20%;
			padding: 7px 15px;
			cursor: pointer;
			background: #E74C3C;
			color: #fff;
			border-radius: 5px;
		}
		.close:hover,.close:visited{
			background: #C0392B;
		}
		#loading {
			position:fixed;z-index:999;top:0;left:0;width:100%;height:100%;background:white url("assets/img/loading.gif")center no-repeat
		}
	</style>
	<!-- jQuery Plugin -->
  <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <!-- Preloader -->
  <script type="text/javascript">
      $(window).load(function() { 
      		$("#loading").fadeOut("slow");
      		$('.popup').fadeIn();
       })
      // close
		  $(function(){
		  	$('.bg,.close').click(function(e){
					e.preventDefault();
					$('.popup').fadeOut('slow');
			  });
		  });
  </script>
</head>
<body>
	<div id="loading">
	    <ul id="spinners">
	    <li class="active" data-id="1">
	        <div id="preloader_1">
	        	<div id="loading">
	        </div>
	    </li>
	  </ul>
	</div>
	<?php
		$max = 100000;
		for ($i=0; $i < $max; $i++) { 
			echo "haha";
			echo "<br>";
		}
	?>

	<div class="popup">
	  <div class="bg"></div>
	  <div class="content">
	  	<div class="content-text">
	  		<center><h2>Crawling Selesai !!</h2></center>
	  	</div>
	  <div class="close"><center>OK</center></div>
	  </div>
	 </div>
</body>
</html>