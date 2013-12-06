<?php echo $header; ?>
<script type="text/javascript" src="view/javascript/color/mColorPicker.js"></script>    
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/order.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <?php foreach ($languages as $language) { ?>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_name; ?></td>
          <td><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />     <input name="order_status[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($order_status[$language['language_id']]) ? $order_status[$language['language_id']]['name'] : ''; ?>" size=50 /><input type="color" name="order_status[<?php echo $language['language_id']; ?>][color]" value="<?php echo isset($order_status[$language['language_id']]) ? $order_status[$language['language_id']]['color'] : ''; ?>" value="#ff0667" data-text="hidden" data-hex="true"   style="height:20px;width:20px;" />
            <?php
             if (isset($error_name[$language['language_id']])) { ?>
            <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
            <?
        	} 
        	?></td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>