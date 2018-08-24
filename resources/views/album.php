<?php
ob_start();  
session_start();
error_reporting(0);
ini_set('max_execution_time', 300);
?>
<html lang="en" >
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="css/css1/style.css">
    <link rel="stylesheet" href="css/css1/bootstrap.min.css"/>
    <link href="css/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="css/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    </script>	
    <link rel="stylesheet" href="css/fonts/css/font-awesome.min.css">
</head>

<body>
	<div>
		<!-- start Header -->
		<?php
			@include("header.html");
		?>
		<!-- End Header -->
	</div>
	
	<form method="GET" action="#">
	<?php
		//****************************************
		echo "<br/><div class=\"container\">";
			echo "<div class=\"row\">";
				echo "<div class=\"col-sm-4\">";
				echo  "<input class=\"btn btn-warning\" type=\"submit\" name=\"submit\" value=\"download\">";
				echo "</div>";
				echo "<div class=\"col-sm-4\">";
				echo  "<input class=\"btn btn-info\" type=\"button\" name=\"checked\" value=\"SELECT ALL\" onclick=\"selectAll()\">";
				echo "</div>";
				echo "<div class=\"col-sm-4\">";
				echo  "<input class=\"btn btn-info\" type=\"button\" name=\"unchecked\" value=\"UNSELECT ALL\" onclick=\"UnSelectAll()\" >";
				echo "</div>";
			echo "</div>";
		echo "</div><br/><br/>";
	?>

	<div style="margin-top: 50px;">
	<div id="main" class="container">
	<div id="gallery" class="row">
	
	<?php 
	try{
		$url= "https://graph.facebook.com/v3.1/me?fields=id%2Cname%2Calbums%7Bid%2Cname%2Ccount%2Cphotos%7Bpicture%7D%7D&access_token=EAAB8ZAQ5QTiQBAKqAcfrmbtZAOGxDirehfiblnziWYz9oKiUl6FAS0Vg2gGNuCFZCFQtUFHU4jw04ZBNMegvohysf1ph4ozoGIyai0ghhrtttg7EA41NaiMyTlWYsZChZCVWxLgbPCdAMXub02hZCgHxNjXY2vb1xDV5htEiPUnc1o2Y7Y4ZAlQwnwez9fWttxArICBJuMbZCijc383FZCHTQH";
		$_SESSION['access_token'] = (string) $url;
		
		$header = array("Content-type: application/json");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$st = curl_exec($ch);
		$retval = json_decode($st,true);
		$total_album=count($retval['albums']['data']);
		$all_data= array ();

		for ($i=0;$i<$total_album;$i++){
			$albums_name=$retval['albums']['data'][$i]['name'];
			$pic=$retval['albums']['data'][$i]['photos']['data'];
			$total_pic=$retval['albums']['data'][$i]['count'];
			$all_data[$albums_name][] =$pic;
		}
		
		$_SESSION['Album'] = $all_data;
		$ll=count($all_data);
		
		foreach ($all_data as $key=>$val){
			$album=$val[0];
			$length=count($album);		
			echo "<a href='/data?id=$key'>";
			echo "<div class=\"col-xs-4 gallery-item\">";
			echo "<div class='album' style=\"margin-bottom: 25px; font-family:  fantasy;\"><center><span>$key</span></center></div>";
			echo "<div class=\"album\">";
			
			for ($i=0;$i<$length;$i++){
				$url=$all_data[$key][0][$i]['picture'];
				echo "<img src=\"$url\" style=\"height:200px; width:200px;\">";
			}
			echo "</div>";
			echo "<div class='album' style=\"margin-top: 25px; font-family:  fantasy;\"><center> <input type='checkbox' class='profile_Albums' name='profileAlbums[]' value=\"$key\">Download</center></div>";
			echo "</div></a>";
		}
		}
        catch(Exception $e)
        {
           header("Location:index.php");  
        }	
	?>
	</div>
	</div>
	</div>

	<div class="container">
		<!-- Start Footer -->
		<?php
			@include("footer.html");
		?>
		<!-- End Footer -->
	</div>
	</form>
</body>
</html>

<?php
	$img_arry=array();
	if (isset($_GET['submit'])){
		$select_data = $_GET['profileAlbums'];
		for ($i=0;$x<count($select_data);$i++){
			$album_name=$select_data[$i];
			$all_pic=$md_array[$album_name][0];
			for ($j=0;$j<count($all_pic);$j++){
				array_push($img_arry,$all_pic[$j]['picture']);
			}
		}
		download_zip($img_arry);
	}
    function download_zip($img_arry) {
        $files=$img_arry;
        $tmpFile = tempnam('/tmp', '');
        $zip = new ZipArchive;
        $zip->open($tmpFile, ZipArchive::CREATE);

        foreach ($files as $file){
			// download file
			$fileContent = file_get_contents($file);
			$f_name=explode ("?",$file);
			$only_name=$f_name[0];
			$zip->addFromString(basename($only_name), $fileContent);
        }
		$zip->close();
        header('Content-Type: application/rar');
        header('Content-disposition: attachment; filename=facebook_album.rar');
        header('Content-Length: ' . filesize($tmpFile));
        readfile($tmpFile);
        unlink($tmpFile);
    }	
?>
