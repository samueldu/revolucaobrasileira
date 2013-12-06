<script> $(document).ready(function(){	 $('.commentMark').elastic(); });	</script>
<script type="text/javascript" src="jquery.oembed.js"></script>
<?php
/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
*/
include_once 'Wall.php';
include_once('urls.php');

if(isset($_GET['id']))
$_SESSION['id_user'] = $_GET['id'];


$Wall = new Wall;

$path 					= $siteUrl;
$show_comments_per_page = 3;
$next_records 			= 10;
$show_more_button 		= 0;
$logged_user_pic 		= '';
$loggedIn 				= 0;

$x = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : 0;  
$user_id = @isset($_SESSION['id_user']) ? intval($_SESSION['id_user']) : 0;
$logged_id = @isset($_SESSION['id_user']) ? intval($_SESSION['id_user']) : 0;
$Tagged = @$_POST['Tagged'] ? $_POST['Tagged'] : "";

$ActionSimp	= isset($_REQUEST['value']) ? trim($_REQUEST['value']) : "";
$ActionUrl  = isset($_REQUEST['title']) ? trim($_REQUEST['title']) : "";
$ActionImg  = isset($_REQUEST['image_url']) ? trim($_REQUEST['image_url']) : "";
$ActionMore = isset($_REQUEST['show_more_post']) ? trim($_REQUEST['show_more_post']) : "";

//if(@$x)
//include('newCon.php');

if(!$user_id)
	$user_id = $x;
if(!$logged_id)
	$logged_id = $x;

$member_avatar = $Wall->getAvatar($logged_id);

if( $ActionSimp )
{
	$user_id   = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : "";
	$posted_on = isset($_REQUEST['p']) ? trim($_REQUEST['p']) : "";
	$Post 	   = isset($_REQUEST['value']) ? trim($_REQUEST['value']) : "";
	
	$loggedIn  = 1;
	
	$Wall->PublishToWall($Post, $posted_on, $user_id, false, false, false, false, false, false, false, false, $Tagged);
	
	$result = $Wall->GetSinglePost($user_id );
}
else if( $ActionUrl )
{
	$videoType = 0;
	
	$user_id = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : "";
	$posted_on = isset($_REQUEST['p']) ? trim($_REQUEST['p']) : "";
	$videoType = isset($_REQUEST['vtype']) ? trim($_REQUEST['vtype']) : "";
	$Post = isset($_REQUEST['v']) ? trim($_REQUEST['v']) : "";	
	$title = isset($_REQUEST['title']) ? trim($_REQUEST['title']) : "";
	$url = isset($_REQUEST['url']) ? trim($_REQUEST['url']) : "";
	$description = isset($_REQUEST['desc']) ? trim($_REQUEST['desc']) : "";
	$cur_image = isset($_REQUEST['cur_image']) ? trim($_REQUEST['cur_image']) : "";
	$youtube = isset($_REQUEST['youtube']) ? trim($_REQUEST['youtube']) : "";
	
	$loggedIn = 1;
	$post_type = 1; // link only 
	
	$Wall->PublishToWall($Post, $posted_on, $user_id, $title, $url, $description, $cur_image, $post_type, $videoType, $youtube, false, $Tagged);
	
	$result = $Wall->GetSinglePost($user_id );
}
else if( $ActionImg )
{
	$user_id = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : "";
	$posted_on = isset($_REQUEST['p']) ? trim($_REQUEST['p']) : "";
	$Post = isset($_REQUEST['v']) ? trim($_REQUEST['v']) : "";
	$media = isset($_REQUEST['video']) ? trim($_REQUEST['video']) : "";
	$image_url = isset($_REQUEST['image_url']) ? trim($_REQUEST['image_url']) : "";
	
	$post_type = 2;
	$loggedIn = 1;
	
	$Wall->PublishToWall($Post, $posted_on, $user_id, false, false, false, $image_url, $post_type, false, false, $media, $Tagged);
	
	$result = $Wall->GetSinglePost($user_id );
}
elseif( $ActionMore) // more posting paging
{
	$next_records = $_REQUEST['show_more_post'] + 10;
	$posted_on = isset($_REQUEST['p']) ? intval($_REQUEST['p']) : "";
	$show_more_post = isset($_REQUEST['show_more_post']) ? intval($_REQUEST['show_more_post']) : 0;
	
	$show_more_button = 0; // button in the end
	$loggedIn = 1;
	
	$matches = $Wall->returnFreinds(intval(@$user_id));	
	$result = $Wall->GetPublicPosts($matches, $user_id, $show_more_post );
	
	$check_res = $Wall->GetPublicPostsNext($matches, $user_id, $next_records );

	if(@$check_result > 0)
	{
		$show_more_button = 1;
	}
}
else
{	
	$show_more_button = 1;
	
	$matches = $Wall->returnFreinds($user_id);	
	$result = $Wall->GetPublicPosts($matches, $user_id, 0 );  
	
	print $user_id;  
}

