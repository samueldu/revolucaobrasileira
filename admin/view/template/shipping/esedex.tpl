<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/shipping.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <table class="form">
      <tr>
        <td><span class="required">*</span> <?php echo $entry_postcode; ?><br />
          </td>
        <td><input name="esedex_postcode" type="text" id="esedex_postcode" value="<?php echo $esedex_postcode; ?>" />
         <?php if ($error_postcode) { ?>
                <span class="error"><?php echo $error_postcode; ?></span>
                <?php  } ?>
        </td>
      </tr>
      
      <tr>
        <td><?php echo $entry_mao_propria; ?><br />
          </td>
        <td>
        <select name="esedex_mao_propria">
	        <option value="n" <?php echo ($esedex_mao_propria == 'n') ? ' selected="selected" ' : ''; ?>><?php echo $text_nao; ?></option>
	        <option value="s" <?php echo ($esedex_mao_propria == 's') ? ' selected="selected" ' : ''; ?>><?php echo $text_sim; ?></option>
		</select>
        </td>
      </tr>
      
      <tr>
        <td><?php echo $entry_aviso_recebimento; ?><br />
          </td>
        <td>
        <select name="esedex_aviso_recebimento">
	        <option value="n" <?php echo ($esedex_aviso_recebimento == 'n') ? ' selected="selected" ' : ''; ?>><?php echo $text_nao; ?></option>
	        <option value="s" <?php echo ($esedex_aviso_recebimento == 's') ? ' selected="selected" ' : ''; ?>><?php echo $text_sim; ?></option>
		</select>
        </td>
      </tr> 
      
      <tr>
        <td><?php echo $entry_declarar_valor; ?><br />
          </td>
        <td>
        <select name="esedex_declarar_valor">
	        <option value="n" <?php echo ($esedex_declarar_valor == 'n') ? ' selected="selected" ' : ''; ?>><?php echo $text_nao; ?></option>
	        <option value="s" <?php echo ($esedex_declarar_valor == 's') ? ' selected="selected" ' : ''; ?>><?php echo $text_sim; ?></option>
		</select>
        </td>
      </tr>
      
      <tr>
        <td><?php echo $entry_adicional; ?><br />
          </td>
        <td><input name="esedex_adicional" type="text" id="esedex_adicional" value="<?php echo $esedex_adicional; ?>" />
        </td>
      </tr>       
      
      <tr>
      <tr>
        <td><?php echo $entry_tax; ?></td>
        <td><select name="esedex_tax_class_id">
          <option value="0"><?php echo $text_none; ?></option>
          <?php foreach ($tax_classes as $tax_class) { ?>
          <?php if ($tax_class['tax_class_id'] == $esedex_tax_class_id) { ?>
          <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
          <?php } ?>
          <?php } ?>
        </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_geo_zone; ?></td>
        <td><select name="esedex_geo_zone_id">
            <option value="0"><?php echo $text_all_zones; ?></option>
            <?php foreach ($geo_zones as $geo_zone) { ?>
            <?php if ($geo_zone['geo_zone_id'] == $esedex_geo_zone_id) { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_status; ?></td>
        <td><select name="esedex_status">
            <?php if ($esedex_status) { ?>
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
        <td><input type="text" name="esedex_sort_order" value="<?php echo $esedex_sort_order; ?>" size="1" /></td>
      </tr>
    </table>
</form>
</div>
</div>
<?php echo $footer; ?>