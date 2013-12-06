<?php

if(substr_count($_SERVER['HTTP_HOST'],"192.168") ||
    substr_count($_SERVER['HTTP_HOST'],"no-ip") ||
    $_SERVER['HTTP_HOST'] == "200.175.198.99" ||
    $_SERVER['HTTP_HOST'] == "127.0.0.1" ||
    $_SERVER['HTTP_HOST'] == "gwgroup" ||
    $_SERVER['HTTP_HOST'] == "localhost")
{
    $ambient = "local";
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}
else
{
    $ambient = "publicado";
    error_reporting(0);
    ini_set("display_errors", 0);
}

$var = explode("/",$_SERVER['SCRIPT_FILENAME']);

$url = str_replace(end($var),"",$_SERVER['SCRIPT_FILENAME'].'../config/default.xml');

    $xml = simplexml_load_file($url);

    if($ambient == "local")
    {
        $var = $xml->local;
    }
    else
    {
        $var = $xml->public;
    }

    $database_server = (string)$var->database->host;
    $login = (string)$var->database->user;
    $dbpassword = (string)$var->database->pass;
    $database_name = (string)$var->database->base;

// image extensions allowed
$valid_formats_img = array("jpg", "png", "gif", "bmp","jpeg");
// video type allowed
$valid_formats_vid = array("flv","mp4","avi");

// image upload size limit  
// please note if you have some upload size restriction on server then this will not effect.
$image_size_limit = 5000; // 5 MB
$videos_size_limit = 5000; // 5 MB


#############################################
############# Leave the below area as it is.

if(!($link=mysql_connect($database_server, $login, $dbpassword )))
{
	sprintf("Error %d:%s\n", mysql_errno(),mysql_error());
}	
@mysql_select_db($database_name,$link);	


################### 

?>
