<?php if (!session_id()) session_start();?>
<?php
/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
*/
include('urls.php');

 if(@$_SESSION['wall_login'] == 1)
 {
	$_SESSION['id_user']  	= 0;
	$_SESSION['mem_email'] 	= '';
	$_SESSION['mem_fname']  = '';
	$_SESSION['mem_lname']  = '';
	
	$_SESSION['gender']  	= '';
	$_SESSION['mem_pic'] 	= '';
	@$_COOKIE['username'] = '';
	$_SESSION['wall_login'] = 0;
	session_unset();
 }
 header('Location: '.$siteUrl.'home.php?logout=true');
?>