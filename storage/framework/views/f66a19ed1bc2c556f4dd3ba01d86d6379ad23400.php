<?php
ob_start();  
session_start();
?>
<html lang="en" >
<head>
	<meta charset="UTF-8">
      <link rel="stylesheet" href="css/css1/style.css">
      <link rel="stylesheet" href="css/css1/bootstrap.min.css"/>
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
		$url="https://graph.facebook.com/v3.1/me?fields=id%2Cname%2Calbums%7Bid%2Cname%2Ccount%2Cphotos%7Bpicture%7D%7D&access_token=EAAB8ZAQ5QTiQBAAJmqpCGdnpsYJ298XgZBgon3C5lcaqW0EeGI2egqvxZBCSPwG1nJYTsxZCSgym5s5HbeoqFB5h2ulPkd0Y67uEpQUDoUTd1wEim51gTviWSbczynOFuHj6WGPI0mRiX6CtSQX09CHZBHxBI44hUTTV4wGvtnerVrtznCsvcg3M9nySM0KO0zVC96v6JV8AzABDNrSwP";
		$header = array("Content-type: application/json");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//print "Data";
		$st = curl_exec($ch);
		//print_r($st);
		$retval = json_decode($st,true);
		$l=count($retval['albums']['data']);
		$md_array= array ();

		for ($i=0;$i<$l;$i++){
			$albums_name=$retval['albums']['data'][$i]['name'];
			$pic=$retval['albums']['data'][$i]['photos']['data'];
			$total_pic=$retval['albums']['data'][$i]['count'];
			$md_array[$albums_name][] =$pic;
		}
		
		$_SESSION['Album'] = $md_array;
		$ll=count($md_array);
		//echo $ll;
		//print'<pre>';
		//print_r($md_array);
		//print'</pre>';
		
		foreach ($md_array as $key=>$val){
			$a=$val[0];
			$l=count($a);		
			echo "<a href='data.php?id=$key'>";
			echo "<div class=\"col-xs-4 gallery-item\">";
			echo "<div class='album' style=\"margin-bottom: 25px; font-family:  fantasy;\"><center><span>$key</span></center></div>";
			echo "<div class=\"album\">";
			
			for ($i=0;$i<$l;$i++){
				$xx=$md_array[$key][0][$i]['picture'];
				echo "<img src=\"$xx\" style=\"height:200px; width:200px;\">";
			}
			echo "</div>";
			echo "<div class='album' style=\"margin-top: 25px; font-family:  fantasy;\"><center> <input type='checkbox' class='profile_Albums' name='profileAlbums[]' value=\"$key\">Download</center></div>";
			echo "</div></a>";
		}	
	?>
	</div>
	</div>
	</div>

	<div>
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
	$xx=array();
	if (isset($_GET['submit'])){
		//$total_album=count($retval['albums']['data']);	
		$select_data = $_GET['profileAlbums'];
		//print_r ($select_data);
		
		for ($x=0;$x<count($select_data);$x++){
			$album_name=$select_data[$x];
			$all_pic=$md_array[$album_name][0];
			for ($i=0;$i<count($all_pic);$i++){
				array_push($xx,$all_pic[$i]['picture']);
			}
		}
		download_zip($xx);
	}
	
	function download_zip($x) {
        //$files = array($image1, $image2);
        $files=$x;
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
