<?php
if(substr_count($_SERVER['HTTP_HOST'],"192.168") ||
    $_SERVER['HTTP_HOST'] == "127.0.0.1" ||
    $_SERVER['HTTP_HOST'] == "gwgroup" ||
    $_SERVER['HTTP_HOST'] == "localhost")
{
    $ambient = "local";
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    $siteUrl = "http://".$_SERVER['HTTP_HOST']."/revolucaobrasileira/rb/wall/";
    $wallUrl = "http://".$_SERVER['HTTP_HOST']."/revolucaobrasileira/rb/account/wall/";
}
elseif(substr_count($_SERVER['HTTP_HOST'],"no-ip"))
{
    $ambient = "local";
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    $siteUrl = "http://samuelpirata.no-ip.info/revolucaobrasileira/rb/wall/";
    $wallUrl = "http://samuelpirata.no-ip.info/revolucaobrasileira/rb/account/wall/";
}
else
{
    $ambient = "publicado";
    error_reporting(0);
    ini_set("display_errors", 0);
    $siteUrl = "http://www.revolucaobrasileira.com.br/wall/";
    $wallUrl = "http://www.revolucaobrasileira.com.br/account/wall/";
}
?>