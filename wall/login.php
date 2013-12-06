<?php if (!session_id()) session_start();?>
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

if(isset($_POST['mem_email']))
{
	$em  = $Wall->filterData(@$_POST['mem_email']);
	$pas = $Wall->filterData(@$_POST['password']);
	
	$query  = "SELECT * FROM wallusers where mem_email='".$em."' and mem_pass='".md5($pas)."' and active=1";
	$result = mysql_query($query) or die(mysql_error());
	
	if (mysql_num_rows($result) == 0)
	{
		header('Location: '.$siteUrl.'home.php?login=false');
		exit;
	}
	
	while ($row = mysql_fetch_assoc($result)) 
	{
		$mem_email 	  = $row["mem_email"];
		$id 	  	  = $row["mem_id"];
		$username 	   = $row["username"];
		$mem_fname 	  = $row["mem_fname"];
		$mem_lname 	  = $row["mem_lname"];
		$mem_pic 	  = $row["mem_pic"];
		$gender 	  = $row["gender"];
		
		$_SESSION['id_user']  = $id;

		setcookie("username", $username);
		
		setcookie("mem_id", $id);
		
		$_SESSION['username'] = $username;
		
		$_SESSION['mem_email'] 	= $mem_email;
		$_SESSION['mem_fname']  = $mem_fname;
		$_SESSION['mem_lname']  = $mem_lname;
		
		$_SESSION['gender']  	= $gender;
		$_SESSION['mem_pic'] 	= $mem_pic;
		$_SESSION['wall_login'] = 1;
	}
	
	header('Location: '.$siteUrl.'home.php?login=success');
	exit;
}?>

<script>
jQuery(document).ready( function() {

	jQuery('#loginFormButton').click( function() {
		
		var email 	 = jQuery('#LoginForm #email').val();
		var password = jQuery('#LoginForm #password').val();
		
		$("#LoginForm input.required").each(function()
		{
			if ($(this).val().length == 0)
			{
				$(this).addClass("highlight");
			}
			else
			{
				$(this).removeClass("highlight");
			}
		});
		
		if ($("#LoginForm input.required").hasClass('highlight')) 
		{
			alert("Please fill in all the required fields (indicated by *)");
			return false;
		}
		else
		{
			$("#LoginForm").submit();
			return true;	
		}
		
	});
	
});
</script>
<br clear="all" />            
<div style="width:375px;" align="left" class="topLogin">
<br clear="all" />
    <form id="LoginForm" class="send" name="" action="login.php" method="post">
        <label class="loginLabel" for="email">Email *</label>
        <input id="email" type="text" class="required" name="mem_email" value="user2@99points.info" />
        <label class="loginLabel" for="company">Password *</label>
        <input id="password" type="password" class="required" name="password" value="12345" />
    	<br clear="all" />
        
        <a href="javascript:;" class="navigation" style=" margin-left:55px;" id="loginFormButton">Login</a>
        
        <div style="float:left; width:268px;">
        <a href="javascript:;" class="navigation" style="float:right;" id="registerPopUp">Register</a>
        </div>
        <br clear="all" />
    </form>

</div>     
