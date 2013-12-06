<?php if (!session_id()) session_start();

include_once 'Wall.php';
include_once('urls.php');

$Wall = new Wall;

$logged_in = isset($_SESSION['wall_login']) ? intval($_SESSION['wall_login']) : "";

if(@$logged_in == 0)
{       
	//header("Location: ".$siteUrl."home.php?id_wall=".$_GET['id_wall']."&origem=".$_GET['origem']);
} 
	  
if(@$_GET['id'])
{
	$get_id = $Wall->getUserId($_GET['id'],intval($_GET['origem']));
	
	if($get_id==0)
	{
		header("Location: ".$siteUrl."profile.php");
	}
}
else
{    
	$get_id = isset($_SESSION['id_user']) ? intval($_SESSION['id_user']) : "";
}

$userinfo = $Wall->getuserinformation(@$get_id);

if(!isset($_GET['page']))
$page = "debate";
else
$page = $_GET['page'];

include_once('header.php');

  echo ' <!-- side bar div close-->

		</div>
		
		<div style="margin:0px 0px 0px 0px; float:left">';
			
//		   if(@$logged_in == 1){

           if(1 == 1){ ?>

<!--div id="bio"-->
<?
				   if($get_id == $userinfo['id']){			   
				   ?>

<!--a href="javascript:;" title="Update Profile" style="font-weight:bold" id="updateProfile">Edit Profile</a-->
<?
				   }?>

<input type="hidden" name="pageUsing" id="pageUsing" value="profile" />
<div class="UIComposer_Box"> 
  <!--div align="right">
						<img src="media.png" width="20" alt="" id="ShowPhotoBox" style="float:right;cursor:pointer; margin-right:5px;" />  
						<img src="link.png" id="ShowLinkBox" width="16" alt="" style="cursor:pointer;float:right; margin-right:5px; margin-top:4px;" />
						<img src="comment.png" border="0" id="ShowStatusBox" style="float:right;cursor:pointer; margin-right:5px; margin-top:4px;" alt="" />
					</div--> 
  <!--textarea id="watermark" class="input" placeholder="<?=$txt_wrtesomething?>" cols="60" wrap="hard" name="watermark"></textarea-->
  <input type="hidden" name="keepID" id="keepID" value="<?php  echo $mid = $_SESSION['id_user'];?>" />
  <input type="hidden" name="posted_on" id="posted_on" value="<?=$_GET['id_wall']?>" />
  <input type="hidden" name="posted_on" id="already" value="0" />
  <input type="hidden" name="tagged_people" id="tagged_people" />
  <input type="hidden" id="origem" name="origem" value="<?=$_GET['origem']?>" />
  <br clear="all" />
  <div id="txtarea_tag_user_result_div" style="display:none">
    <div align="center" ><img src="load.gif" alt="Loading" /></div>
  </div>
  <div align="left" style="">
    <input type="hidden" name="charkey_saver" id="charkey_saver" value="" />
    <div align="right">
      <?php
//                            if(@$logged_in == 1)
                            if(1 == 1)
                            {

                                    if(@$logged_in == 1)
                                    {
?>
      <!--div align="left" style="height:30px; margin-top:4px;" class="main_bar" id="shareButtons">
          <div role="button" class="gbutton" aria-disabled="true">
            <?=$txt_share_button?>
          </div>
      </div-->
      <?php
                            }
                                else
                                if(@$logged_in == 0)
                                {
                                    ?>
      <div align="left" style="height:30px; margin-top:4px;" class="main_bar" id="shareButtonsz">
        <div style=" margin-bottom:10px ; margin-right:0px;" class="m-o-q-ba-r ">
          <div role="button" class="gbutton" aria-disabled="true"

                                            <?
                                            if(@$logged_in == 0)
                                                print " onclick=\"login()\" ";
                                            ?>

                                             style="-webkit-user-select: none;"><?=$txt_share_button?></div>
        </div>
      </div>
      <?php
                                }
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
       
            <div role="button" class="gbutton" aria-disabled="true"  id="attach">
              <?=$txt_ftch_url?>
            </div>
     
        <input type="hidden" name="cur_image" id="cur_image" />
        <div id="loader">
          <div align="center" id="ftchloading" style="display:none"> <br clear="all" />
            <img src="loader.gif" alt="Loading" /> </div>
          <div id="attach_content" style="display:none">
            <div id="ftchimgz"></div>
            <div id="ftchinformation">
              <label id="ftchtitle"></label>
              <label id="ftchurlz"></label>
              <br clear="all" />
              <label id="ftchdesc"></label>
              <br clear="all" />
            </div>
            <div id="ftchtotalimgznavigation" align="left"> <a href="javascript:;" id="prev"><img src="prev.png"  alt="Prev" border="0" /></a> <a href="javascript:;" id="next"><img src="next.png" alt="Next" border="0" /></a> </div>
            <div id="ftchtotalimgzinfo" >
              <?=$txt_ftch_showing?>
              <span id="cur_image_num">1</span>
              <?=$txt_ftch_of?>
              <span id="ftchtotalimgs">1</span>
              <?=$txt_ftch_imgs?>
            </div>
            <br clear="all" />
          </div>
          <span id="youtubeID" style="display:none"></span>
          <input type="hidden" id="videoType" value="0" />
          <div id="shareURLdiv" align="right" style="display:none"> <br clear="all" />
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
      <b>
      <?=$txt_ftch_vidhlp_txt?>
      </b> <br />
      <input type="file" name="thisimage" id="thisimage" />
    </form>
    <br />
    <div id="showthumb"> </div>
    <div id="shareImageDiv" align="right" style="display:none"> <br clear="all" />
      <div align="left" style="height:30px; margin-top:4px;" class="main_bar">
        <div style=" margin-bottom:10px ; margin-right:0px;" class="m-o-q-ba-r ">
          <div role="button" class="gbutton" aria-disabled="true" style="-webkit-user-select: none;" id="shareImageButton">
            <?=$txt_share_button?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="wrapperfb" id="wrapperfb" align="center"><img src="loader.gif" alt="Loading" /></div>
</div>
<?php }?>


<br clear="all" />
<div align="center">
  <div id="midbox" align="left">
    <?php include('debate_wall.php')?>
  </div>
</div>


<div id="thing" class="thing"><a href="javascript:mais()">Mais opniões</a> </div>

<!--script>
                 $('#thing').waypoint(function(direction) {
  alert('Top of thing hit top of viewport.');
});
</script--> 

<script>

</script> 
<script>
        function mais()
        {
            lastPostFunc('debate');
        }

    </script>
<?php //include('footer.php')?>
