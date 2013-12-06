<?php
/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
*/
include_once 'Wall.php';
include_once('urls.php');

$Wall = new Wall;

$member_id = isset($_REQUEST['member_id']) && is_numeric($_REQUEST['member_id']) ? intval($_REQUEST['member_id']) : '';
$entry_id = isset($_REQUEST['post_id']) && is_numeric($_REQUEST['post_id']) ? intval($_REQUEST['post_id']) : '';
$raction = isset($_REQUEST['action']) ? intval($_REQUEST['action']) : "";

$likes = 0;
if(@$raction == 1)
{
	$result = mysql_query("update wallposts set likes=likes+1 where p_id= ".$entry_id);
	$result = mysql_query("INSERT INTO walllikes_track (post_id,member_id) VALUES('".$entry_id."','".$member_id."')");
	
	$result = mysql_query("SELECT * FROM wallposts where p_id = ".$entry_id." ");
	if (mysql_num_rows($result) > 0)
	{
		while( $obj = @mysql_fetch_array($result) )
		{
			$likes 	= $obj['likes'];
		}
	}
	
	echo $likes;
}
else if(@$raction == 2)
{
	$result = mysql_query("update wallposts set likes=likes-1 where p_id= ".$entry_id);
	$result = mysql_query("delete from walllikes_track where post_id=".$entry_id." and member_id=".$member_id);
	
	$result = mysql_query("SELECT * FROM wallposts where p_id = ".$entry_id." ");
	if (mysql_num_rows($result) > 0)
	{
		while( $obj = @mysql_fetch_array($result) )
		{
			$likes 	= $obj['likes'];
		}
	}
	
	echo $likes;
}
else if(@$raction == 3)
{
	$result = mysql_query("SELECT wallusers.*,wallusers.mem_id as uid,walllikes_track.* FROM wallusers, walllikes_track where walllikes_track.post_id = ".$entry_id." and wallusers.mem_id = walllikes_track.member_id");

	$html = '<div>'.$txt_norec_found;
	
	if (mysql_num_rows($result))
	{
		$html = '<div style="height:350px; overflow-y:scroll;">';
		
		while( $row = mysql_fetch_array($result) )
		{
			$post_avatars = $Wall->getAvatar($row['uid']);
			
			$html .= '<div style="margin:8px;"><a href="#" style="cursor: pointer;color: #8E0000;-moz-outline-style: none;float:left"><img height="50" width="50" border="0" src="'.$post_avatars.'" /></a> <a href="#" style="cursor: pointer;color: #8E0000;-moz-outline-style: none;margin-top:8px; height:40px;vertical-align: middle; float:left;font-size:14px; font-weight:bold; margin-left:12px;">'.$row['mem_fname'].' '.$row['mem_lname'] .'</a></div><br clear="all" />';
			
		}
	}
	
	echo $html.'</div>';
}


?>