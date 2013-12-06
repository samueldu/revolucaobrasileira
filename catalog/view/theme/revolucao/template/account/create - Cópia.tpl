<?php echo $header; ?>
<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px" />

<?php 
if(isset($_GET['tipoPessoa']))
$tipoPessoa = $_GET['tipoPessoa'];
?>

<script type="text/javascript" src="catalog/view/javascript/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript">
jQuery(function($){
	$('input[name=dataNasc]').mask('99/99/9999');
	$('input[name=postcode]').mask('99999-999');
	$('input[name=fax]').mask('(99) - 9999-9999');
	$('input[name=telephone]').mask('(99) - 9999-9999');
	<?php 
	if($tipoPessoa == "PF")
	{
	?>	
		$('input[name=cpfCnpj]').mask('999.999.999-99');
	<?php 
	}
	else
	{
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
	<form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="create">
	<input type="hidden" name="tipoPessoa" id="tipoPessoa" value="<?=$tipoPessoa?>">
	  <p style="color:#666"><?php echo $text_account_already; ?></p>
	  <div align="center" style="border-bottom:1px solid #f1f1f1;padding-bottom:10px">
		<label  id="typePeople"><input type="radio" style="vertical-align:middle" <?php if($tipoPessoa == 'PF') echo "checked='checked'"?> name="typePeople" onclick="javascript: window.location = '?route=account/create&tipoPessoa=PF'"> <span> Pessoa Fisica</span></label>
		<label  id="typePeople"><input type="radio" style="vertical-align:middle;margin-left:20px" <?php if($tipoPessoa == 'PJ') echo "checked='checked'"?> name="typePeople" onclick="javascript: window.location = '?route=account/create&tipoPessoa=PJ'"> <span> Pessoa Juridica</span></label>
	  </div>
	  <div  style="float:left; width:48%; margin-top:10px">
	  <span class="title"><?php echo $text_your_details; ?></span>
	  <div class="boxCinza round" style="min-height:340px">
		<table>
		  </tr> 
		  <tr>
			<td width="120" class="leftColum"><span class="required">*</span> <span id="nome"><?php echo $entry_firstname; ?></span></td>
			<td><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
			  <?php if ($error_firstname) { ?>
			  <span class="error"><?php echo $error_firstname; ?></span>
			  <?php } ?></td>
		  </tr>
		  <tr>
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_lastname; ?></td>
			<td><input type="text" name="lastname" value="<?php echo $lastname; ?>" />
			  <?php if ($error_lastname) { ?>
			  <span class="error"><?php echo $error_lastname; ?></span>
			  <?php } ?></td>
		  </tr>
		  
		  <?php 
		  if($tipoPessoa == "PF")
		  {
		  ?>         
		  <tr>
			<td width="120" class="leftColum"><span class="required">*</span> <span id="nome"><?php echo $entry_sexo; ?></span></td>
			<td><select name="sexo">
			<option name="m" value="m"  <?php if ($sexo == "m") {echo "checked";} ?> >Masculino</option>
			<option name="f" value="m"  <?php if ($sexo == "m") {echo "checked";} ?>>Feminino</option>
			</select>
			  <?php if ($error_sexo) { ?>
			  <span class="error"><?php echo $error_sexo; ?></span>
			  <?php } ?></td>
		  </tr>
		  
		  <?php 
		  }
		  else
		  {
		  ?>
			<input type=hidden name=sexo value=m>
		  <?php 
		  }
		  ?>
		  
		  <tr>
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_email; ?></td>
			<td><input type="text" name="email" value="<?php echo $email; ?>" size="30" />
			  <?php if ($error_email) { ?>
			  <span class="error"><?php echo $error_email; ?></span>
			  <?php } ?></td>
		  </tr>
		  <tr>
			<td class="leftColum"><span class="required">*</span><?php echo $entry_dataNasc; ?></td>
			<td><input type="text" name="dataNasc" value="<?php echo $dataNasc; ?>" size="10" />
			<?php if ($error_dataNasc) { ?>
			<span class="error"><?php echo $error_dataNasc; ?></span>
			<?php } ?></td>
			</td>
		  </tr>          
		  <tr>
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_cpfCnpj; ?></td>
			<td><input type="text" name="cpfCnpj" value="<?php echo $cpfCnpj; ?>"size="15" />
			  <?php if ($error_cpfCnpj) { ?>
			  <span class="error"><?php echo $error_cpfCnpj; ?></span>
			  <?php } ?></td>
		  </tr>
		  <tr>
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_rg; ?></td>
			<td><input type="text" name="rg" value="<?php echo $rg; ?>"size="15" />              
			<?php if ($error_rg) { ?>
			  <span class="error"><?php echo $error_rg; ?></span>
			  <?php } ?></td>
		  </tr>          
					
		  <tr>
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_telephone; ?></td>
			<td><input type="text" name="telephone" value="<?php echo $telephone; ?>" size="15" />
			  <?php if ($error_telephone) { ?>
			  <span class="error"><?php echo $error_telephone; ?></span>
			  <?php } ?></td>
		  </tr>
		  
		  <tr>
			<td class="leftColum"><?php echo $entry_fax; ?></td>
			<td><input type="text" name="fax" value="<?php echo $fax; ?>" size="15" />
			<td>
		  </tr>

<!-- SENHA -->
	<!-- tr>
	<td></td>
	<td><span class="title"><?php echo $text_your_password; ?></span>
</td>
	</tr-->
   <tr>
			<td width="120" class="leftColum"><span class="required">*</span> <?php echo $entry_password; ?></td>
			<td><input type="password" name="password" value="<?php echo $password; ?>" />
			  <?php if ($error_password) { ?>
			  <span class="error"><?php echo $error_password; ?></span>
			  <?php } ?></td>
		  </tr>
		  <tr>
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_confirm; ?></td>
			<td><input type="password" name="confirm" value="<?php echo $confirm; ?>"  />
			  <?php if ($error_confirm) { ?>
			  <span class="error"><?php echo $error_confirm; ?></span>
			  <?php } ?></td>
		  </tr>
		 <!-- NEWSLETTER -->
		</table>
	  </div>
  
	  </div>
	  
	  <div style="float:right; width:47%; margin-top:10px">
	  <span class="title"><?php echo $text_your_address; ?></span>
	  <div class="boxCinza round" style="min-height:340px">
		<table >
		  <tr>
			<td id="postcode" class="leftColum"><?php echo $entry_postcode; ?></td>
			<td><input type="text" name="postcode" value="<?php echo $postcode; ?>" size="8" maxlength="8" onblur="javascript:getCEP(this.value)"/>
			  <?php if ($error_postcode) { ?>
			  <span class="error"><?php echo $error_postcode; ?></span>
			  <?php } ?></td>
		  </tr>      
		  <?php 
		  if($tipoPessoa == "PF")
		  {
		  ?>                    
		  <tr>
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_company; ?></td>
			<td><input type="text" name="company" value="<?php echo $company; ?>" size="30" />
			  <?php if ($error_company) { ?>
			  <span class="error"><?php echo $error_company; ?></span>
			  <?php } ?></td>
		  </tr>
		  <?php 
		  }
		  else
		  {
		  ?>
		  <input type="hidden" name="company" value="Endereco de cadastro">
		  <?php 
		  }
		  ?>
		  
		  <tr>
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_address_1; ?></td>
			<td><input type="text" name="address_1" value="<?php echo $address_1; ?>" size="30" />
			  <?php if ($error_address_1) { ?>
			  <span class="error"><?php echo $error_address_1; ?></span>
			  <?php } ?></td>
		  </tr>
		  <tr>
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_address_3; ?></td>
			<td><input type="text" name="address_3" value="<?php echo $address_3; ?>" size="30" />
			  <?php if ($error_address_3) { ?>
			  <span class="error"><?php echo $error_address_3; ?></span>
			  <?php } ?></td>
		  </tr>
		  <tr>
			<td class="leftColum"><span class="required"></span> <?php echo $entry_address_2; ?></td>
			<td><input type="text" name="address_2" value="<?php echo $address_2; ?>" size="30" />
			  <?php if ($error_address_2) { ?>
			  <span class="error"><?php echo $error_address_2; ?></span>
			  <?php } ?></td>
		  </tr>
		  <tr>
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_bairro; ?></td>
			<td><input type="text" name="bairro" value="<?php echo $bairro; ?>" size="30" />
			  <?php if ($error_bairro) { ?>
			  <span class="error"><?php echo $error_bairro; ?></span>
			  <?php } ?></td>
		  </tr>             
		  <tr>             
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_city; ?></td>
			<td><input type="text" name="city" value="<?php echo $city; ?>" />
			  <?php if ($error_city) { ?>
			  <span class="error"><?php echo $error_city; ?></span>
			  <?php } ?></td>
		  </tr>
		  
		  <tr style="display:none">
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_country; ?></td>
			<td><select name="country_id" id="country_id" onchange="$('select[name=\'zone_id\']').load('index.php?route=account/create/zone&country_id=' + this.value + '&zone_id=<?php echo $zone_id; ?>'); $('#postcode').load('index.php?route=account/create/postcode&country_id=' + this.value);">
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
			  <?php } ?></td>
		  </tr>
		  <tr>
			<td class="leftColum"><span class="required">*</span> <?php echo $entry_zone; ?></td>
			<td><select name="zone_id">
			  </select>
			  <?php if ($error_zone) { ?>
			  <span class="error"><?php echo $error_zone; ?></span>
			  <?php } ?></td>
		  </tr>
		  
		</table>
	  </div>
	  </div>

	  <?php if ($text_agree) { ?>
	  <div class="buttons" style="float:left; width:100%">
		<table>
		  <tr>
			<td width="120" class="leftColum"><?php echo $entry_newsletter; ?></td>
			<td><?php if ($newsletter == 1) { ?>
			  <input type="radio" name="newsletter" value="1" checked="checked"  />
			  <?php echo $text_yes; ?>
			  <input type="radio" name="newsletter" value="0" />
			  <?php echo $text_no; ?>
			  <?php } else { ?>
			  <input type="radio" name="newsletter" value="1" style="vertical-align:middle" />
			  <?php echo $text_yes; ?>
			  <input type="radio" name="newsletter" value="0" checked="checked" style="vertical-align:middle" />
			  <?php echo $text_no; ?>
			  <?php } ?></td>
		  </tr>
		  <tr>
			<td align="right" style="padding-right: 5px;"><?php echo $text_agree; ?></td>
			<td width="5" style="padding-right: 10px;"><?php if ($agree) { ?>
			  <input type="checkbox" name="agree" value="1" checked="checked" />
			  <?php } else { ?>
			  <input type="checkbox" name="agree" value="1" />
			  <?php } ?></td>
			<td align="right" width="5"><a onclick="$('#create').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
		  </tr>
		</table>
	  </div>
	  <?php } else { ?>
	  <div class="buttons">
		<table>
		  <tr>
			<td width="680"></td>
			<td width="90"><?php echo $entry_newsletter; ?></td>
			<td><?php if ($newsletter == 1 || empty($newsletter)) { ?>
			  <input type="radio" name="newsletter" value="1" checked="checked"  />
			  <?php echo $text_yes; ?><br />
			  <input type="radio" name="newsletter" value="0" />
			  <?php echo $text_no; ?>
			  <?php } else { ?>	
			  <input type="radio" name="newsletter" value="1" style="vertical-align:middle" />
			  <?php echo $text_yes; ?><br />
			  <input type="radio" name="newsletter" value="0" checked="checked" style="vertical-align:middle" />
			  <?php echo $text_no; ?>
			  <?php } ?></td>
			<td align="right"><a onclick="$('#create').submit();" class="button" id="btn_cadastrar"><span><?php echo $button_continue; ?></span></a>
			
			<img src="catalog/view/theme/<?=TEMPLATE?>/image/btContinuar_wait.png" style="display:none;" id="btEsp">
			
			</td>
		  </tr>
		</table>
	  </div>
	  <?php } ?>
	</form>
  </div>
  <div class="bottom">
	<div class="left"></div>
	<div class="right"></div>
	<div class="center"></div>
  </div>
</div>

 <script type="text/javascript"><!--
$('select[name=\'zone_id\']').load('index.php?route=account/create/zone&country_id=<?php echo $country_id; ?>&zone_id=<?php echo $zone_id; ?>');
$('#postcode').load('index.php?route=account/create/postcode&country_id=<?php echo $country_id; ?>');

function getCEP(postcode) {
	$("#btn_cadastrar").css("display","none");
	$("#btEsp").css("display","block");
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
			$("#btn_cadastrar").css('display','inline-block');
			$("#btEsp").css("display","none");
		}
	});
}
//--></script>
<?php echo $footer; ?> 