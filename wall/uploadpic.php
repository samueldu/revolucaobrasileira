<?php
include('newCon.php');
$path = "pics/";

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
	$name = $_FILES['profilepic']['name'];
	$size = $_FILES['profilepic']['size'];
	
	if(strlen($name))
	{
		list($txt, $ext) = explode(".", $name);
		
		if(in_array($ext, $valid_formats_img))
		{
			if($size<($image_size_limit*$image_size_limit))
			{
				$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['profilepic']['tmp_name'];
				
				if(move_uploaded_file($tmp, $path.$actual_image_name))
				{
					$result = mysql_query("update wallusers set mem_pic='".$actual_image_name."' where mem_id = ".$_REQUEST['memberid']);
					echo "<img src='pics/".$actual_image_name."' class='showthumb' />";
				}
				else
					echo "Error please try again.";
			}
			else
				echo "Size is too high.";					
		}
		else
			echo "Error: extension is unknown. Please try again.";
	}
	else
		echo "Error please try again.";
	
	exit;
}
?>