$Random = rand(12546,88547);

while ($row = @mysql_fetch_array($result))
{
	$flag_already_liked = 0;
	
	$nResult = mysql_query("SELECT * FROM walllikes_track WHERE member_id = ".$user_id." AND post_id = ".$row['p_id']);
	
	if (@mysql_num_rows($nResult))
	{
		$flag_already_liked = 1;
	}
	
	$comments = $Wall->GetComments( $row['p_id'], $show_comments_per_page);
	$comments_counts = $Wall->CountComments( $row['p_id']);
	$number_of_comments = $comments_counts; 
	
	echo '<div>
	<div class="friends_area" id="record-'.$row['p_id'].'">';

			if($row['userid'] == $row['posted_by'])
			{
				$post_avatar = $Wall->getAvatar($row['posted_by']);?>
				
				<a href="<?php echo $path.'profile.php?id='.$row['username'];?>">
					<img src="<?php echo $post_avatar;?>" style="float:left; padding-right:9px;" width="50" height="50" border="0" alt="" />
				</a>
				<label style="float:left; width:400px;" class="name">
				<b>
				   <a href="<?php echo $path.'profile.php?id='.$row['username'];?>">
					<?php echo $row['mem_fname'].' '.$row['mem_lname'];
				  echo '</a>
				</b>';
			}
			else
			{
				$username_gets = mysql_query("SELECT * from wallusers where mem_id=".$row['posted_by']." order by mem_id desc limit 1");
				while ($names = @mysql_fetch_array($username_gets))
				{
					$user_avatar_2 = $names['mem_pic'];
					$username_2 = $names['username'];
					$user_id_2 = $names['mem_id'];
					$fname_2 = $names['mem_fname'].' '.$names['mem_lname'];
				}
				
				$s_post_avatar = $Wall->getAvatar($row['posted_by']);?>
				
				<a href="<?php echo $path.'profile.php?id='.$username_2;?>">
					<img src="<?php echo $s_post_avatar;?>" style="float:left; padding-right:9px;" width="50" height="50" border="0" alt="" />
				</a>
				<label style="float:left; width:400px;" class="name">
				   <b>
				   <a href="<?php echo $path.'profile.php?id='.$username_2;?>" style="float:left">
					<?php echo $fname_2; ?>
				   </a>
				   <img src="arrow.png" style="margin-top:2px; float:left" alt="" />
				   <a href="<?php echo $path.'profile.php?id='.$row['username'];?>" style="float:left">
					<?php echo $row['mem_fname'].' '.$row['mem_lname'];	
				   echo '</a>
				</b>';
			 }
		
			echo '<br clear="all" /> 
			<div class="name" style="text-align:justify;float:left; width:400px">';

			$html ='';
			if($row['post_type'] == 1) 
			{
				$html .= '<em>';
				$row['postdata'] = $row['postdata'];
				$pdata = $row['postdata'];
				
				$pdata = $Wall->add_smileys($pdata);
				
				$play = $row['url'];
				
				$clickVId = '';
				if($row['value'] > 0 )
				{
					$youtube = 0;
					if( strpos($play,"youtu.be") >= 0 || strpos($play,"youtube.com") >= 0)
					{
						$play = $row['youtube'];
						echo '<span style="display:none" id="youtube'.@$Random.'"><iframe width="405" height="290" src="" frameborder="0" allowfullscreen></iframe></span>';
						$youtube = 1;
					}
									
					echo '<span id="container'.@$Random.'"></span>';
					
				   $clickVId = "onclick=\"LoadWallVid('$play','$Random','$youtube');\"";
				   $play = 'javascript:;';
				}
				
				$pdata = $Wall->tagfunc($pdata, $row['tagedpersons']);
				
				$pdata = str_replace('_(Cc)_(CT)_', '', $pdata);
				
				$pdata =  $Wall->clickable_link($pdata);
				
				echo (($pdata) ? $pdata.'<br />' : '');
				
				$html .= ' <div id="linkBox'.$Random.'">';
				$Random++;			
				
				$html .= '<div class="attach_content2">';
				
				$html .= '<div class="ftchimgz2"> ';
				$html .= '<a href="'. $play .'" '.$clickVId.'>';
				
				if($row['value'] > 0)
				$html .= '<img src="vid.png" style="position: absolute;margin-top: 41px;" />';
				
				$html .= '<img src="'.$row['cur_image'].'" width="100" style="" />';
				$html .= '</a>';
				$html .= '</div>';
				$html .= ' <div class="ftchinformation2">';
				$html .= ' <label class="ftchtitle2"><a href="'.$row["url"].'" target="_blank"><b>'.$row['title'].'</b></a></label>';
				$html .= '  <label class="ftchurlz2"><a href="'. $row["url"].'" target="_blank">'. $row["url"].'</a></label>';
				$html .= ' <br clear="all">';
				$html .= '  <label class="ftchdesc" style="width:305px;">'.$row['description'].'</label>';
				$html .= ' </div>';
				$html .= '  <div class="ftchtotalimgznavigation" >';
				$html .= '   </div>';
				$html .= '   <div class="ftchtotalimgs_info">';
				$html .= '   </div>';
				$html .= '  <br clear="all" />';
				$html .= ' </div>';
				$html .= ' </div>';
				
				$html .= ' </em>';
			  } 
			  else if($row['post_type'] == 2) 
			  {
					$html .= '<em>';
					$row['postdata'] = $row['postdata'];
					
					$pdata = $row['postdata'];
					
					$pdata = $Wall->tagfunc($pdata, $row['tagedpersons']);
					
					$pdata = str_replace('_(Cc)_(CT)_', '', $pdata);
					
					$pdata = $Wall->add_smileys($pdata);
					
					$pdata =  $Wall->clickable_link($pdata);
					
					echo (($pdata) ? $pdata.'<br />' : '');
					
					$html .= '<div class="attach_content2">';
					
					if($row['media'] == 1)
					{
						echo '<!-- START OF THE PLAYER EMBEDDING TO COPY-PASTE --> 
						<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="328" height="200"> 
						<param name="movie" value="player.swf" /> 
						<param name="allowfullscreen" value="true" /> 
						<param name="allowscriptaccess" value="always" /> 
						<param name="flashvars" value="file=media/'.$row["cur_image"].'" /> 
						<embed 
							type="application/x-shockwave-flash"
							id="player2"
							name="player2"
							src="player.swf" 
							width="328" 
							height="200"
							allowscriptaccess="always" 
							allowfullscreen="true"
							flashvars="file=media/'.$row["cur_image"].'" 
						/> 
						</object> 
						<script type="text/javascript" src="jwplayer.js"></script>
						<!-- END OF THE PLAYER EMBEDDING --> ';

					}
					else
					{
						$img = '';
						$img = $row["cur_image"];
						
						$urls = 'media/'.$img;
						
						$clickc = "onclick=\"showimgs('$urls');\"";
						
						$html .= '<div class="ftchimgz2"> <a href="javascript:;" '.$clickc.'>';
						
						if (file_exists("./media/".$row['cur_image']) || $img) 
						{
							$html .= '<img src="media/'.$row["cur_image"].'" width="100" border="0" style="">';
						}
						 
						$html .= '</a>';
						$html .= '</div>';
						
						$html .= '<div class="ftchinformation2">';
						 
						$html .= '<label class="ftchtitle2"><a href="'.$row["url"].'" target="_blank"><b>'.$row["title"].'</b></a></label>';
						
						$html .= '<label class="ftchurlz2"><a href="'.$row["url"].'" target="_blank">'.$row["url"].'</a></label>';
						
						$html .= '<br clear="all">';
						
						$html .= '<label class="ftchdesc" style="width:305px;">'.$row["description"].'</label>';
						
						$html .= '</div>';
						
						$html .= '<div class="ftchtotalimgznavigation" >';
						
						$html .= '</div>';
						
						$html .= '<div class="ftchtotalimgs_info">';
						
						$html .= '</div>';
						$html .= '<br clear="all" />';
					}
					
					$html .= '</div>';
					$html .= '</em>';
				}
				else 
				{
					$html .= '<em>';
					
					$row['postdata'] = $row['postdata'];
					$pdata = $row['postdata'];
					
					$pdata = $Wall->tagfunc($pdata, $row['tagedpersons']);
					
					$pdata = str_replace('_(Cc)_(CT)_', '', $pdata);
					
					$pdata = $Wall->add_smileys($pdata);
					
					$html .=  $Wall->clickable_link($pdata);
					
					$html .= ' </em>';
				}
	   
		   echo $html; 
		   echo '<br clear="all" />
		   <div style="height:10px;"><span>';

			$days = 0;
			$hours = 0;
			$minutes = 0;
			$seconds = 0;
			
			$days = floor($row['TimeSpent'] / (60 * 60 * 24)); 
			$remainder = $row['TimeSpent'] % (60 * 60 * 24);
			$hours = floor($remainder / (60 * 60));
			$remainder = $remainder % (60 * 60);
			$minutes = floor($remainder / 60);
			$seconds = $remainder % 60;
			if($days > 0) 
			{
				$row['date_created'] = strftime("%b %e %Y", $row['date_created']); 
				echo $row['date_created'];
			} 
			elseif($days == 0 && $hours == 0 && $minutes == 0)
							echo $txt_fewsecondsago;        
						elseif($hours)
							echo $hours." ".$txt_hoursago;
						elseif($minutes)
							echo $minutes.' '.$txt_minutesago;
						else
							echo $txt_fewsecondsago;    
			
		  echo '</span>
		   
			 &nbsp;';
			  if(@$_SESSION['wall_login'] == 0 && $loggedIn == 0){
			 echo '<a href="javascript: void(0)" onclick="alert("'.$txt_login.'")" >'.$txt_comments.'</a>';
			  }else {
			 echo '<a href="javascript: void(0)" id="post_id'.$row['p_id'].'" class="showCommentBox">'.$txt_comments.'</a>'; 
			  }
			 echo '- 
			   <span id="like-panel-'.$row['p_id'].'">';
				
				 if(@$_SESSION['wall_login'] == 0&& $loggedIn == 0){
					
					echo '<a href="javascript: void(0)" onclick="alert("'.$txt_login.'")">'.$txt_up.'</a>';
				
					}else {
				
						 if (@$flag_already_liked == 0) {?>
						<a href="javascript: void(0)" id="post_id<?php  echo $row['p_id']?>" onclick="javascript: likethis(<?php echo $logged_id?>,<?php  echo $row['p_id']?>,1);"><?=@$txt_up?></a>
					<?php }else {?>
					
						<a href="javascript: void(0)" id="post_id<?php  echo $row['p_id']?>" onclick="javascript: likethis(<?php echo $logged_id?>,<?php  echo $row['p_id']?>,2);"><?=@$txt_down?></a>
					<?php }?>
				
				<?php }?>
				
				</span> 
				<?php
				if($row['post_type'] == 1) {
				}
				?>
			</div>
		 </div>	
	   </label>
	   <?php
		if($row['userid'] == @$logged_id || $row['posted_by'] == @$logged_id){
		?>
		<a href="#" class="delete_p" style="color:#ff0000;"><img src="close.png" width="20" alt="" border="0" style="opacity:0.4" /></a>
	   <?php
		}?>
		
		<br clear="all" /><br clear="all" />
	  
		<div class="showPpl" id="ppl_like_div_<?php  echo $row['p_id']?>" <?=((@$row['likes']) ? "" : 'style="display:none"')?>>
				<img src="vote.png" width="22" style="float:left;margin-right:5px; margin-top:-4px;" alt="" />
				 <a class="t" href="javascript:;" onclick="showList(<?php  echo $row['p_id']?>);">
				<span id="like-stats-<?php  echo @$row['p_id']?>"> <?php echo ((@$row['likes']) ? $row['likes'] : 0);?> </span> 
				<?=((@$row['likes']>1) ? $txt_ppl_likes : $txt_ppl_like_single)?>
				</a>
				<span><?=$txt_like_it?></span>
			</div>
			
		<?php if($number_of_comments > $show_comments_per_page){?>
			<div align="left" class="collapsed showPpl" id="collapsed_<?php  echo $row['p_id']?>">
				<img src="comment.png" style="float:left;margin-right:5px;" alt="" />
				<a href="javascript:" style="text-decoration:underline;"><?=$txt_viewall?> <?php echo $number_of_comments?> <?=$txt_view_all_comm?></a>
			</div>
		<?php }?>
		
		<?php if($number_of_comments > ($show_comments_per_page*2)){?>
			<div align="left" class="showPpl" style="display:none; cursor:default" id="com_paging_<?php  echo $row['p_id']?>">
				<input type="hidden" id="currentPage" value="3" />
				<input type="hidden" id="perPage" value="<?=$show_comments_per_page?>" />
				<input type="hidden" id="totalComments" value="<?=$number_of_comments?>" />
				<input type="hidden" id="loadedComments" value="" />
				<div style="width:180px; float:left;" align="left">
					<span id="numofcom<?php  echo $row['p_id']?>"><?php echo ($show_comments_per_page*2)?></span> <?=$txt_comm_of?> 
					<?=$number_of_comments?>
				</div>
				<div style="width:190px; float:left;" align="right" class="next">
				<a href="javascript:" onclick="loadNextcom(<?php  echo $row['p_id']?>,<?=$number_of_comments?>);"><?=$txt_comment_next?></a></div>
				<br clear="all" />
			</div>
		<?php }?>
		
		<div id="CommentPosted<?php  echo $row['p_id']?>">
			<?php
			$comment_num_row = mysql_num_rows(@$comments);
			if($comment_num_row > 0)
			{
				$allrows = array();
				while ($rowed = mysql_fetch_array($comments)) {
					$allrows[] = $rowed;
				}
				$allrows = array_reverse($allrows);	
				foreach($allrows as $rows)
				{
					$flag_already_liked_c = 0;
					$nResult = mysql_query("SELECT * FROM walllikes_track WHERE member_id=".$user_id." AND comment_id=".$rows['c_id']);
					if (mysql_num_rows($nResult))
					{
						$flag_already_liked_c = 1;
					}
					
					$comm_avatar = $Wall->getAvatar($rows['userid']);
					
					if($rows['oauth_uid'] > 0 && $rows['fblink'])
					{
						$CprofLink = $rows['fblink'];	
					}
					else
						$CprofLink = 'javascript:;';
					?>

				<div class="commentPanel" id="record-<?php  echo $rows['c_id'];?>" align="left">
					
					<a href="<?php echo $path.'profile.php?id='.$rows['username'];?>" style="float:left">
						<img src="<?php echo $comm_avatar;?>" style="float:left; padding-right:9px;" width="40" height="40" border="0" alt="" />
					</a>
					
				   <div class="name" style="float:left">
					   <b>
						   <a href="<?php echo $path.'profile.php?id='.$rows['username'];?>">
							<?php echo $rows['mem_fname'].' '.$rows['mem_lname'];?>
						   </a>
					   </b>
					   <em>  
					   <?php  
					   $comD = $rows['comments'];
					   $comD = $Wall->tagfunc($comD, $rows['tagedpersons']);
					   
					   $comD = $Wall->add_smileys($comD);
					   
					   $comD = str_replace('_(Cc)_(CT)_', '', $comD);
					   echo $Wall->clickable_link( $comD );?>
					   </em>
					   <br clear="all" />
					   <div style=" padding-top:3px;">
						<span class="timeanddate">
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
							echo $txt_fewsecondsago;        
						elseif($hours)
							echo $hours." ".$txt_hoursago;
						elseif($minutes)
							echo $minutes.' '.$txt_minutesago;
						else
							echo $txt_fewsecondsago;    ?>
						</span>
						<?php
						if($row['posted_by'] == @$logged_id || $rows['userid'] == @$logged_id)
						{?>
							&nbsp;<a href="javascript:void(0)" id="CID-<?php  echo $rows['c_id'];?>" class="c_delete"><?=$txt_post_delete?></a>
							- <?php
						}?>
						
						<span id="clike-panel-<?php  echo $rows['c_id']?>">
						
						<?php if(@$_SESSION['wall_login'] == 0&& $loggedIn == 0){?>
					
							<a href="javascript: void(0)" onclick="alert('<?=$txt_login?>')"><?=@$txt_up?></a>
							
						<?php }else {?>
						
							<?php if ($flag_already_liked_c == 0) {?>
								
								<a href="javascript: void(0)" id="post_id<?php  echo $rows['c_id']?>" onclick="javascript: Clikethis(<?php echo $logged_id?>,<?php  echo $rows['c_id']?>,1);"><?=$txt_up?></a>
							<?php }else {?>
								
								<a href="javascript: void(0)" id="post_id<?php  echo $rows['c_id']?>" onclick="javascript: Clikethis(<?php echo $logged_id?>,<?php  echo $rows['c_id']?>,2);"><?=$txt_down?></a>
							<?php }?>
							
						<?php }?>
						
						</span>
						</div>
						<div id="ppl_clike_div_<?php  echo $rows['c_id']?>" <?=(($rows['clikes']) ? 'style="float:left;padding-top:3px;"' : 'style="display:none;padding-top:3px;float:left;"')?>>
						 &nbsp;<a class="t" href="javascript:;" onclick="showCList(<?php  echo $rows['c_id']?>);">
						<span id="clike-stats-<?php  echo $rows['c_id']?>"> <?php echo $rows['clikes'];?> </span> <?=(($rows['clikes']>1) ? $txt_ppl_likes : $txt_ppl_like_single)?>
						   </a>

						<span><?=$txt_like_it?></span>
					</div>
					
					</div>
					
					<br clear="all" />
				<!--<br clear="all" />-->
				</div>
				<?php
				}?>				
				<?php
			}?>
		</div>
		<?php if(@$_SESSION['wall_login'] == 1 || $loggedIn == 1){?>
		<div class="commentBox" align="right" id="commentBox-<?php  echo $row['p_id'];?>" <?php echo (($comment_num_row) ? '' :'style="display:none"')?>>
			
			<img src="<?php echo $member_avatar;?>" style="float:left; padding-right:9px;" width="40" height="40" border="0" alt="" class="CommentImg" />
			
			<input type="hidden" name="charkey_saver" id="Ccharkey_saver-<?php  echo $row['p_id'];?>" value="" />
			<input type="hidden" name="tagedfriendsvalues" id="tagged_peopleC<?php  echo $row['p_id'];?>" />
			
			<label id="record-<?php  echo $row['p_id'];?>">
				<textarea class="commentMark" id="commentMark-<?php  echo $row['p_id'];?>" onblur="if (this.value=='') this.value = '<?=$txt_comment_write?>'" onfocus="if (this.value=='<?=$txt_comment_write?>') this.value = ''" onKeyPress="return SubmitComment(this,event)" wrap="hard" name="commentMark" style=" background-color:#fff; overflow: hidden;" cols="60"></textarea>
			</label>
			<br clear="all" />
		</div>
		<div class="cmtgshow" id="cmtgshow<?=$row["p_id"]?>" style="display:none">
		</div>
		<?php }?>
   </div>
	<br clear="all" />
	</div>
<?php
}
if($show_more_button == 1)
{?>
	
	<div id="bottomMoreButton" align="center">
	<input type="hidden" id="more_hidden" value="<?php echo @$next_records?>">
	<img src="loader.gif" id="pagLoader" style="display:none" alt="" />
	</div>
<?php
}?>