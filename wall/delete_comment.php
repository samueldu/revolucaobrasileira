<?php
/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
*/
include_once 'Wall.php';
include_once 'urls.php';

$Wall = new Wall;

$c_id = isset($_REQUEST['c_id']) ? intval($_REQUEST['c_id']) : 0;

if($c_id)
{
	$Wall->DeleteCommment($c_id);
}
?>