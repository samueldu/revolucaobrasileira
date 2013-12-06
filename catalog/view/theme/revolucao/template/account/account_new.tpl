<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
  <div class="top">
	<div class="left"></div>
	<div class="right"></div>
	<div class="center">
	  <h1><?php echo $heading_title; ?></h1>
	</div>
  </div>
  <div  class="middle" style=" width:558px; float:left">
	<?php if ($success) { ?>
	<div class="success"><?php echo $success; ?></div>
	<?php } ?>
	<div  style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="catalog/view/theme/<?=TEMPLATE?>/image/edit1.png" alt="" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/edit" style="font-weight: bold;"><?php echo $text_information; ?></a><br>
		</div>
   
	
  <div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="catalog/view/theme/<?=TEMPLATE?>/image/password.png" alt="" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/password" style="font-weight: bold;"><?php echo $text_password; ?></a><br>
		</div>
	<div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="catalog/view/theme/<?=TEMPLATE?>/image/orders.png" alt="" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/history" style="font-weight: bold;"><?php echo $text_history; ?></a><br>
		</div>
		
	  <div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="catalog/view/theme/<?=TEMPLATE?>/image/download.png" alt="" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/download" style="font-weight: bold;"><?php echo $text_download; ?></a><br>
		</div>

		
	  <div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="catalog/view/theme/<?=TEMPLATE?>/image/delivery.gif" alt="" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/address" style="font-weight: bold;"><?php echo $text_address; ?></a><br>
		</div>
		
	  <div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="catalog/view/theme/<?=TEMPLATE?>/image/newsletter.png" alt="" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/newsletter" style="font-weight: bold;"><?php echo $text_my_newsletter; ?></a><br>
		</div>

  </div>
  <div class="bottom" style="width:580px; float:left;">
	<div class="left"></div>
	<div class="right"></div>
	<div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 