<?php
session_start();
// DIR
if(isset($_SESSION["xml_config"]) && !empty($_SESSION["xml_config"])){
	$xml = simplexml_load_file($_SESSION["xml_config"]);     
}else{
	$_SESSION["xml_config"] = $_SERVER["DOCUMENT_ROOT"].$_SERVER['REQUEST_URI']."../config/default.xml";
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

// HTTP
define('HTTP_SERVER', BASE_URL.'admin/');
define('HTTP_CATALOG', BASE_URL.'');
define('HTTP_IMAGE', BASE_URL.'catalog/view/theme/'.TEMPLATE.'/image/'); 

// HTTPS
define('HTTPS_SERVER', BASE_URL.'admin/');
define('HTTPS_IMAGE', BASE_URL.'catalog/view/theme/'.TEMPLATE.'/image/');

// DIR
define('DIR_APPLICATION', BASE_DIR.'admin/');
define('DIR_SYSTEM', BASE_DIR.'system/');
define('DIR_DATABASE', BASE_DIR.'system/database/');
define('DIR_LANGUAGE', BASE_DIR.'admin/language/');
define('DIR_TEMPLATE', BASE_DIR.'admin/view/template/');
define('DIR_CONFIG', BASE_DIR.'system/config/');
define('DIR_IMAGE', BASE_DIR.'catalog/view/theme/'.TEMPLATE.'/image/');               
define('DIR_CACHE', BASE_DIR.'system/cache/');
define('DIR_DOWNLOAD', BASE_DIR.'download/');
define('DIR_LOGS', BASE_DIR.'system/logs/');
define('DIR_CATALOG', BASE_DIR.'catalog/');

define('DIR_TEMPLATE_CATALOG', BASE_DIR.'catalog/view/theme/');      

?>