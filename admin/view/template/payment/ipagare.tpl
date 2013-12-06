<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/payment.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_estabelecimento; ?><br><span class="help"><?php echo $explain_estabelecimento; ?></span></td>
          <td><input type="text" name="ipagare_estabelecimento" value="<?php echo $ipagare_estabelecimento; ?>" />
			<?php if ($error_estabelecimento) { ?>
            <span class="error"><?php echo $error_estabelecimento; ?></span>
            <?php } ?></td>
        </tr>
		<tr>
          <td><span class="required">*</span> <?php echo $entry_chave ?><br><span class="help"><?php echo $explain_chave; ?></span></td>
          <td><input type="text" name="ipagare_chave" value="<?php echo $ipagare_chave; ?>" />
			<?php if ($error_chave) { ?>
            <span class="error"><?php echo $error_chave; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_teste; ?></td>
          <td><?php if ($ipagare_teste) { ?>
            <input type="radio" name="ipagare_teste" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="ipagare_teste" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="ipagare_teste" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="ipagare_teste" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_debug; ?></td>
          <td><?php if ($ipagare_debug) { ?>
            <input type="radio" name="ipagare_debug" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="ipagare_debug" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="ipagare_debug" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="ipagare_debug" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_geo_zone; ?></td>
          <td><select name="ipagare_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $ipagare_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
		<!-- Status X -->
		<tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="ipagare_status">
              <?php if ($ipagare_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
		<!-- Status para Pedido Aguardando -->
		<tr>
          <td><?php echo $entry_order_status_aguardando; ?></td>
          <td><select name="ipagare_entry_order_status_aguardando">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $ipagare_entry_order_status_aguardando) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>        
		<!-- Status para Pedido Aprovado -->
		<tr>
          <td><?php echo $entry_order_status_aprovado; ?></td>
          <td><select name="ipagare_entry_order_status_aprovado">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $ipagare_entry_order_status_aprovado) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
		<!-- Status para Pedido Capturado -->
		<tr>
          <td><?php echo $entry_order_status_capturado; ?></td>
          <td><select name="ipagare_entry_order_status_capturado">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $ipagare_entry_order_status_capturado) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
		
		<!-- Status para Pedido Reprovado -->
		<tr>
          <td><?php echo $entry_order_status_reprovado; ?></td>
          <td><select name="ipagare_entry_order_status_reprovado">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $ipagare_entry_order_status_reprovado) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>

		<!-- Status para Pedido Cancelado -->
		<tr>
          <td><?php echo $entry_order_status_cancelado; ?></td>
          <td><select name="ipagare_entry_order_status_cancelado">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $ipagare_entry_order_status_cancelado) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>

		<!-- Status para Pedido Completo -->
<!--		<tr>
          <td><?php echo $entry_order_status_completo; ?></td>
          <td><select name="ipagare_entry_order_status_completo">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $ipagare_entry_order_status_completo) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
-->		
<!--		
		<!-- Status para Pedido Em Analise -->
		<tr>
          <td><?php echo $entry_order_status_analise; ?></td>
          <td><select name="ipagare_entry_order_status_analise">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $ipagare_entry_order_status_analise) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
		
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="ipagare_sort_order" value="<?php echo $ipagare_sort_order; ?>" size="1" /></td>
        </tr>
		
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>