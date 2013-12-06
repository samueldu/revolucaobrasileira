<form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" target="ipagare_frame" id="checkout">
    <?php if($teste) 
	{
	?>
	<input type="hidden" name="teste" value="1" />
	<?php
	}
	?>
	<input type="hidden" name="estabelecimento" value="<?php echo $estabelecimento; ?>" />
	<input type="hidden" name="codigo_pagamento" value="<?php echo $codigo_pagamento; ?>" />   
	<input type="hidden" name="forma_pagamento" value="<?php echo $forma_pagamento; ?>" />     
	<input type="hidden" name="acao" value="1" />
	<input type="hidden" name="valor_total" value="<?php echo $valor_total; ?>" />
	<input type="hidden" name="chave" value="<?php echo $chave; ?>" />
	<input type="hidden" name="codigo_pedido" id="codigo_pedido" value="<?php echo $codigo_pedido; ?>" />
	<input type="hidden" name="nome_cliente" value="<?php echo $nome_cliente; ?>" />
	<input type="hidden" name="tipo_cliente" id="tipo_cliente" value="<?php echo $tipo_cliente; ?>" />
	<input type="hidden" name="cidade_cobranca" value="<?php echo $cidade_cobranca; ?>" />      
	<input type="hidden" name="email_cliente" value="<?php echo $email_cliente; ?>" />
	<input type="hidden" name="cpf_cnpj_cliente" value="<?php echo $cpf_cnpj_cliente; ?>" />  
	<input type="hidden" name="logradouro_cobranca" value="<?php echo $logradouro_cobranca; ?>" />  
	<input type="hidden" name="numero_cobranca" value="<?php echo $numero_cobranca; ?>" />  
	<input type="hidden" name="complemento_cobranca" value="<?php echo $complemento_cobranca; ?>" />  
	<input type="hidden" name="bairro_cobranca" value="<?php echo $bairro_cobranca; ?>" />  
	<input type="hidden" name="cep_cobranca" value="<?php echo $cep_cobranca; ?>" />  
	<input type="hidden" name="uf_cobranca" value="<?php echo $uf_cobranca; ?>" />  
	<input type="hidden" name="pais_cobranca" value="<?php echo $pais_cobranca; ?>" />  
	<input type="hidden" name="logradouro_entrega" value="<?php echo $logradouro_entrega; ?>" />  
	<input type="hidden" name="numero_entrega" value="<?php echo $numero_entrega; ?>" />  
	<input type="hidden" name="complemento_entrega" value="<?php echo $complemento_entrega; ?>" />  
	<input type="hidden" name="bairro_entrega" value="<?php echo $bairro_entrega; ?>" />  
	<input type="hidden" name="cep_entrega" value="<?php echo $cep_entrega; ?>" />  
	<input type="hidden" name="cidade_entrega" value="<?php echo $cidade_entrega; ?>" />  
	<input type="hidden" name="uf_entrega" value="<?php echo $uf_entrega; ?>" />  
	<input type="hidden" name="pais_entrega" value="<?php echo $pais_entrega; ?>" />  
	<input type="hidden" name="ddd_telefone_1" value="<?php echo $ddd_telefone_1; ?>" />  
	<input type="hidden" name="ddd_telefone_2" value="<?php echo $ddd_telefone_2; ?>" />  
	<input type="hidden" name="numero_telefone_1" value="<?php echo $numero_telefone_1; ?>" />  
	<input type="hidden" name="numero_telefone_2" value="<?php echo $numero_telefone_2; ?>" />  
</form>

<script language="javascript">

image1 = new Image();
image1.src = "<?=HTTP_IMAGE?>loading.gif";

		var loadit=function(){
		var f=document.getElementById('ipagare_frame'), 
		l=document.getElementById('loadingIpagare').style;
		if(f.onload==null){
		f.onload=function(){l.display='none'};
		if(window.attachEvent)
		f.attachEvent('onload', f.onload);
		}
		return true;
		}
			
setTimeout('loadit();',100);

function processaiPagare()
{	

				
		$.ajax({ 
			type: 'GET',
			url: 'index.php?route=payment/ipagare/confirm',
			success: function(data) {
			if(data == "OK")
			{
				$('#checkout').submit();
				$('#ipagare_frame').css("display" , "inline");
				$('#botoes_continuar_ipagare').css("display" , "none");
				$('.content.round').css("display" , "none");
				$('.ipagare_frame').css("display" , "block");
				$('#loadingIpagare').css("display" , "block");
			}
			else
			{
				alert('Algum produto do seu carrinho não se encontra mais disponivel para venda, você será redirecionado ao carrinho para poder verificar quais são esses produtos.');
				window.location = '?route=checkout/cart'; 
			}
			
			}		
		});
	
}

</script>
<div class="buttons">
<div id="loadingIpagare" name="loadingIpagare" style="display:none;">
<!--img src="<?=HTTP_IMAGE?>loading.gif" style="position: absolute; right: 50%;top:60%"-->
</div>
<iframe width="100%" height="800" id="ipagare_frame" name="ipagare_frame" frameborder="0" style="overflow: hidden; display: none; " >
<div id="loadingIpagare" name="loadingIpagare" style="display:none;">
<!--img src="<?=HTTP_IMAGE?>loading.gif" style="position: absolute; right: 50%;top:60%"-->    
</div>
</iframe>
  <!--table>
    <tr id="botoes_continuar_ipagare">
      <td align="left"><a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
      <td align="right"><a onclick="processaiPagare();" class="button"><span><?php echo $button_confirm; ?></span></a></td>
    </tr>
  </table-->
  
  <script>
  processaiPagare();
  </script>
  
</div>