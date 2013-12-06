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
include_once ('text.php');

$Wall = new Wall;

if(!isset($_GET['origem']))
$_GET['origem'] = $_REQUEST['origem'];

$show_comments_per_page = 3;
$path = $siteUrl;
$next_records = 10;
$show_more_button = 0;
$logged_user_pic = '';
$loggedIn = 0;

$x = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : 0;
$Gid = isset($_GET['id']) ? intval($_GET['id']) : 0;
$logged_id = isset($_SESSION['id_user']) ? intval($_SESSION['id_user']) : 0;
$Tagged = @$_POST['Tagged'] ? $_POST['Tagged'] : "";  

$user_id = $Wall->getuserid($Gid);

if($user_id==0)
$user_id = isset($_SESSION['id_user']) ? intval($_SESSION['id_user']) : 0;

//if(@$x)
	include('newCon.php');

if(!$user_id)
	$user_id = $x;
if(!$logged_id)
	$logged_id = $x;

$member_avatar = $Wall->getAvatar($logged_id);

$ActionSimp	= isset($_REQUEST['value']) ? trim($_REQUEST['value']) : "";
$ActionUrl  = isset($_REQUEST['title']) ? trim($_REQUEST['title']) : "";
$ActionImg  = isset($_REQUEST['image_url']) ? trim($_REQUEST['image_url']) : "";
$ActionMore = isset($_REQUEST['show_more_post']) ? trim($_REQUEST['show_more_post']) : "";

if($ActionSimp)
{
	$user_id = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : "";
	$posted_on = isset($_REQUEST['p']) ? trim($_REQUEST['p']) : "";
	$Post 	   = isset($_REQUEST['value']) ? trim($_REQUEST['value']) : "";
    $_GET['id_wall'] = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : "";

    $loggedIn  = 1;
	
	$Wall->PublishToWall($Post, $posted_on, $user_id, false, false, false, false, false, false, false, false, $Tagged, $_GET['origem']);
	$result = $Wall->GetSinglePost($user_id );
}
else if( $ActionUrl)
{
	$user_id = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : "";
	$posted_on = isset($_REQUEST['p']) ? trim($_REQUEST['p']) : "";
	
	$user_id = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : "";
	$posted_on = isset($_REQUEST['p']) ? trim($_REQUEST['p']) : "";
	$videoType = isset($_REQUEST['vtype']) ? trim($_REQUEST['vtype']) : 0;
	$Post = isset($_REQUEST['v']) ? trim($_REQUEST['v']) : "";	
	$title = isset($_REQUEST['title']) ? trim($_REQUEST['title']) : "";
	$url = isset($_REQUEST['url']) ? trim($_REQUEST['url']) : "";
	$description = isset($_REQUEST['desc']) ? trim($_REQUEST['desc']) : "";
	$cur_image = isset($_REQUEST['cur_image']) ? trim($_REQUEST['cur_image']) : "";
	$youtube = isset($_REQUEST['youtube']) ? trim($_REQUEST['youtube']) : "";
	
//	$loggedIn = 1;
	$post_type = 1; // link only 

    if($loggedIn == 1)
    {
	$Wall->PublishToWall($Post, $posted_on, $user_id, $title, $url, $description, $cur_image, $post_type, $videoType, $youtube, false, $Tagged,$_GET['origem']);
	
	$result = $Wall->GetSinglePost($user_id );
    }
}
else if($ActionImg)
{
	$user_id = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : "";
	$posted_on = isset($_REQUEST['p']) ? trim($_REQUEST['p']) : "";
	
	$Post = isset($_REQUEST['v']) ? trim($_REQUEST['v']) : "";
	$media = isset($_REQUEST['video']) ? trim($_REQUEST['video']) : "";
	$image_url = isset($_REQUEST['image_url']) ? trim($_REQUEST['image_url']) : "";
	
	$post_type = 2;
	$loggedIn = 1;
	
	$Wall->PublishToWall($Post, $posted_on, $user_id, false, false, false, $image_url, $post_type, false, false, $media,$Tagged);
	
	$result = $Wall->GetSinglePost($user_id );
}
elseif( $ActionMore) // more posting paging
{

	$next_records = $_REQUEST['show_more_post'] + 10;
	$show_more_post = isset($_REQUEST['show_more_post']) ? intval($_REQUEST['show_more_post']) : 0;
	$posted_on = isset($_REQUEST['p']) ? intval($_REQUEST['p']) : "";
	$_GET['id_wall'] = isset($_REQUEST['x']) ? intval($_REQUEST['x']) : "";  
	
	$loggedIn = 1;
	$show_more_button = 0; // button in the end
	
	$result = $Wall->GetMyPostsNextTotal( $posted_on, $show_more_post,$_REQUEST['origem'],$_GET['id_wall'] );
	
	$check_res = $Wall->GetMyPostsNext( $posted_on, $next_records,$_REQUEST['origem'],$_GET['id_wall'] );
	
//	print_r($result);

	if(@$check_res > 0)
	{
		$show_more_button = 1;
	}
}
else
{

    $show_more_button = 1;
	$result = $Wall->GetSingleDebate( $user_id, 0,$_GET['origem'],$_GET['id_wall'] );
}

