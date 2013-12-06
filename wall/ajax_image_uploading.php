<?php
include('newCon.php');
$path = "media/";

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
	$name = $_FILES['thisimage']['name'];
	$size = $_FILES['thisimage']['size'];
	
	if(strlen($name))
	{
		list($txt, $ext) = explode(".", $name);
		
		if(in_array($ext, $valid_formats_img))
		{
			if($size<($image_size_limit*$image_size_limit))
			{
				$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['thisimage']['tmp_name'];
				
				if(move_uploaded_file($tmp, $path.$actual_image_name))
				{
					echo "<img src='media/".$actual_image_name."'  class='showthumb' /><input type='hidden' id='video' value='0' /><input type='hidden' id='ajax_image_url' value='".$actual_image_name."' />";
				}
				else
					echo $txt_img_err1;
			}
			else
				echo $txt_img_up_size;					
		}
		else if(in_array($ext, $valid_formats_vid))
		{
			if($size<($videos_size_limit*$videos_size_limit))
			{
				$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['thisimage']['tmp_name'];
					
				if(move_uploaded_file($tmp, $path.$actual_image_name))
				{?>
					
				   <!-- START OF THE PLAYER EMBEDDING TO COPY-PASTE --> 
					<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="328" height="200"> 
					<param name="movie" value="player.swf" /> 
					<param name="allowfullscreen" value="true" /> 
					<param name="allowscriptaccess" value="always" /> 
					<param name="flashvars" value="file=media/<?php echo $actual_image_name?>" /> 
					<embed 
						type="application/x-shockwave-flash"
						id="player2"
						name="player2"
						src="player.swf" 
						width="328" 
						height="200"
						allowscriptaccess="always" 
						allowfullscreen="true"
						flashvars="file=media/<?php echo $actual_image_name?>" 
					/> 
				</object> 
				<script type="text/javascript" src="jwplayer.js"></script>
				<!-- END OF THE PLAYER EMBEDDING --> 
                <?php
				echo "<input type='hidden' id='ajax_image_url' value='".$actual_image_name."' /><input type='hidden' id='video' value='1' />";
				}
				else
					echo $txt_img_err1;
			}
			else
				echo $txt_img_up_size;	
		}
		else
			echo $txt_img_err2;	
	}
	else
		echo $txt_img_err3;
	
	exit;
}
?>