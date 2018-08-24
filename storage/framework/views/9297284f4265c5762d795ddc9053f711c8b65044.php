<html>
<head>
	<link href="css/style1.css" rel="stylesheet" type="text/css" media="all" />
	<script src="js/jquery.min.js"></script>
	<!---strat-slider---->
	<link rel="stylesheet" type="text/css" href="css/slider.css" />
	<script type="text/javascript" src="js/modernizr.custom.28468.js"></script>
	<script type="text/javascript" src="js/jquery.cslider.js"></script>
		<script type="text/javascript">
			$(function() {
			
				$('#da-slider').cslider({
					autoplay	: false,
					bgincrement	: 450
				});
			
			});
		</script>		
</head>

<body>
<div class="wrap"> 
	<div class="header-top">
		<div class="logo">
			<a href="index.html"><img src="img/logo.png" alt=""/></a>
		</div>
		<div class="h_menu4"><!-- start h_menu4 -->
			<a class="toggleMenu" href="#">Menu</a>
			<ul class="nav">
				<li class="active"><a href="index.html">Home</a></li>
				<li > <a href="<?php echo e(route('auth/facebook')); ?>">Login</a></li>		
			</ul>
			<script type="text/javascript" src="js/nav.js"></script>
		</div><!-- end h_menu4 -->
		<div class="clear"></div>
	</div><!-- end header_main4 -->
	<div class="slider">
		<div id="da-slider" class="da-slider">
			<div class="da-slide">
				<h1>Welcome To Facebook Album Downloader </h1>
				<p></p>		
				<a href="<?php echo e(route('auth/facebook')); ?>" class="da-link">Login</a>
			</div>
			<nav class="da-arrows">
				<span class="da-arrows-prev"></span>
				<span class="da-arrows-next"></span>
			</nav>
		</div>
	</div>
</div>
</body>
</html>