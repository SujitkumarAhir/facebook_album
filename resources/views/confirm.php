<html>
<head>
    <link href="css/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="css/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript"></script>	
    <link rel="stylesheet" href="css/fonts/css/font-awesome.min.css">
    <style>
    </style>
</head>    
<body>
    <div>
        <!-- start Header -->
        <?php
            @include("header.html");
        ?>
        <!-- End Header -->
    </div>
    
<div class="slider_bg">
    <div class="container">
        <div id="da-slider" class="da-slider text-center">
            <div class="da-slide">
                <a href="/album" >
                <img src="../../img/cntn.jpg" style="margin-top: 15%;margin-left: 2%;height: 23%;width: 90%;margin-bottom: 5%";>
                </a>
            </div>
        </div>
        <div>
        <!--***************Footer******************-->
        <?php
            @include("footer.html");
        ?>
        <!--***************Footer******************-->
        </div>    
    </div>
</div>
</body>
</html>