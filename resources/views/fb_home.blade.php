<html>
<head>
	<link href="css/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<link href="css/css/bootstrap.css" rel='stylesheet' type='text/css' />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<script type="text/javascript">
	</script>	
	<link rel="stylesheet" href="css/fonts/css/font-awesome.min.css">	
	<style>
	</style>
</head>
<body>
	<div>
		<!-- start Header -->
		<!--<div class="header_bg">-->
	<div class="container">
		<div class="row header">
			<div class="logo navbar-left">
				<h1><a href="index.html">Facebook Album Downloader </a></h1>
			</div>
			<div class="h_search navbar-right">
				<form>
					<!--<a href="../resources/views/Album.blade.php">Login</a>-->					
					<a href="{{ route('auth/facebook') }}" class="btn btn-info" >Login</a>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	</div>
	<div class="container">
		<div class="row h_menu">
			<nav class="navbar navbar-default navbar-left" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
					<li class="active"><a href="#">Home</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
				<!-- start soc_icons -->
			</nav>
			<!-- <div class="soc_icons navbar-right">
				<ul class="list-unstyled text-center">
					<li><a href="#"><i class="fa fa-facebook"></i></a></li>
				</ul>	
			</div> -->
		</div>
	</div>
   	<!-- End Header -->            
	</div>
        
<!--<div class="slider_bg">-->
	<div class="container">
		<div id="da-slider" class="da-slider text-center">
			<div class="da-slide">    
            	<img src="img\images\slider_bg.jpg" style="height: 45%;width: 100%;>";
			</div>
	   </div>
	
<!--</div>    -->
	<div>
		<!-- Start Footer -->
		<?php
			@include("../resources/views/footer.html");
		?>
		<!-- End Footer -->
	</div>
    </div>
</body>
</html>
    
    
    
    