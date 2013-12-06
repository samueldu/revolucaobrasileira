<div class="box_login box_create">
  <h3  onclick="navegaBox('<?=BASE_URL?>/account/login');"><span>Login</span></h3>
  <h3><span>Criar conta</span></h3>
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
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="create">
      <input type="hidden" name="tipoPessoa" id="tipoPessoa" value="<?=$tipoPessoa?>">
      <input type="hidden" name="dataNasc" value="01/01/1990">
      <input type="hidden" name="company" value="">
      <input type="hidden" name="sexo" value="">
      <input type="hidden" name="address_1" value="">
      <input type="hidden" name="address_3" value="">
      <input type="hidden" name="address_2" value="">
      <input type="hidden" name="bairro" value="">
      <input type="hidden" name="city" value="">
      <input type="hidden" name="postcode" value="">
      <input type="hidden" name="country_id" value="">
      <input type="hidden" name="zone_id" value="">
      <input type="hidden" name="telephone" value="">
      <input type="hidden" name="fax" value="">
      <input type="hidden" name="cpfCnpj" value="">
      <input type="hidden" name="rg" value="">
      <input type="hidden" name="m" value="m">
      <input type="hidden" name="lastname" value="">

      <!--div align="center" style="border-bottom:1px solid #f1f1f1;padding-bottom:10px">
		<label  id="typePeople"><input type="radio" style="vertical-align:middle" <?php if($tipoPessoa == 'PF') echo "checked='checked'"?> name="typePeople" onclick="javascript: window.location = '?route=account/create&tipoPessoa=PF'"> <span> Pessoa Fisica</span></label>
		<label  id="typePeople"><input type="radio" style="vertical-align:middle;margin-left:20px" <?php if($tipoPessoa == 'PJ') echo "checked='checked'"?> name="typePeople" onclick="javascript: window.location = '?route=account/create&tipoPessoa=PJ'"> <span> Pessoa Juridica</span></label>
	  </div-->
      <input type="hidden" name="tipoPessoa" value="PF">
      <div class="cadastro_form">
        <table>
          </tr>
          
          <tr>
            <td>
              <input type="text" id="firstname" name="firstname" placeholder="Nome" value="<?php echo $firstname; ?>" />
              <?php if ($error_firstname) { ?>
              <span class="error"><?php echo $error_firstname; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" size="30" />
              <?php if ($error_email) { ?>
              <span class="error"><?php echo $error_email; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td>
              <input type="password" placeholder="Senha" id="password" name="password" value="<?php echo $password; ?>" />
              <?php if ($error_password) { ?>
              <span class="error"><?php echo $error_password; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td>
              <input type="password" placeholder="Repetir Senha" name="confirm" id="confirm" value="<?php echo $confirm; ?>"  />
              <?php if ($error_confirm) { ?>
              <span class="error"><?php echo $error_confirm; ?></span>
              <?php } ?>
            </td>
          </tr>
          <!-- NEWSLETTER -->
        </table>
      </div>
      <div style="float:right; width:47%; margin-top:10px; display: none"> <span class="title"><?php echo $text_your_address; ?></span>
        <div class="boxCinza round" style="min-height:340px"> </div>
      </div>
      <?php if ($text_agree) { ?>
      <div class="buttons" style="float:left; width:50%; border: 1px solid green;">
        <table>
          <tr>
            <td width="120" class="leftColum"><?php echo $entry_newsletter; ?></td>
            <td>
              <?php if ($newsletter == 1) { ?>
              <input type="radio" name="newsletter" value="1" checked="checked"  />
              <?php echo $text_yes; ?>
              <input type="radio" name="newsletter" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="newsletter" value="1" style="vertical-align:middle" />
              <?php echo $text_yes; ?>
              <input type="radio" name="newsletter" value="0" checked="checked" style="vertical-align:middle" />
              <?php echo $text_no; ?>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td align="right" style="padding-right: 5px;"><?php echo $text_agree; ?></td>
            <td width="5" style="padding-right: 10px;">
              <?php if ($agree) { ?>
              <input type="checkbox" name="agree" value="1" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="agree" value="1" />
              <?php } ?>
            </td>
            <td align="right" width="5"><a onclick="$('#create').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
      <?php } else { ?>
      <div class="button_create"> <?php echo $entry_newsletter; ?>
        <?php if ($newsletter == 1 || empty($newsletter)) { ?>
        <input type="radio" name="newsletter" value="1" checked="checked"  />
        <span><?php echo $text_yes; ?></span>
        <input type="radio" name="newsletter" value="0" />
        <?php echo $text_no; ?>
        <?php } else { ?>
        <input type="radio" name="newsletter" value="1" style="vertical-align:middle" />
        <?php echo $text_yes; ?><br />
        <input type="radio" name="newsletter" value="0" checked="checked" style="vertical-align:middle" />
        <?php echo $text_no; ?>
        <?php } ?>
        <div class="button_loja button_position_create"><input type="button" onclick="cadastra()" value="<?=$button_continue?>" name="Cadastrar" id="btn_cadastrar"></div>
        <img src="catalog/view/theme/<?=TEMPLATE?>/image/btContinuar_wait.png" style="display:none;" id="btEsp"> </div>
      <?php } ?>
    </form>
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
<?php //echo $footer; ?>
