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

if( @$_SESSION['wall_login'] == 0){
	
	header('Location: '.$siteUrl.'home.php');exit;
}?>

<?php
$result = mysql_query("SELECT * FROM wallusers where mem_id = ".$_SESSION['id_user']." ");
if (mysql_num_rows($result) > 0)
{
	while( $obj = @mysql_fetch_array($result) )
	{
		$mem_email 	= $obj['mem_email'];
		$mem_fname 	= $obj['mem_fname'];
		$mem_lname 	= $obj['mem_lname'];
		$mem_pic 	= $obj['mem_pic'];
		$mem_id 	= $obj['mem_id'];
		$gender 	= $obj['gender'];
	}
}
?>
<link href="login.css" type="text/css" rel="stylesheet" />
<script src="jquery.form.js" type="text/javascript" charset="utf-8"></script>
<script type='text/javascript' src='assets/js/jquery.livequery.js'></script> 
<script src="jquery.form.js" type="text/javascript"></script>
<script>
function submitSignUp()
{
	if(jQuery('#resetOpen').val() == 1)
	{
		var password = jQuery('#signUpForm #password').val();
		var conpassword = jQuery('#signUpForm #conpassword').val();
	}
	else
	{
		var password 	= '';
		var conpassword = '';
	}
	
	var memberid  = jQuery('#signUpForm #memberid').val();	
	var mem_fname = jQuery('#signUpForm #mem_fname').val();
	var mem_lname = jQuery('#signUpForm #mem_lname').val();
	
	$("#signUpForm input.required").each(function()
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
	
	if ( password != conpassword && jQuery('#resetOpen').val() == 1)
	{
		alert("Sorry, Confirm password do not match.");
		return false;
	}
	
	if ($("#signUpForm input.required").hasClass('highlight')) 
	{
		alert("Please fill in all the required fields (indicated by *)");
		return false;
	}
	else
	{
		jQuery('#demo').load('func.php', {
			type: 3,
			mem_fname: mem_fname,
			mem_lname: mem_lname,
			password: password,
			memberid: memberid,
		}, function(a) {
			popup('popUpDiv');
			$('#popUpDiv div').html('');
			return false;						
		});	
		
		return false;	
	}	
}

function openResetPass()
{
	if(jQuery('#resetOpen').val() == 1)
	{
		jQuery('.resetPass').hide();	
		jQuery('#resetOpen').val(0);
	}
	else
	{
		jQuery('.resetPass').show();	
		jQuery('#resetOpen').val(1);
	}
}

</script>
<span id="demo" style="display:none"></span>
<style>
#signUpForm label{ float:left; width:150px;}
</style>
<div id="job-form" align="left">
    <div id="job-inner">
        <div align="center">
            
            <div style="width:400px;" align="left">
            	<form id="signUpForm" class="send" action="uploadpic.php" method="post" enctype="multipart/form-data">
                   	<input type="hidden" id="memberid" name="memberid" value="<?=@$mem_id?>" />
                    <p>
                        <label for="mem_fname">First Name *</label>
                        <input id="mem_fname" type="text" class="required" name="mem_fname" value="<?php echo @$mem_fname?>" />
                    </p>
                    
                    <p>
                        <label for="mem_lname">Last Name *</label>
                        <input id="mem_lname" type="text" class="required" name="mem_lname" value="<?php echo @$mem_lname?>" />
                    </p>
                    
                    <p>
                        <label for="email">Email *</label>
                        <span style="float:left"><?php echo @$mem_email?></span>
                    </p>
                    <br clear="all" />
                    <p>
            			<a href="javascript:;" onclick="openResetPass();">Update Password</a>
                    </p>
                    
                    <input type="hidden" id="resetOpen" value="0">
                    <div class="resetPass" style="display:none">
                        <p>
                        <label for="password">Password *</label>
                        <input id="password" type="password" name="password" class="" value="" />
                        </p>
                        
                        <p>
                        <label for="email">Confirm Password *</label>
                        <input id="conpassword" type="password" name="conpassword" class="" value="" />
                        </p>
                    </div> 
                   
                    <p>
                       
                        <input type="file" name="profilepic" id="profilepic" />
                        <br />
                        <div id="showthumbprofile">
                        <?php
						if(@$mem_pic)
						{?>
                        <img src="<?php echo $Wall->getAvatar($mem_id);?>" width="150" />
                        	<?php 
						}?>
                        </div>
                    </p>
                    
                    <p>
                    	<label for="email">&nbsp;</label>
                        <button type="submit" id="loginFormButton" onclick="return submitSignUp();">Submit</button>
                    </p>
                    
            	</form>
            </div>
            <br clear="all" />
        </div>
	</div>
</div>