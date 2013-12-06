<?php
/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
*/
include_once 'Wall.php';
include_once('urls.php');

$Wall = new Wall;

$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

if($id)
{
	$Wall->DeleteWallPost($id);
}
	
	
?>