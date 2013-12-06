<?
$BASE_URL = $siteUrl;
?>
<script src="<?=$BASE_URL ?>fb/jquery.elastic.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=$BASE_URL ?>fb/jquery.watermarkinput.js" type="text/javascript"></script>
<script src="<?=$BASE_URL ?>fb/jquery.livequery.js" type="text/javascript"></script>
<script src="<?=$BASE_URL ?>jquery.form.js" type="text/javascript"></script>
<script src="<?=$BASE_URL ?>jquery.oembed.js" type="text/javascript"></script>      
<script src="<?=$BASE_URL ?>wall.js" type="text/javascript"></script>
<script src="<?=$BASE_URL ?>news.js" type="text/javascript"></script>
<link href="<?=$BASE_URL ?>stylesheet.css" type="text/css" rel="stylesheet" />
<link href="<?=$BASE_URL ?>popup.css" type="text/css" rel="stylesheet" />
<link href="<?=$BASE_URL ?>css.css" type="text/css" rel="stylesheet" />
<link href="<?=$BASE_URL ?>assets/css/header_buttons.css" type="text/css" rel="stylesheet">
<!--script src="<?=$BASE_URL ?>javascript/waypoints.js" type="text/javascript"-->
<meta x-frame-options="SAMEORIGIN">
<meta name="viewport" content="width=480">
</head>
<body>

<div align="center">
		
		<!--div id="respond" style="padding:3px;" align="right">
			<p align="left" style="float:left; padding:7px; margin:0px;">
			
			</p>
			<p style="float:right; color:#ccc; font-size:11px; padding:0px; margin:0px;">
			
			<a href="home.php" class="navigation">Home</a>&nbsp;
			<?php if(@$_SESSION['wall_login'] == 1)
			{?>
			<a href="profile.php" class="navigation">Profile</a>&nbsp;
			<a href="logout.php" class="navigation" style=" background:#C00">Logout</a>&nbsp;
			<?
			}?>
			</p>
			<br clear="all" />
		</div-->
	
	 <!--div style="width:768px; padding-top:5px;" align="left"-->
	
		<!--div id="sidebar"-->
			<!--img src="logo.jpg" width="130" style="position:fixed;" />
			<br clear="all" /><br clear="all" /><br clear="all" />
			<br clear="all" /><br clear="all" />
			<br clear="all" />
			<div id="nopofile" style="max-height:189px; min-height:189px; overflow:hidden;">
				
				<?php if(@$_SESSION['wall_login'] == 1){?>
				
					<img src="<?php echo $Wall->getAvatar($userinfo['mem_id']);?>" width="150" />
				<?
				}
				?>
			</div>
			
			<br clear="all" /-->
