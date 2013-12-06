<?php

//print_R($_SERVER);

//header("Content-encoding: gzip");
//ob_start("ob_gzhandler");



/* anti_injection */
function TrimArray($string){
 
	if (!is_array($string))
	{
		$string = str_ireplace(" or ", "", $string);
		$string = str_ireplace("select", "", $string);
		$string = str_ireplace("delete", "", $string);
		$string = str_ireplace("create", "", $string);
		$string = str_replace("#", "", $string);
		$string = str_replace("=", "", $string);
		$string = str_replace("--", "", $string);
		$string = str_replace(";", "", $string);
		$string = str_replace("*", "", $string);
		$string = trim($string);
		$string = strip_tags($string);
		$string = addslashes($string);
		return trim($string);
	}
 
	return array_map('TrimArray', $string);
}


TrimArray($_POST);
TrimArray($_GET);

// Version
define('VERSION', '1.4.9.1');

// Configuration
require_once('config.php');

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Application Classes
require_once(DIR_SYSTEM . 'library/customer.php');
require_once(DIR_SYSTEM . 'library/currency.php');
require_once(DIR_SYSTEM . 'library/tax.php');
require_once(DIR_SYSTEM . 'library/weight.php');
require_once(DIR_SYSTEM . 'library/length.php');
require_once(DIR_SYSTEM . 'library/cart.php');      

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$registry->set('config', $config);

// Database 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Settings
$query = $db->query("SELECT * FROM " . DB_PREFIX . "setting");

foreach ($query->rows as $setting) {
	if($setting['key'] == 'config_url'){
		$config->set($setting['key']."_admin", $setting['value']);
		$setting['value'] = str_replace('{url_base}', $_SERVER['HTTP_HOST'], $setting['value']);
	}
	$config->set($setting['key'], $setting['value']);
}



// Store
$query = $db->query("SELECT * FROM " . DB_PREFIX . "store WHERE url = '" . $db->escape('http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/') . "' OR url = '" . $db->escape('http://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/') . "'");

foreach ($query->row as $key => $value) {
	$config->set('config_' . $key, $value);
}

$config->set('config_template', TEMPLATE);
  
if ($config->get('config_ssl')) {
	define('HTTPS_SERVER', 'https://' . substr($config->get('config_url'), 7));
	define('HTTPS_IMAGE',  'https://' . substr($config->get('config_url'), 7).'catalog/view/theme/'.TEMPLATE.'/image/'); 	
} else {
	define('HTTPS_SERVER', HTTP_SERVER);
	define('HTTPS_IMAGE', HTTP_IMAGE);	
}


// Log 
$log = new Log($config->get('config_error_filename'));
$registry->set('log', $log);

// Error Handler
function error_handler($errno, $errstr, $errfile, $errline) {
	global $config, $log;
	
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$error = 'Warning';
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
		default:
			$error = 'Unknown';
			break;
	}
		
	if ($config->get('config_error_display')) {
		echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}
	
	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	return TRUE;
}

// Error Handler
set_error_handler('error_handler');

// Request
$request = new Request();
$registry->set('request', $request);
 
// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$registry->set('response', $response); 

// Cache
$registry->set('cache', new Cache());

// Session
$session = new Session();
$registry->set('session', $session);
	
// Document
$registry->set('document', new Document());
						
// Language Detection
$languages = array();

$query = $db->query("SELECT * FROM " . DB_PREFIX . "language"); 

foreach ($query->rows as $result) {
	$languages[$result['code']] = array(
		'language_id' => $result['language_id'],
		'name'        => $result['name'],
		'code'        => $result['code'],
		'locale'      => $result['locale'],
		'directory'   => $result['directory'],
		'filename'    => $result['filename']
	);
}

$detect = '';

if (isset($request->server['HTTP_ACCEPT_LANGUAGE']) && ($request->server['HTTP_ACCEPT_LANGUAGE'])) { 
	$browser_languages = explode(',', $request->server['HTTP_ACCEPT_LANGUAGE']);
	
	foreach ($browser_languages as $browser_language) {
		foreach ($languages as $key => $value) {
			$locale = explode(',', $value['locale']);

			if (in_array($browser_language, $locale)) {
				$detect = $key;
			}
		}
	}
}

if (isset($_GET['language']) && array_key_exists($_GET['language'], $languages)) {
	$code = $_GET['language'];
} elseif (isset($session->data['language']) && array_key_exists($session->data['language'], $languages)) {
	$code = $session->data['language'];
} elseif (isset($request->cookie['language']) && array_key_exists($request->cookie['language'], $languages)) {
	$code = $request->cookie['language'];
} elseif ($detect) {
	$code = $detect;
} else {
	$code = $config->get('config_language');
}

if (!isset($session->data['language']) || $session->data['language'] != $code) {
	$session->data['language'] = $code;
}

if (!isset($request->cookie['language']) || $request->cookie['language'] != $code) {	  
	setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $request->server['HTTP_HOST']);
}			

$config->set('config_language_id', $languages[$code]['language_id']);
$config->set('config_language', $languages[$code]['code']);

// Language		
$language = new Language($languages[$code]['directory']);
$language->load($languages[$code]['filename']);	
$registry->set('language', $language);

// Customer
$registry->set('customer', new Customer($registry));

// Currency
$registry->set('currency', new Currency($registry));

// Tax
$registry->set('tax', new Tax($registry));

// Weight
$registry->set('weight', new Weight($registry));

// Length
$registry->set('length', new Length($registry));

// Cart
$registry->set('cart', new Cart($registry));

// Front Controller 
$controller = new Front($registry);

// Maintenance Mode
$controller->addPreAction(new Action('common/maintenance/check'));

// SEO URL's
$controller->addPreAction(new Action('common/seo_url'));

// Router
if (isset($request->get['route'])) {
	$action = new Action($request->get['route']);
} else {
	$action = new Action('common/home');
}

// Dispatch
$controller->dispatch($action, new Action('error/not_found'));

//print_r($_SESSION);   

// Output

//ob_flush();

$response->output();

//ob_flush();


function wall($id,$origem)
{

    if(isset($_SESSION['customer_id']))
        $customer = $_SESSION['customer_id'];
    else
        $customer = 0;

    if($origem != 7)
    print '<iframe frameborder="0" src="./wall/profile.php?id_wall='.$id.'&origem='.$origem.'&id='.$customer.'" name="childframe" width="100%" id="childframe"></iframe>';
    else
    print '<iframe frameborder="0" src="./wall/debate.php?id_wall='.$id.'&origem='.$origem.'&id='.$customer.'" name="childframe" width="100%" id="childframe"></iframe>';


}

function debug($var){
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

function curPageURL() {
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"])  and $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
?>