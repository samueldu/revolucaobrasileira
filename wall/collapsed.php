<?php
/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
*/
include_once 'Wall.php';
include_once 'urls.php';

$Wall = new Wall;

$show_comments_per_page = 3;

$x 	 = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : 0;
$pid = isset($_REQUEST['pid']) ? intval($_REQUEST['pid']) : 0;

if(!@$user_id)
	$user_id = $x;

if($pid)
{
	// Wall counter update
	$currentPage = 0;
	
	$currentPage = isset($_REQUEST['currentPage']) ? intval($_REQUEST['currentPage']) : "";
	
	if(!$currentPage)
	{
		$currentPage = 0;
		$show_comments_per_page = $show_comments_per_page*2;
	}
	else
	{
		$show_comments_per_page = $currentPage*$show_comments_per_page;
	}
	
	$result = $Wall->GetComments( $pid, $show_comments_per_page);
}

$allrows = array();

$comment_num_row = @mysql_num_rows($result);

if($comment_num_row > 0)
{
	while ($rowed = mysql_fetch_array($result)) 
	{
		$allrows[] = $rowed;
	}
	
	$allrows = array_reverse($allrows);	
	
	foreach($allrows as $rows)
	{
		//while ($rows = mysql_fetch_array($result))
		//{
			$flag_already_liked_c = 0;
			
			$nResult = mysql_query("SELECT * FROM walllikes_track WHERE member_id=".$user_id." AND comment_id=".$rows['c_id']);
			if (@mysql_num_rows($nResult))
			{
				$flag_already_liked_c = 1;
			}
            
            //print_R($rows);
			
			$member_avatar = $Wall->getAvatar(@$rows['customer_id'],$rows);?>
			
			<div class="commentPanel" id="record-<?php  echo $rows['c_id'];?>" align="left">
				
				<a href="#"  style="float:left; ">
					<img src="<?php echo $member_avatar;?>" style="float:left; padding-right:9px;" width="40" height="40" border="0" alt="" />
				</a>
				<div class="name pequeno">
				  
					<b>
					   <a href="<?php echo $path.'profile.php?id='.$rows['customer_id'];?>">
						<?php echo $rows['firstname'].' '.$rows['lastname'];?>
					   </a>
					</b>
					<em>
					<?php 
						$pdata = $Wall->tagfunc( $rows['comments'], $rows['tagedpersons']);
						$pdata = str_replace('_(Cc)_(CT)_', '', $pdata);
						
						$pdata = $Wall->add_smileys($pdata);
						
						echo $pdata =  $Wall->clickable_link(@$pdata); ?>
					</em>
				   
					<br clear="all" />
					
					<div class="link_direita">
						<span class="timeanddate" style="color: #777777;  font-size: 11px;">
						<?php
						$days = 0;
						$hours = 0;
						$minutes = 0;
						$seconds = 0;
						
						$days = floor($rows['CommentTimeSpent'] / (60 * 60 * 24)); 
						$remainder = $rows['CommentTimeSpent'] % (60 * 60 * 24);
						$hours = floor($remainder / (60 * 60));
						$remainder = $remainder % (60 * 60);
						$minutes = floor($remainder / 60);
						$seconds = $remainder % 60;
						if($days > 0) 
						{
							$rows['date_created'] = strftime("%d/%m/%Y", $rows['date_created']); 
							echo $rows['date_created'];
						} 
                        elseif($days==1)
                        {
                            echo "Ontem";
                        }
						elseif($days == 0 && $hours == 0 && $minutes == 0)
							echo $txt_fewsecondsago;		
						elseif($hours)
							echo $hours." ".$txt_hoursago;
						elseif($minutes)
							echo $minutes.' '.$txt_minutesago;
						else
							echo $txt_fewsecondsago;	?>
						</span>
					
						<?php
						
						
						
						if(($rows['customer_id'] == $user_id || $rows['customer_id'] == $user_id)){?>
						&nbsp;<a href="#" id="CID-<?php  echo $rows['c_id'];?>" class="c_delete"><?=$txt_post_delete?></a>
						 <?php
						}?>
						<span class="curtir_azul" id="clike-panel-<?php  echo $rows['c_id']?>">
						<?php if (@$flag_already_liked_c == 0) {?>
							
							<a href="javascript: void(0)" id="post_id<?php  echo $rows['c_id']?>" onclick="javascript: Clikethis(<?php echo $user_id?>,<?php  echo $rows['c_id']?>,1);"><?=$txt_up?></a>
						<?php }else {?>
						   
							<a href="javascript: void(0)" id="post_id<?php  echo $rows['c_id']?>" onclick="javascript: Clikethis(<?php echo $user_id?>,<?php  echo $rows['c_id']?>,2);"><?=$txt_down?></a> 
						<?php }?>
						</span>
					</div>
					<div class="showPpl pplLikes" id="ppl_clike_div_<?php  echo $rows['c_id']?>" <?=((@$rows['clikes']) ? 'style="float:left;padding-top:5px;"' : 'style="display:none;padding-top:5px;float:left;"')?>>
						&nbsp;<a class="t" href="javascript:;" onclick="showCList(<?php  echo $rows['c_id']?>);">
						<span id="clike-stats-<?php  echo $rows['c_id']?>"> <?php echo $rows['clikes'];?> </span> 
						<?=(($rows['clikes']>1) ? $txt_ppl_likes : $txt_ppl_like_single)?>
						   </a>
						<span><?=$txt_like_it?></span>
					</div>
					<br clear="all" />
				</div>
				<br clear="all" />
			</div>
		<?php
		//}
	}
}?>
<script>
parent.resizeFrame('childframe');
</script>