<?php if (!session_id()) session_start();
include_once 'Wall.php';
include_once('urls.php');

$Wall = new Wall;

$uid = isset($_GET['id']) ? intval($_GET['id']) : "";

if(@$uid)
{
	$get_id = $Wall->getUserId($uid);
	if($get_id==0)
	{
		header("Location: ".$siteUrl."profile.php");	
	}
}
else
{
	$get_id = $_SESSION['id_user'];
}


$userinfo = $Wall->getuserinformation(@$get_id);

$page = "home";

include_once('header.php');

echo '</div>
 <div style="margin:0px 0px 0px 0px; float:left; background: #000">';
	
	if( isset($_GET['verify']) || isset($_GET['register']) || isset($_GET['login']) || isset($_GET['logout']))
	echo '<div id="responding">';
	
	if(isset($_GET['verify']))
	{
		if($_GET['verify'] == 'true')
		{echo '';}
		else
		{echo 'Sorry something missing. Try again later.';}
	}
	else if(isset($_GET['register']))
	{
		if($_GET['register'] == 'true')
		{echo 'Thank you, Now you can login to use this wall.';}
		else
		{echo 'Sorry something missing. Try again later.';}
	}
	else if(isset($_GET['login']))
	{
		if($_GET['login'] == 'false')
		{echo 'Sorry, your email or password do not match. Try again please.';}
		else
		{echo 'Welcome '.$_SESSION['mem_fname'].', Now you can use this wall.';}
	}
	else if(isset($_GET['logout']))
	{
		if($_GET['logout'] == 'true')
		{echo 'You are now successfully logged out.';}
	}
	else if(!isset($_COOKIE['username']))
	{
		//{echo 'Login to Use this outstanding wall.';}
	}
	
	if( isset($_GET['verify']) || isset($_GET['register']) || isset($_GET['login']) || isset($_GET['logout']))
	echo '</div>';
			
	if(@intval($_SESSION['wall_login']) != 1){
	
	//include('login.php');

	}if(intval($_SESSION['wall_login']) == 1){?>
	
	<div>
		<input type="hidden" name="pageUsing" id="pageUsing" value="home" />
		<div class="UIComposer_Box" style="padding: 0px;">
			<div align="right">
				<img src="media.png" width="20" alt="" id="ShowPhotoBox" style="float:right;cursor:pointer; margin-right:5px;" />  
				<img src="link.png" id="ShowLinkBox" width="16" alt="" style="cursor:pointer;float:right; margin-right:5px; margin-top:4px;" />
				<img src="comment.png" border="0" id="ShowStatusBox" style="float:right;cursor:pointer; margin-right:5px; margin-top:4px;" alt="" />
			</div>
			<br clear="all" />
			<textarea id="watermark" class="input" placeholder="<?=$txt_wrtesomething?>" cols="60" wrap="hard" name="watermark"></textarea>
			<input type="hidden" name="posted_on" id="already" value="0" />
			<input type="hidden" name="keepID" id="keepID" value="<?php  echo $mid = $_SESSION['id_user'];?>" />
			<input type="hidden" name="posted_on" id="posted_on" value="<?php  echo $mid = $_SESSION['id_user'];?>" />
			<input type="hidden" name="tagged_people" id="tagged_people" />
			<br clear="all" />
			<div id="txtarea_tag_user_result_div" style="display:none">
			<div align="center" ><img src="load.gif" alt="Loading" /></div>
			</div>

			<div align="left" style="">
				<input type="hidden" name="charkey_saver" id="charkey_saver" value="" />
				<div align="right">	

					<?php if($_SESSION['wall_login'] == 1)
					{?>
						<div align="left" style="height:30px; margin-top:4px;" class="main_bar" id="shareButtons">
							<div style=" margin-bottom:10px ; margin-right:0px;" class="m-o-q-ba-r ">
							<div role="button" class="gbutton" aria-disabled="true" style="-webkit-user-select: none;"><?=$txt_share_button?></div>
							</div>    
						</div>
						
						<?php 
					}?>
				</div>
				
			</div>
			
		</div>
		
		<!-- Link box-->
		<div id="Show-Link-Box" style="display:none">
		
			<div class="wrap" align="center">
			
				<div align="center">
				  
					<div id="ftch_main" align="center">
						<input type="text" name="url" size="40" id="url" value="http://www." />
						
						<div align="left" style="height:30px; margin-top:4px; float:left;">
							<div style=" margin-bottom:10px ; margin-right:0px;" class="m-o-q-ba-r ">
							<div role="button" class="gbutton" aria-disabled="true" style="-webkit-user-select: none;" id="attach"><?=$txt_ftch_url?></div>
							</div>    
						</div>
						<br clear="all" />
						
						<input type="hidden" name="cur_image" id="cur_image" />
						<div id="loader">
								
							<div align="center" id="ftchloading" style="display:none">
								<br clear="all" />
								<img src="loader.gif" alt="Loading" />
							</div>
							
							<div id="attach_content" style="display:none">
								<div id="ftchimgz"></div>
								<div id="ftchinformation">
								 
									<label id="ftchtitle"></label>
									<label id="ftchurlz"></label>
									<br clear="all" />
									<label id="ftchdesc"></label>
									<br clear="all" />
								</div>
								<div id="ftchtotalimgznavigation" >
									<a href="javascript:;" id="prev"><img src="prev.png"  alt="Prev" border="0" /></a>
									<a href="javascript:;" id="next"><img src="next.png" alt="Next" border="0" /></a>
								</div>
							 
								<div id="ftchtotalimgzinfo" >
									<?=$txt_ftch_showing?> <span id="cur_image_num">1</span> <?=$txt_ftch_of?> <span id="ftchtotalimgs">1</span> <?=$txt_ftch_imgs?>
								</div>
								<br clear="all" />
							</div>
							<span id="youtubeID" style="display:none"></span>
							<input type="hidden" id="videoType" value="0" />
							<div id="shareURLdiv" align="right" style="display:none">
								<br clear="all" />
								<div align="left" style="height:30px; margin-top:4px;" class="main_bar">
									<div style=" margin-bottom:10px ; margin-right:0px;" class="m-o-q-ba-r ">
									<div role="button" class="gbutton" aria-disabled="true" style="-webkit-user-select: none;" id="shareURLbutton">Share</div>
									</div>    
								</div>
							</div>
							
						</div>
						<br clear="all" />
					</div>
				</div>
				
			</div>
		
		</div>
		
		<!-- upload image -->
		<div class="wrap" align="center" style=" display:none" id="show_img_upload_div">
			
			<div align="center" style="padding:10px 10px 10px 5px;">
			  
			   <form action="ajax_image_uploading.php" id="ajaxuploadfrm" method="post" enctype="multipart/form-data" >
				<b><?=$txt_ftch_vidhlp_txt?></b>
				<br /><input type="file" name="thisimage" id="thisimage" />
				</form>
				<br />
				<div id="showthumb">
				</div>
				
				<div id="shareImageDiv" align="right" style="display:none">
					<br clear="all" />
					<div align="left" style="height:30px; margin-top:4px;" class="main_bar">
						<div style=" margin-bottom:10px ; margin-right:0px;" class="m-o-q-ba-r ">
						<div role="button" class="gbutton" aria-disabled="true" style="-webkit-user-select: none;" id="shareImageButton"><?=$txt_share_button?></div>
						</div>    
					</div>
				 </div>
			</div>
		</div>
		<div class="wrapperfb" id="wrapperfb" align="center"><img src="loader.gif" alt="Loading" /></div>
		
	</div>
	<?php 
	}?>
	
	<br clear="all" />
	 
	<div align="center">
		<div id="midbox" align="left" style="width:530px; min-height:500px;">
		<?php
			if(@intval($_SESSION['wall_login']) == 1)
			{
				include('member_wall.php');
			}
			else
			{
				include('profile_wall.php');	
			}?>
		</div>
	</div>
	
	<script>

	$(window).scroll(function(){
						  
		if  ($(window).scrollTop() == $(document).height() - $(window).height()){
		   lastPostFunc('member');
		}
	});
	
	</script>