$show_more_button = 1;

$Random = rand(12546,88547);          

//$userinfo = $Wall->getuserinformation($_GET['id_wall']);

while ($row = @mysql_fetch_assoc($result))
{

	$flag_already_liked = 0;
	
	$nResult = mysql_query("SELECT * FROM walllikes_track WHERE member_id = ".$logged_id." AND post_id = ".$row['p_id']);
	
	if (@mysql_num_rows($nResult))
	{
		$flag_already_liked = 1;
	}
	
	$comments = $Wall->GetComments( $row['p_id'], $show_comments_per_page);
	$comments_counts = $Wall->CountCommentsDebate( $row['p_id']);
	$number_of_comments = $comments_counts[0]+$comments_counts[1]; ?>

    <?
    $percent = ($comments_counts[1])*100/($comments_counts[1]+$comments_counts[0]);
    ?>
	

	
	<div class="friends_area" style="background-color: red;" id="record-<?php  echo $row['p_id']?>">

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

    <style>
        #progressbar .ui-progressbar-value {
        background: blue;
        }
    </style>

    <script>
        $(function() {
            $( "#progressbar" ).progressbar({
                value: <?=$percent?>
            });
        });
    </script>

    <Table width="100%" border=1>
        <Tr>
            <td>      <div id="progressbar"></div>


                SIm: <?=$comments_counts[1]?> NAO: <?=$comments_counts[0]?></Td>
        </Tr>
    </Table>
	
	
		<?php
			$post_avatar = $Wall->getAvatar($row['posted_by'],$row);

    print "<BR><BR>".urldecode($row['description']);

        ?>

			<a href="<?php echo $wallUrl.'?id_wall='.$row['userid']."&origem=4&id=".$row['posted_by'];?>" target="_parent">
				<img src=<?php echo $post_avatar;?>" style="float:left; padding-right:9px;" width="50" height="50" border="0" alt="" />
			</a>
			<label style="float:right;" class="name"> Perguntado por:
		
			   <a href="<?php echo $wallUrl.'?id_wall='.$row['userid']."&origem=4&id=".$row['posted_by'];?>" target="_parent">
				<?php echo $row['firstname'].' '.$row['lastname'];?>	
			   </a>


			<br clear="all" />

			<div class="name" style="text-align:justify; background-color: yellow">
			<?php
			$html ='';
			if($row['post_type'] == 1) 
			{
				$html .= '<em>';
				$row['postdata'] = $row['postdata'];
				$pdata = $row['postdata'];
				
				$pdata = $Wall->add_smileys($pdata);
				
				$play = $row['url'];
				
				$clickVId = '';
				if($row['value'] > 0)
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
				{?>
					<!-- START OF THE PLAYER EMBEDDING TO COPY-PASTE --> 
					<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="328" height="200"> 
					<param name="movie" value="player.swf" /> 
					<param name="allowfullscreen" value="true" /> 
					<param name="allowscriptaccess" value="always" /> 
					<param name="flashvars" value="file=media/<?php echo $row["cur_image"]?>" /> 
					<embed 
						type="application/x-shockwave-flash"
						id="player2"
						name="player2"
						src="player.swf" 
						width="328" 
						height="200"
						allowscriptaccess="always" 
						allowfullscreen="true"
						flashvars="file=media/<?php echo $row["cur_image"]?>" 
					/> 
					</object> 
					<script type="text/javascript" src="jwplayer.js"></script>
					<!-- END OF THE PLAYER EMBEDDING --> 
				<?php
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
					
					if(@$row["url"])
					{
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
					}
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
			
			echo $html; ?>               
			 
		   <div class="links_direita">
		   <span>
		   <?php

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
				$row['date_created'] = strftime("%d/%m/%Y", $row['date_created']);
				echo $row['date_created'];
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
			 &nbsp;
			 <?php
               /*        comentar
               if(@$_SESSION['wall_login'] == 0){?>
			 <a href="javascript: void(0)" class="azul" onclick="login()" ><?=$txt_debate?></a> -
			 <?php }else {?>
			 <a href="javascript: void(0)" id="post_id<?php  echo $row['p_id']?>" class="showCommentBox azul"><?=$txt_debate?></a>
			 <?php }
               */?>
			 
			   <span id="like-panel-<?php  echo $row['p_id']?>">
				
				<?php if(@$_SESSION['wall_login'] == 0){?>
					
					<a href="javascript: void(0)"  onclick="login()"><?=@$txt_up?> - </a>
				
				<?php }else {?>
				
					<?php if (@$flag_already_liked == 0) {?>
						<a href="javascript: void(0)" id="post_id<?php  echo $row['p_id']?>" onclick="javascript: likethis(<?php echo $logged_id?>,<?php  echo $row['p_id']?>,1);"><?=@$txt_up?></a>
					<?php }else {?>
					
						<a href="javascript: void(0)" id="post_id<?php  echo $row['p_id']?>" onclick="javascript: likethis(<?php echo $logged_id?>,<?php  echo $row['p_id']?>,2);"><?=@$txt_down?></a>
					<?php }?>
				
				<?php }?>
				
				</span> 
				<?php
				if($row['post_type'] == 1) {}
				?>
			</div>
		 </div>	
	   </label>
	   <?php
		if($row['userid'] == @$logged_id || $row['posted_by'] == @$logged_id){?>
		<a href="#" class="delete_p"><img src="close.png" width="20" alt="" border="0" style="opacity:0.4" /></a>
		<?php
		}?>
		
		<br clear="all" />

    <?php if(@$_SESSION['wall_login'] == 1){?>
        <div class="commentBox" align="right" id="commentBox-<?php  echo $row['p_id'];?>" <?php echo (($comment_num_row) ? '' :'')?>>


            <select name="answer" id="answer">
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
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
				<a href="javascript:"><?=$txt_viewall?> <?php echo $number_of_comments?> <?=$txt_view_all_comm?></a>
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
					<?=$number_of_comments?></a>
				</div>
				<div align="right" class="next azul">
				<a href="javascript:" onclick="loadNextcom(<?php  echo $row['p_id']?>,<?=$number_of_comments?>);"><?=$txt_comment_next?></a></div>
				<br clear="all" />
			</div>
		<?php }?>
		
		<div id="CommentPosted<?php  echo $row['p_id']?>">
			<?php
			$comment_num_row = @mysql_num_rows($comments);
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
					
					$nResult = mysql_query("SELECT * FROM walllikes_track WHERE member_id=".$logged_id." AND comment_id=".$rows['c_id']);
					if (mysql_num_rows($nResult))
					{
						$flag_already_liked_c = 1;
					}
					
					$comm_avatar = $Wall->getAvatar($rows['userid'],$row);

                    /*
					if($rows['oauth_uid'] > 0 && $rows['fblink'])
					{
						$CprofLink = $rows['fblink'];	
					}
					else
                    */
						$CprofLink = '';?>

				<div class="commentPanel" style="background-color: blue" id="record-<?php  echo $rows['c_id'];?>" align="left">

                    <?if($rows['answer']=="1")
                    {
                       print "SIM!";
                    }
                    else
                     {
                       print "NAO!";
                     }?>
					<a href="<?php echo $wallUrl.'?id_wall='.$rows['username']."&origem=4&id=".$user_id;?>" target="_parent" style="float:left">
						<img src="<?php echo $comm_avatar;?>" style="float:left; padding-right:9px;" width="40" height="40" border="0" alt="" />
					</a>
					<div class="name pequeno">
					   <b>
						   <a class="nome_wall" href="<?php echo $wallUrl.'?id_wall='.$rows['customer_id']."&origem=4&id=".$user_id;?>" target="_parent">
							<?php echo $rows['firstname'].' '.$rows['lastname'];?>
						   </a>
					   </b>
					   <em>  
					   <?php  
					   $comD = $rows['comments'];
					   $comD = $Wall->tagfunc($comD, $rows['tagedpersons']);
					   $comD = str_replace('_(Cc)_(CT)_', '', $comD);
					   
					   $comD = $Wall->add_smileys($comD);
					   
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
							$rows['date_created'] = strftime("%d/%m/%Y", $rows['date_created']);
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
							<!--a href="javascript:void(0)" id="CID-<?php  echo $rows['c_id'];?>" class="c_delete"><?=$txt_post_delete?></a-->
							atras <?php
						}?>
						<span class="curtir_azul" id="clike-panel-<?php  echo $rows['c_id']?>">
						
						<?php if(@$_SESSION['wall_login'] == 0){?>
					
							<a href="javascript: void(0)" onclick="login()"><?=@$txt_up?></a>
							
						<?php }else {?>
						
							<?php if ($flag_already_liked_c == 0) {?>
								
								<a href="javascript: void(0)" id="post_id<?php  echo $rows['c_id']?>" onclick="javascript: Clikethis(<?php echo $logged_id?>,<?php  echo $rows['c_id']?>,1);"><?=$txt_up?></a>
							<?php }else {?>
								
								<a href="javascript: void(0)" id="post_id<?php  echo $rows['c_id']?>" onclick="javascript: Clikethis(<?php echo $logged_id?>,<?php  echo $rows['c_id']?>,2);"><?=$txt_down?></a>
							<?php }?>
							
						<?php }?>
						
						</span>
						</div>
						<div  class="showPpl pplLikes" id="ppl_clike_div_<?php  echo $rows['c_id']?>" <?=(($rows['clikes']) ? 'style=""' : 'style="display:none;"')?>>
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
        <script>
            parent.resizeFrame('childframe');
        </script>

<?php
}?>
