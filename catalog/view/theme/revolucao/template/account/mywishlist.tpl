

<?php echo $header; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle">
   <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
	<form id="wishlist" enctype="multipart/form-data" method="post">
		  <table class="cart wishlistList">
			<tbody>
            <?php if($this->customer->getId()){?>
              <!--tr>
              <td colspan="6"><div id="msg_id"></div><table><tr><td><?php echo $entry_email?></td><td><input name="email" id="email" type="text" /><a href="javascript:sharetofrds();" class="button"><span><?php echo $button_send;?></span></a></td></tr></table></td>
              </tr-->
              <?php }?>
			  <tr> <?php if($this->customer->getId()){?>
				<th align="center"><?php echo $entry_remove;?></th>
                <?php }?>
				<th align="center"></th>
				<th align="left"><?php echo $entry_name;?></th>
				<th align="left"><?php echo $entry_model;?></th>
				<th align="right"><?php echo $entry_price;?></th>
				<th align="right">&nbsp;</th>
			  </tr>
			  <?php 
			  if(count($listdata)>0){
			  	$o=0;
				foreach($listdata as $k=>$v){
			  ?>
			  <tr class="even">
               <?php if($this->customer->getId()){?>
						<td valign="top" align="center"><a href="index.php?route=account/mywishlist&amp;action=del&amp;id=<?php echo $v['id']?>"><span><img src="catalog/view/theme/<?=TEMPLATE?>/image/list_remove_btn.gif" /></span></a></td>
                    <?php }?>    
					<td align="center"><?php echo $v['image'];?></td>
					<td valign="top" align="left"><a href="index.php?route=product/product&amp;product_id=<?php echo $v['product_id']?>"><?php echo $v['name'];?></a>
					  <div> </div></td>
					<td valign="top" align="left"><?php echo $v['model']?></td>
					<td valign="top" align="right"><?php echo $v['price']?></td>
					<td valign="top" align="right"><a href="index.php?route=checkout/cart&amp;product_id=<?php echo $v['product_id']?>" class="button cartspecial"><span><?php echo $button_buy;?></span></a></td>
				  </tr>
				<?php }}else{?>
				<tr class="even"><td colspan="5"><?php echo $text_notfound;?></td></tr>
				<?php }?>  
				</tbody>
		  </table>
		  <div style="width: 100%; display: inline-block;"></div>
		</form>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<script language="javascript">
function sharetofrds(){
	var myData = 'email='+$('#email').val();
	$.ajax({
		type: 'post',
		url: 'index.php?route=account/mywishlist/sendemail',
		dataType: 'html',
		data: myData,
		success: function (html) {
			$('#msg_id').html(html);
		},
		complete: function () {
			$('#msg_id').show();
			$('#msg_id').fadeOut(4000);
		}
	});	
}
</script>
<?php echo $footer; ?> 