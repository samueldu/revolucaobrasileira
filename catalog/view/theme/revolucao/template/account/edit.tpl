<?php echo $header; ?> 
<script type="text/javascript" src="catalog/view/javascript/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript">
jQuery(function($){
	$('input[name=dataNasc]').mask('99/99/9999');
	$('input[name=postcode]').mask('99999-999');
	$('input[name=fax]').mask('(99) - 9999-9999');
	$('input[name=telephone]').mask('(99) - 9999-9999');
    <?php             
	if(strlen($cpfCnpj) < 15)
	{
	$entry_cpfCnpj = "CPF:";	
	?>	
		$('input[name=cpfCnpj]').mask('999.999.999-99');
	<?php 
	}
	else
	{
		$entry_cpfCnpj = "CNPJ:";		
	?>
		$('input[name=cpfCnpj]').mask('99.999.999/9999-99');
	<?php 
	}	
	?>
});
</script>
<div id="content carrinho">
  <div class="middle account">
      <h1><?php echo $heading_title; ?></h1>
      <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="edit">
      <span style="margin-bottom: 2px; display: block; color:#666; padding-bottom:10px"><?php echo $text_your_details; ?></span>
      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px; " class="round">
        <table>
          <tr>
            <td width="120" align="right"><span class="required">*</span> <?php echo $entry_firstname; ?></td>
            <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" size="25" onkeydown="this.style.background = '#faffbd'"  />
              <?php if ($error_firstname) { ?>
              <span class="error"><?php echo $error_firstname; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_lastname; ?></td>
            <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" size="25" onkeydown="this.style.background = '#faffbd'"  />
              <?php if ($error_lastname) { ?>
              <span class="error"><?php echo $error_lastname; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_email; ?></td>
            <td><input type="text" name="email" value="<?php echo $email; ?>" size="30" onkeydown="this.style.background = '#faffbd'"  />
              <?php if ($error_email) { ?>
              <span class="error"><?php echo $error_email; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_cpfCnpj; ?></td>
            <td><input style="color:#999" type="text" name="cpfCnpj" size="30" value="<?php echo $cpfCnpj; ?>" onkeydown="this.style.background = '#faffbd'"   />
           </td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_rg; ?></td>
            <td><input type="text" name="rg" value="<?php echo $rg; ?>" onkeydown="this.style.background = '#faffbd'"   size="30"/>
              <?php if ($error_rg) { ?>
              <span class="error"><?php echo $error_rg; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_dataNasc; ?></td>
            <td><input type="text" name="dataNasc" value="<?php echo $dataNasc; ?>" onkeydown="this.style.background = '#faffbd'"   size="30"/>
              <?php if ($error_dataNasc) { ?>
              <span class="error"><?php echo $error_dataNasc; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_telephone; ?></td>
            <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" onkeydown="this.style.background = '#faffbd'"   size="30"/>
              <?php if ($error_telephone) { ?>
              <span class="error"><?php echo $error_telephone; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_fax; ?></td>
            <td><input type="text" name="fax" value="<?php echo $fax; ?>" onkeydown="this.style.background = '#faffbd'"   size="30"/>
            </td>
          </tr>
        </table>
      </div>
      <div class="buttons">
        <table>
          <tr>
            <td align="left"><a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
            <td align="right"><a onclick="$('#edit').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
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
<?php echo $footer; ?> 