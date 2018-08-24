<?php
ob_start();  
session_start();
?>
<html lang="en" >
<head>
     
    <link href="css/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="css/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="css/css1/style.css">  
    <script type="text/javascript"></script>	
    <!--<link rel="stylesheet" href="css/fonts/css/font-awesome.min.css">-->
    <!--<link rel="stylesheet" href="css/css1/bootstrap.min.css"/>-->
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
    
    <form action="#" method="GET">
    <?php
    if (isset($_GET['id'])){ // If the id post variable is set 
        $_SESSION['name']=$_GET['id'];
    }
    $album_name =$_SESSION['name'];
    $album_pic_all=array();
    $album_pic_all=$_SESSION['Album'];
    $one_album=$album_pic_all[$album_name][0];
    //****************************************
    echo "<br/><div class=\"container\">";
    echo "<div class=\"row\">";
    echo "<div class=\"col-sm-3\">";
    echo  "<input class=\"btn btn-warning\" type=\"submit\" name=\"submit\" value=\"download\">";
    echo "</div>";
    echo "<div class=\"col-sm-3\">";
    echo  "<input class=\"btn btn-info\" type=\"button\" name=\"checked\" value=\"SELECT ALL\" onclick=\"selectAll1()\">";
    echo "</div>";
    echo "<div class=\"col-sm-3\">";
    echo  "<input class=\"btn btn-info\" type=\"button\" name=\"unchecked\" value=\"UNSELECT ALL\" onclick=\"UnSelectAll1()\" >";
    echo "</div>";
    echo "<div class=\"col-sm-3\">";
    echo  "<input class=\"btn btn-success\" type=\"submit\" name=\"drive\" value=\"drive\" >";
    echo "</div>";
    echo "</div>";
    echo "</div><br/><br/>";
    //****************************************
    echo "<div class=\"container\">";
    echo "<div class=\"row\">";
    
    for ($i=0;$i<count($one_album);$i++){
        $img_name=$one_album[$i]['picture'];
        echo "<div class=\"col-sm-3\">";   
        echo "<input type=\"checkbox\"  name='profile_Albums[]' value=\"$img_name\" class=\"checkbox\">";
        echo "<img src=\"$img_name\" style=\"height:200px; width:200px;\">";
        echo "</div>";
    }
    echo "</div>";
    echo "<div class=\"container\">";	
    ?>
    </form>

    <div>
        <!--***************Footer******************-->
        <?php
            @include("footer.html");
        ?>
        <!--***************Footer******************-->
    </div>
</body>
</html>

<?php
    if (isset($_GET['submit'])){
        $select_data = $_GET['profile_Albums'];
        print_r($select_data) ;
        download_zip($select_data);
    }
    if (isset($_GET['drive'])){
        //$select_data = $_GET['profile_Albums'];
        //download_zip($select_data);
        upload_drive();
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
        $album_name1 =$_SESSION['name'].".rar";
        header('Content-Type: application/rar');
        header("Content-disposition: attachment; filename=$album_name1");
        header('Content-Length: ' . filesize($tmpFile));
        readfile($tmpFile);
        unlink($tmpFile);
    }
    function upload_drive() {
        session_start();
        include_once 'src/Google_Client.php';
        include_once 'src/contrib/Google_Oauth2Service.php';
        require_once 'src/contrib/Google_DriveService.php';
        $client = new Google_Client();
    
        $client->setClientId('854048582574-ids00rnmh5r4lngk2qaomm4fftor9rgu.apps.googleusercontent.com');
        $client->setClientSecret('cKgF_lg9D3sBgPnIJwBo6CrW');
        $client->setRedirectUri('/data.php');
        $client->setScopes(array('https://www.googleapis.com/auth/drive.file'));

        if (isset($_GET['code']) || (isset($_SESSION['access_token']))){            
            $service = new Google_DriveService($client);
            if (isset($_GET['code'])){
                $client->authenticate($_GET['code']);
                $_SESSION['access_token'] = $client->getAccessToken();		
            }
            else
                $client->setAccessToken($_SESSION['access_token']);
            
            //Insert a file
            $fileName="Pictures.rar";
            $file = new Google_DriveFile();
            $file->setTitle($fileName);
            $file->setMimeType('application/rar');
            $file->setDescription('A User Details is uploading in json format');
            print_r($file);
            exit;
        
            $createdFile = $service->files->insert($file, array(
                'data' =>file_get_contents('Pictures.rar'),
                'mimeType' => 'application/rar',
                'uploadType'=>'multipart'
                ));
        } 
        else{
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
            exit();
        }
    }
?>