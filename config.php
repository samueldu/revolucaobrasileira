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

if(isset($_SESSION["xml_config"]) && !empty($_SESSION["xml_config"])){
	$xml = simplexml_load_file($_SESSION["xml_config"]);
}else{
	$_SESSION["xml_config"] = str_replace("index.php","",$_SERVER['SCRIPT_FILENAME'])."config/default.xml";
	$xml = simplexml_load_file($_SESSION["xml_config"]);
}

if($ambient == "local")
{
	$var = $xml->local;
}
else
{
	$var = $xml->public;
}


$var->loja->base_url = str_replace("{base_url}", $_SERVER['HTTP_HOST'], $var->loja->base_url);
$var->loja->logo = str_replace("{base_url}", $_SERVER['HTTP_HOST'], $var->loja->logo);

define("ambient",$ambient);
define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', $var->database->host);
define('DB_USERNAME', $var->database->user);
define('DB_PASSWORD', $var->database->pass);
define('DB_DATABASE', $var->database->base);
define('DB_PREFIX', '');

define('TEMPLATE',$var->loja->template);

define('BASE_DIR',$var->loja->base_dir);
define('BASE_URL',$var->loja->base_url);
define('NOME_LOJA',$var->loja->name);


define("URL_TEMPLATE",$var->loja->base_url.'catalog/view/theme/'.TEMPLATE.'/template/');

define("URL_JAVASCRIPT",$var->loja->base_url.'catalog/view/javascript/');

define('DIR_APPLICATION', BASE_DIR.'catalog/');
define('DIR_SYSTEM', BASE_DIR.'system/');
define('DIR_DATABASE', BASE_DIR.'system/database/');
define('DIR_LANGUAGE', BASE_DIR.'catalog/language/');
define('DIR_TEMPLATE', BASE_DIR.'catalog/view/theme/');
define('DIR_CONFIG', BASE_DIR.'system/config/');
define('DIR_IMAGE', DIR_TEMPLATE.TEMPLATE.'/image/');    
define('DIR_CACHE', BASE_DIR.'system/cache/');
define('DIR_DOWNLOAD', BASE_DIR.'download/');
define('DIR_LOGS', BASE_DIR.'system/logs/'); 
define('HTTP_SERVER', BASE_URL);               
define('HTTP_IMAGE', BASE_URL."catalog/view/theme/".TEMPLATE."/image/");

define('DIR_JS', 'catalog/view/javascript/');
define('DIR_CSS','catalog/view/theme/'.TEMPLATE.'/stylesheet/');
/*


define('HTTPS_SERVER', BASE_URL);

define('HTTP_IMAGE', BASE_URL."catalog/view/theme/".TEMPLATE."/image/");
*/
?>