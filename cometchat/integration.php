<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */

define('SET_SESSION_NAME','');			// Session name
define('DO_NOT_START_SESSION','0');		// Set to 1 if you have already started the session
define('DO_NOT_DESTROY_SESSION','0');	// Set to 1 if you do not want to destroy session on logout
define('SWITCH_ENABLED','0');		
define('INCLUDE_JQUERY','1');	
define('FORCE_MAGIC_QUOTES','0');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(substr_count($_SERVER['HTTP_HOST'],"192.168") ||
    $_SERVER['HTTP_HOST'] == "127.0.0.1" ||
    $_SERVER['HTTP_HOST'] == "gwgroup" ||
    $_SERVER['HTTP_HOST'] == "localhost")
{
    $ambient = "local";
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    define('DB_SERVER',					'localhost'								);
    define('DB_PORT',					'3306'									);
    define('DB_USERNAME',				'root'									);
    define('DB_PASSWORD',				'vertrigo'								);
    define('DB_NAME',					'revolucao'								);
    define('TABLE_PREFIX',				''										);
    define('DB_USERTABLE',				'customer'									);
    define('DB_USERTABLE_NAME',			'firstname'								);
    define('DB_USERTABLE_USERID',		'customer_id'								);
    define('DB_USERTABLE_LASTACTIVITY',	'lastactivity'							);
}
elseif(substr_count($_SERVER['HTTP_HOST'],"no-ip"))
{
    $ambient = "local";
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    define('DB_SERVER',					'localhost'								);
    define('DB_PORT',					'3306'									);
    define('DB_USERNAME',				'root'									);
    define('DB_PASSWORD',				'vertrigo'								);
    define('DB_NAME',					'revolucao'								);
    define('TABLE_PREFIX',				''										);
    define('DB_USERTABLE',				'customer'									);
    define('DB_USERTABLE_NAME',			'firstname'								);
    define('DB_USERTABLE_USERID',		'customer_id'								);
    define('DB_USERTABLE_LASTACTIVITY',	'lastactivity'							);

}
else
{
    $ambient = "publicado";
    error_reporting(0);
    ini_set("display_errors", 0);
    define('DB_SERVER',					'localhost'								);
    define('DB_PORT',					'3306'									);
    define('DB_USERNAME',				'revheavy'									);
    define('DB_PASSWORD',				'123456789KKl321'								);
    define('DB_NAME',					'revolucao'								);
    define('TABLE_PREFIX',				''										);
    define('DB_USERTABLE',				'customer'									);
    define('DB_USERTABLE_NAME',			'firstname'								);
    define('DB_USERTABLE_USERID',		'customer_id'								);
    define('DB_USERTABLE_LASTACTIVITY',	'lastactivity'							);
}




function getUserID() {
	$userid = 0;
	
	GLOBAL $_SESSION;
	
	if (!empty($_SESSION['customer_id'])) {
		$userid = $_SESSION['customer_id'];
	}

	return $userid;
}


function getFriendsList($userid,$time) {
	$sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, 
	".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, 
	".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity, 
	".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." link, 
    ".TABLE_PREFIX.DB_USERTABLE.".facebook_id avatar, cometchat_status.message, cometchat_status.status 
	from ".TABLE_PREFIX."cometchat_friends 
	join ".TABLE_PREFIX.DB_USERTABLE." on  ".TABLE_PREFIX."cometchat_friends.toid = ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID."  and confirm = '1'
	left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid 
	where ".TABLE_PREFIX."cometchat_friends.fromid = '".mysql_real_escape_string($userid)."' order by username asc");
	
	//print $sql;
	
	//exit;
	
	return $sql;
}

function getUserDetails($userid) {
	$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity,  ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." link,  ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." avatar, cometchat_status.message, cometchat_status.status from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");
	return $sql;
}

function updateLastActivity($userid) {
	$sql = ("update `".TABLE_PREFIX.DB_USERTABLE."` set ".DB_USERTABLE_LASTACTIVITY." = '".getTimeStamp()."' where ".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");
	return $sql;
}

function getUserStatus($userid) {
	 $sql = ("select cometchat_status.message, cometchat_status.status from cometchat_status where userid = '".mysql_real_escape_string($userid)."'");
	 return $sql;
}

function getLink($link) {
	return 'account/wall/?id_wall='.$link."&origem=4";
}

function getAvatar($image) {
    
        $imageUser = "https://graph.facebook.com/".$image."/picture?width=50&height=50";
        
        return $imageUser;
        
        /*
    
    
	if (is_file(dirname(dirname(__FILE__)).'/images/'.$image.'.gif')) {
		return 'images/'.$image.'.gif';
	} else {
		return 'images/noavatar.gif';
	}
    */
}


function getTimeStamp() {
	return time();
}

function processTime($time) {
	return $time;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* HOOKS */

function hooks_statusupdate($userid,$statusmessage) {
	
}

function hooks_forcefriends() {
	
}

function hooks_activityupdate($userid,$status) {

}

function hooks_message($userid,$unsanitizedmessage) {
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LICENSE */

include_once(dirname(__FILE__).'/license.php');
$x="\x62a\x73\x656\x34\x5fd\x65c\157\144\x65";
eval($x('JHI9ZXhwbG9kZSgnLScsJGxpY2Vuc2VrZXkpOyRwXz0wO2lmKCFlbXB0eSgkclsyXSkpJHBfPWludHZhbChwcmVnX3JlcGxhY2UoIi9bXjAtOV0vIiwnJywkclsyXSkpOw'));

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 