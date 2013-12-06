<?php if (!session_id()) session_start();?>
<?php 
include_once 'Wall.php';
include_once('urls.php');
include_once ('text.php');

$Wall = new Wall;

if( @$_SESSION['wall_login'] == 1){
	
	header('Location: '.$siteUrl.'home.php');exit;
}

if(isset($_POST['mem_email']))
{	
	$em  = $Wall->filterData(@$_POST['mem_email']);
	$mem_lname = $Wall->filterData(@$_POST['mem_lname']);
	$mem_fname = $Wall->filterData(@$_POST['mem_fname']);
	$pas = $Wall->filterData(@$_POST['password']);
	
	$username = time().rand(111,999);
	
	$code = md5(strtotime(date("Y-m-d H:i:s")));
	
	$query  = "INSERT INTO wallusers (username,mem_email,mem_lname,mem_fname,mem_pass,verification_code,gender,active) VALUES('".$username."','".$em."','".$mem_lname."','".$mem_fname."','".md5($pas)."','".$code."','m','1')";
	
	$result = mysql_query($query) or die(mysql_error());
	
	header('Location: '.$siteUrl.'home.php?register=true');
	exit;
}?>

<link href="login.css" type="text/css" rel="stylesheet" />
<script src="jquery.min.js" type="text/javascript" charset="utf-8"></script>

<script>
function submitSignUp()
{
	var email 	  = jQuery('#signUpForm #email').val();
	var conpassword  = jQuery('#signUpForm #conpassword').val();
	var password  = jQuery('#signUpForm #password').val();
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
	
	if(password != conpassword)
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
			type: 1,
			email: email,
		}, function(a) {
			
			if( a==1)
			{
				$('#signUpForm #email').addClass("highlight");
				alert("Email already exist. Please try another.");
				return false;
			}
			else
			{
				$("#signUpForm").submit();
				return true;	
			}
		});	
		
		return false;
	}	
}

jQuery(document).ready( function() {

	jQuery('#loginFormButton2').click( function() {
		
	});
});
</script>
<span id="demo" style="display:none"></span>
<div id="job-form" align="left">
    
    <div id="job-inner">
        
        <div align="center">
            <?php
            if( isset($_GET['pic']) )
			{
				echo '<div id="respond">';
				echo 'Please provide your email and password to complete the registration.';
				echo '</div>';
				$css = " float: left; margin-left: 20px;";
			}?>
    
            <div style="width:400px;<?=@$css?>" align="left">
            
            <form id="signUpForm" class="send" name="" action="register.php" method="post">
            
                <h1>Sing Up</h1>
                
                <p>
                    <label style="float:left; width:140px;" for="mem_fname">First Name *</label>
                    <input id="mem_fname" type="text" class="required" name="mem_fname" value="<?php echo @$_REQUEST['key']?>" />
                </p>
                
                <p>
                    <label style="float:left; width:140px;" for="mem_lname">Last Name *</label>
                    <input id="mem_lname" type="text" class="required" name="mem_lname" value="<?php echo @$_REQUEST['lname']?>" />
                </p>
                
                <p>
                    <label style="float:left; width:140px;" for="email">Email *</label>
                    <input id="email" type="text" class="required" name="mem_email" value="<?php echo @$_REQUEST['email']?>" />
                </p>
                
                <p>
                    <label style="float:left; width:140px;" for="password">Password *</label>
                    <input id="password" type="password" class="required" name="password" value="" />
                </p>
                
                <p>
                    <label style="float:left; width:140px;" for="conpassword">Confirm Password *</label>
                    <input id="conpassword" type="password" class="required" name="conpassword" value="" />
                </p>
                
                <p>
                 <label style="float:left; width:140px;" for="conpassword">&nbsp;</label>
                	<button type="submit" id="loginFormButton" onclick="return submitSignUp();">Submit</button>
                </p>
                
            </form>
            
            </div>
            
            <br clear="all" />
        </div>
        
	</div>
    
</div>
