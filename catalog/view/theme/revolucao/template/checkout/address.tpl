<?php echo $header; ?>
<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px" />
<div id="content carrinho">
  <div class="middle account">
      <h1><?php echo $heading_title; ?></h1>
    <?php if ($addresses) { ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="address_1">
      <span style="margin-bottom: 2px; display: block; padding-bottom:10px"><?php echo $text_entries; ?></span>
      <div class="content round">
        <table width="536" cellpadding="3">
          <?php foreach ($addresses as $address) { ?>
          <?php if ($address['address_id'] == $default) { ?>
          <tr>
            <td width="1">
            <input type="radio" name="address_id" value="<?php echo $address['address_id']; ?>" id="address_id[<?php echo $address['address_id']; ?>]" checked="checked" style="margin: 0px;" /></td>
            <td><label for="address_id[<?php echo $address['address_id']; ?>]" style="cursor: pointer;"><?php echo $address['address']; ?></label></td>
            <td><a onclick="location = '<?php echo $address['edit']; ?>'" class="button"><span><?php echo $button_edit; ?></span></a></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td width="1"><input type="radio" name="address_id" value="<?php echo $address['address_id']; ?>" id="address_id[<?php echo $address['address_id']; ?>]" style="margin: 0px;" /></td>
            <td><label for="address_id[<?php echo $address['address_id']; ?>]" style="cursor: pointer;"><?php echo $address['address']; ?></label></td>
                        <td><a onclick="location = '<?php echo $address['edit']; ?>'" class="button"><span><?php echo $button_edit; ?></span></a></td> 
          </tr>
          <?php } ?>
          <?php } ?>
        </table>
      </div>
      <div class="buttons">
        <table>
          <tr>
            <td align="right"><a onclick="$('#address_1').submit();" class="button"><span><?php echo $button_use_this_address; ?></span></a></td>
          </tr>
        </table>
      </div>
    </form>
    <?php } ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="address_2">
      <h1><?php echo $text_new_address; ?></h1>
      <div class="content round">
        <table>
                  <tr>
            <td align="right"><?php echo $entry_company; ?></td>
            <td><input type="text" name="company" value="<?php echo $company; ?>" /></td>
          </tr>
          <tr>
            <td width="120" align="right"><span class="required">*</span> <?php echo $entry_firstname; ?></td>
            <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
              <?php if ($error_firstname) { ?>
              <span class="error"><?php echo $error_firstname; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_lastname; ?></td>
            <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" />
              <?php if ($error_lastname) { ?>
              <span class="error"><?php echo $error_lastname; ?></span>
              <?php } ?></td>
          </tr>
              <tr>
            <td align="right" id="postcode"><?php echo $entry_postcode; ?></td>
            <td><input type="text" name="postcode" value="<?php echo $postcode; ?>" onblur="javascript:getCEP(this.value)" />
			  <?php if ($error_postcode) { ?>
              <span class="error"><?php echo $error_postcode; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_address_1; ?></td>
            <td><input type="text" name="address_1" value="<?php echo $address_1; ?>" />
              <?php if ($error_address_1) { ?>
              <span class="error"><?php echo $error_address_1; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $entry_address_2; ?></td>
            <td><input type="text" name="address_2" value="<?php echo $address_2; ?>" /></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_address_3; ?></td>
            <td><input type="text" name="address_3" value="<?php echo $address_3; ?>" />
              <?php if ($error_address_3) { ?>
              <span class="error"><?php echo $error_address_3; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_bairro; ?></td>
            <td><input type="text" name="bairro" value="<?php echo $bairro; ?>" />
              <?php if ($error_bairro) { ?>
              <span class="error"><?php echo $error_bairro; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_city; ?></td>
            <td><input type="text" name="city" value="<?php echo $city; ?>" />
              <?php if ($error_city) { ?>
              <span class="error"><?php echo $error_city; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
	          <td align="right">
	            <input type="hidden"  name="country_id" id="country_id" value="30">
	          </td>
          </tr>
          
          <!--tr>
            <td align="right">
            <span class="required">*</span> <?php echo $entry_country; ?></td>
            <td>
            <select name="country_id" id="country_id" onchange="$('select[name=\'zone_id\']').load('index.php?route=account/address/zone&country_id=' + this.value + '&zone_id=<?php echo $zone_id; ?>'); $('#postcode').load('index.php?route=account/address/postcode&country_id=' + this.value);">
                <option value="FALSE"><?php echo $text_select; ?></option>
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_country) { ?>
              <span class="error"><?php echo $error_country; ?></span>
              <?php } ?>
              </td>
          </tr-->
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_zone; ?></td>
            <td><select name="zone_id">
              </select>
              <?php if ($error_zone) { ?>
              <span class="error"><?php echo $error_zone; ?></span>
              <?php } ?></td>
          </tr>
        </table>
      </div>
      <div class="buttons">
        <table>
          <tr>
            <td align="right"><a onclick="$('#address_2').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
    </form>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<script type="text/javascript" src="catalog/view/javascript/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript"><!--
$('select[name=\'zone_id\']').load('index.php?route=checkout/address/zone&country_id=<?php echo $country_id; ?>&zone_id=<?php echo $zone_id; ?>');
$('#postcode').load('index.php?route=checkout/create/postcode&country_id=<?php echo $country_id; ?>');
jQuery(function($){
	$('input[name=postcode]').mask('99999-999');
});
function getCEP(postcode) {
	$("input[name='address_1']").val('Carregando ...');
	$("input[name='bairro']").val('Carregando ...');
	$("input[name='city']").val('Carregando ...');
	$("select[name='zone_id'] option").each(function(){
		if($(this).text() == ' --- Selecione --- '){
			$(this).attr("selected", true);
		}
	});
	
	$.ajax({
		type: 'POST',
		url: 'index.php?route=account/create/postcep&postcode='+postcode,
		dataType: 'json',
		success: function(data) {
			$("input[name='address_1']").val(data.logradouro);
			$("input[name='bairro']").val(data.bairro);
			$("input[name='city']").val(data.cidade);
			$("select[name='zone_id'] option").each(function(){
				if($(this).text() == data.estado){
					$(this).attr("selected", true);
				}
			});
		}
	});
}
//--></script>
<?php echo $footer; ?> 