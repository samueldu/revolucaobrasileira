<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/module.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
        	<td><?php echo $entry_products;?></td>
            <td height="150">
            	<div style="border:1px;height:150px;overflow-y:scroll">
            		<div>
            	<?php 
            		$categoria = null;
            		foreach ($productsCategories as $product){
            			if(is_null($categoria) || $categoria != $product["category_id"]){
            				echo "</div>";
            				echo "<b><a href='javascript:openProducts(\"".$product["category_id"]."\")'>".$product["category_name"]."</a></b><br>";
            				$categoria = $product["category_id"];
            				echo "<div id='category_".$product["category_id"]."' style='display:none'>";
            			} 
            	?>
            	&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox">&nbsp;&nbsp;<?php echo $product["product_name"]?><br>
                <?php } ?>
                	</div>
                </div>
            </td>
        </tr>
        
        <tr>
        	<td><?php echo $entry_limit; ?></td>
            <td><input name="categoryproducthome_limit" type="text" value="<?php echo $categoryproducthome_limit; ?>" size="1" /></td>
        </tr>
        
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="categoryproducthome_status">
              <?php if ($categoryproducthome_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="categoryproducthome_sort_order" value="<?php echo $categoryproducthome_sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script type="text/javascript">
<!--
function openProducts(category_id){
	$("#category_"+category_id).toggle();
}
//-->
</script>
<?php echo $footer; ?>