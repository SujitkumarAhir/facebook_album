<html>
<head>
<style>

#main h1 {
  color: #FFF;
  font-weight: 100;
  letter-spacing: 3px;
  padding: 40px 0 70px;
}

#main #gallery .gallery-item {
  height: 300px;
}
#main #gallery .gallery-item .album {
  position: relative;
  width: 80%;
  margin: auto;
  -moz-transition: all 0.5s;
  -o-transition: all 0.5s;
  -webkit-transition: all 0.5s;
  transition: all 0.5s;
}
#main #gallery .gallery-item .album img {
  width: 100%;
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  border: 4px solid #FFF;
  -moz-box-shadow: 0 0 4px black;
  -webkit-box-shadow: 0 0 4px black;
  box-shadow: 0 0 4px black;
  -moz-border-radius: 8px;
  -webkit-border-radius: 8px;
  border-radius: 8px;
 
}

#main #gallery .gallery-item .album img:first-child {
  position: relative;
  z-index: 1000;
}
#main #gallery .gallery-item .album img:first-child + img {
  -moz-transform: rotate(-8deg);
  -ms-transform: rotate(-8deg);
  -webkit-transform: rotate(-8deg);
  transform: rotate(-8deg);
}
#main #gallery .gallery-item .album img:last-child {
  -moz-transform: rotate(8deg);
  -ms-transform: rotate(8deg);
  -webkit-transform: rotate(8deg);
  transform: rotate(8deg);
}

#main #gallery .gallery-item p {
  width: 100%;
  text-align: center;
  color: #FFF;
  padding-top: 20px;
}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>  
</head>
<body>
<div id="main" class="container">
<div id="gallery" class="row">
       
<?php        
        $url="https://graph.facebook.com/v2.12/me?fields=id%2Cname%2Calbums%7Bid%2Cname%2Ccount%2Cphotos%7Bpicture%7D%7D&access_token=EAACEdEose0cBAJLnp2tC9JqDjeSBTjgQ36bybqBlDrvyx3ockjQ5RMyjrbaEJj2o0jihmYdBcEhyZAm2lvZBqZB22KljDfUddZCfc3eIc7C55o47Na6UPlnNsIfPXU7dUR3rICOH9vEYlj45RjBch3iYLmB38zrTpGWX7HIEhLvdZBL4ZBL6gcSZBaBlOZCYREcZD";
        
        
        $header = array("Content-type: application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //print "Data";
        $st = curl_exec($ch);
        //print_r($st);
        $retval = json_decode($st,true);
        //print_r($retval);
        
        
        
            
        
         
                 
       
       
        function recursivePrintArray($input)
        {
            if (is_array($input))
            {
                foreach ($input as $key => $value) 
                {
                    if (is_array($value)) 
                    {
                        //echo "Further {$key} has ==><br/> ";
                        //echo "<li> $key </li> <ul>"; 
                       
                        if(strcmp($key, 'photos') == 0)
                        {   
                            echo "<div>"; 
                            echo "<input type='checkbox' >Download";
                            echo "</div>";
                            echo "<div class=\"col-xs-4 gallery-item\">";
                            echo "<div class=\"album\">";  
                           }
                        recursivePrintArray($value);
                    }
                    else 
                    {
                        //echo "<li>";
                        //echo "Input key: {$key} Value: {$value}";
                        
                        if($key == "name")
                        {
                            //echo "<br/>".$value."<br/>";   
                          
                        }
                        
                        if($key == "picture")
                        {
                            echo "<img src=\"$value\" style=\"height:200px; width:200px;\">";
                        }

                        if($key == "next")
                        {
                            next_page_picture($value);
                        }   
                        
                        if(strcmp($key, 'count') == 0)
                        {
                            $v=$value;
                            if($value==$v)
                            {
                                
                                echo "</div>";
                               
                                echo "</div>";
                            }
                        }          
                      //  echo "</li>";
                    }
                }
              //  echo"</ul>";
              
                              
            } 
            else
            {
                // This is a string, there is no key to show
                // echo "Input value xxxxxxxx:  {$input}<br/>";
                
               
            }
            
  
        };
        
        //echo "<ul>";
        echo "<div id=\"main\" class=\"container\">";
        echo "<div id=\"gallery\" class=\"row\">";
        recursivePrintArray($retval);
        echo "</div>";
        echo "</div>";
       
       
        

        function next_page_picture($url_next)
        {
                $url=$url_next;
                $header = array("Content-type: application/json");

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                $st = curl_exec($ch);
            
                $retval1 = json_decode($st,true);
                //print_r($retval1);
                pic_display($retval1);
        }

        function pic_display($all_pic)
        {
            if (is_array($all_pic))
            {
                foreach ($all_pic as $key1 => $value1) 
                {
                    if (is_array($value1)) 
                    {
                        //echo "<br/>".$key1."<br/>";
                        pic_display($value1);
                    }
                    else
                    { 
                        if($key1 == "picture")
                        {
                          //echo "<img src=\"$value1\" height=\"100\" width=\"60\" style=\"padding:10;\">";
                            echo "<img src=\"$value1\" style=\"height:200px; width:200px;\">";                                                           
                        }
                        if($key1 == "next")
                        {
                            next_page_picture($value1);
                        }   
                    }
                }
            }   
        }
      

?>

</body>
</html>
