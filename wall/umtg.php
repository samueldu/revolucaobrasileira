<?php
/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
*/
include_once 'Wall.php';
include_once 'urls.php';

$Wall = new Wall;

$um = isset($_GET['um']) ? trim($_GET['um']) :"";
$um = preg_replace('/]*>([\s\S]*?)<\/script[^>]*>/', '', $um); // My addings!
$um = preg_replace(array("/\=/","/\#/","/\sOR\s/"), "", $um); // My addings!

if($um)
{
	$q=$um;
	$q = str_replace("%20"," ",$q);
	
	$matches = $Wall->returnFreinds($_COOKIE['mem_id']);
	
	$sql_res=mysql_query("select * from wallusers where (mem_fname like '%$q%' or mem_lname like '%$q%' or concat_ws(' ',mem_fname, mem_lname) like '%$q%') and active=1 and (mem_id IN (".$matches.") or username= '".$_COOKIE['username']."') order by mem_id LIMIT 7");
	
	while($row=mysql_fetch_array($sql_res))
	{
		$fname=$row['mem_fname'];
		$lname=$row['mem_lname'];
		$img=$row['mem_pic']; 
		$ava = $Wall->getAvatar($row['mem_id']);?>
        
		<div class="each_tag_user" onclick="taglistPosts('<?php echo $fname; ?><?php echo (($lname) ? "&nbsp;".$lname : ""); ?>',<?php echo $row['username']; ?>)">
            <img src="<?php echo $ava; ?>" border="0" alt="" style="float:left; margin-right:10px;" width="40" height="40" />
            <a href="#" class="tagUserlink" title='<?php echo $fname; ?><?php echo (($lname) ? "&nbsp;".$lname : ""); ?>'>
            <?php echo $fname; ?><?php echo (($lname) ? "&nbsp;".$lname : ""); ?> </a>
		</div>
		<?php
	}
	
	if(!@mysql_num_rows($sql_res))
	echo 'Couldnt find a match on '.$um.'';
}
else
{
	echo 'invalid'; exit;
}?>

