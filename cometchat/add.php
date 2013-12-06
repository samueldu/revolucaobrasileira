<?
require("integration.php");

$dbh = mysql_connect(DB_SERVER.':'.DB_PORT,DB_USERNAME,DB_PASSWORD);
if (!$dbh) {
	echo "<h3>Unable to connect to database. Please check details in configuration file.</h3>";
	exit();
}
mysql_selectdb(DB_NAME,$dbh);
mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");

$result = mysql_query("select * from cometchat_friends where toid = '".$_POST['toid']."' and fromid = '".$_POST['fromid']."'");

if(mysql_num_rows($result) == 0)
{
	mysql_query("insert into cometchat_friends (toid,fromid) values ('".$_POST['toid']."','".$_POST['fromid']."')");
}
?>
