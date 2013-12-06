<?php echo $header; ?>
<div class="box">
 <div class="left"></div>
 <div class="right"></div>
 <div class="heading">
   <h1 style="background-image: url('view/image/product.png');"><?php echo $heading_title; ?></h1>
   <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_update; ?></span></a></div>
 </div>
 <div class="content">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <table>
  	<tr>
  		<td><?php echo $entry_client;?></td>
  		<td><input type="text" name="client" id="client"></td>
  	</tr>
  	<tr>
  		<td><?php echo $entry_note;?></td>
  		<td><input type="text" name="note" id="note"></td>
  	</tr>
  </table>
  </form>
 </div>
</div>
<?php echo $footer; ?>