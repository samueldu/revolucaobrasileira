<?php
/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
*/
include_once 'Wall.php';
include_once('urls.php');

$Wall = new Wall;

$x = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : 0;
$comment_text = isset($_REQUEST['comment_text']) ? trim($_REQUEST['comment_text']) : '';
$post_id = isset($_REQUEST['post_id']) ? intval($_REQUEST['post_id']) : 0;
$answer = isset($_REQUEST['answer']) ? $_REQUEST['answer'] : 0;
$tagged = isset($_REQUEST['tagged']) ? $_REQUEST['tagged'] : 0;


if(!@$user_id)
	$user_id = $x;

if( $post_id )
{
	$Wall->PublishComment( $comment_text, $post_id, $user_id,$tagged,$answer);
	$result = $Wall->GetComments( $post_id, 1);
} 

while ($rows = mysql_fetch_array($result))
{
	$member_avatar = $Wall->getAvatar($user_id,$rows);
	
	
	?>
	
	<div class="commentPanel" id="record-<?php  echo $rows['c_id'];?>" align="left">
		
		<a href="#" style="float:left">
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
			$pdata = $Wall->tagfunc($rows['comments'], $rows['tagedpersons']);
			$pdata = str_replace('_(Cc)_(CT)_', '', $pdata);
			
			$pdata = $Wall->add_smileys($pdata);
			 
			echo $pdata =  $Wall->clickable_link($pdata); ?>
		   </em>
		   
		   <br clear="all" />

			<!--<br clear="all" />-->
			<div style=" padding-top:4px;">
				<span class="timeanddate" style="color: #777777;font-size: 11px;">
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
					$rows['date_created'] = strftime("%b %e %Y", $rows['date_created']); 
					echo $rows['date_created'];
				} 
				elseif($days == 0 && $hours == 0 && $minutes == 0)
					echo "a alguns segundos";		
				elseif($hours)
					echo $hours.' horas';
				elseif($minutes)
					echo $minutes.' mintuso';
				else
					echo "a alguns segundos";	?>
					
				</span>
				<?php
				if(($rows['customer_id'] == $user_id || $rows['customer_id'] == $user_id)){?>
				&nbsp;<a href="#" id="CID-<?php  echo $rows['c_id'];?>" class="c_delete"><?=$txt_post_delete?></a>
				<?php
				}?>  
				<span id="clike-panel-<?php  echo $rows['c_id']?>">
				<?php if (@$flag_already_liked_c == 0) {?>
					
					<a href="javascript: void(0)" id="post_id<?php  echo $rows['c_id']?>" onclick="javascript: Clikethis(<?php echo $user_id?>,<?php  echo $rows['c_id']?>,1);"><?=$txt_up?></a>
				<?php }else {?>
				   
					<a href="javascript: void(0)" id="post_id<?php  echo $rows['c_id']?>" onclick="javascript: Clikethis(<?php echo $user_id?>,<?php  echo $rows['c_id']?>,2);"><?=$txt_down?></a>
				<?php }?>
				</span>
			</div>
			<div class="pplLikes" id="ppl_clike_div_<?php  echo $rows['c_id']?>" <?=((@$rows['clikes']) ? 'float:left;padding-top:5px;' : 'style="display:none;float:left;padding-top:5px;"')?>>
				 &nbsp;<a class="t" href="javascript:;" onclick="showCList(<?php  echo $rows['c_id']?>);">
				<span id="clike-stats-<?php  echo $rows['c_id']?>"> <?php echo $rows['clikes'];?> </span> <?=$txt_ppl_likes?>
				   </a>
				<span><?=$txt_like_it?></span>
			</div>
			<br clear="all" />
		</div>
		<br clear="all" />
	</div>
<?php
}?>	

		
		
		
		