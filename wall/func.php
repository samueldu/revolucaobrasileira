<?php
/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
*/
include('newCon.php');

$rtype = isset($_REQUEST['type']) ? intval($_REQUEST['type']) : "";

if( @$rtype == 1)
{
	$username_get = mysql_query("SELECT * from wallusers where mem_email = '".$_REQUEST['email']."' order by mem_email desc limit 1");
	$num = @mysql_num_rows(@$username_get);
	
	if($num > 0)
		echo 1;
	else
		echo 0;
	
}
else if( @$rtype == 2)
{
	$username_get = mysql_query("SELECT * from wallusers where mem_email = '".$_REQUEST['email']."' and mem_id != ".$_REQUEST['memberid']." order by mem_email desc limit 1");
	$num = @mysql_num_rows(@$username_get);
	
	if($num > 0)
		echo 1;
	else
		echo 0;
	
}
else if( @$rtype == 3)
{
	$mem_lname = isset($_POST['mem_lname']) ? trim($_POST['mem_lname']) : "";
	$mem_lname = strip_tags($mem_lname);
	$mem_fname = isset($_POST['mem_fname']) ? trim($_POST['mem_fname']) : "";
	$mem_lname = strip_tags($mem_fname);
	$memberid  = isset($_POST['memberid']) ? intval($_POST['memberid']) : "";
	$password  = isset($_POST['password']) ? trim($_POST['password']) : "";
	$mem_lname = strip_tags($password);	

	if(intval($memberid)){
	
	if($password == "")
	{
		mysql_query("update wallusers set mem_lname='".$mem_lname."',mem_fname='".$mem_fname."' where mem_id = ".$_REQUEST['memberid']);
	}
	else
	{
		mysql_query("update wallusers set mem_lname='".$mem_lname."',mem_fname='".$mem_fname."',mem_pass='".md5($password)."' where mem_id = ".$_REQUEST['memberid']);	
	}
  } else { return false; }
}

?>