<?php echo $header; ?>

<script type="text/javascript" src="catalog/view/javascript/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript">
jQuery(function($){
	$('input[name=data]').mask('99/99/9999');
	$('input[name=postcode]').mask('99999-999');
	$('input[name=cel]').mask('(99) - 9999-9999');
	$('input[name=fone]').mask('(99) - 9999-9999');
	$('input[name=cpf]').mask('999.999.999-99');

});

function validate(form_id,email) {
 
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   var address = document.forms[form_id].elements[email].value;
   if(reg.test(address) == false) {
 
      alert('Email inválido');
      return false;
   }
}

</script>

  <?php if (isset($enviado)) { ?>
    <div class="success"><?php echo "Seu contato foi enviado com sucesso!"; ?></div>
    <?php } ?>

<form action="franquia-armazem" method="post" enctype="multipart/form-data" id="franquias" onsubmit="javascript:return validate('franquias','email');">

<div id="content carrinho">

  <div class="middle account">
      <h1><?php echo $heading_title; ?></h1>  
      <?php echo $description; ?>

      <table width="80%" border="0" cellpadding="0" cellspacing="2">
  
  <tr>

<td width="350" class="estilo"><div align="right">Nome:<b><i><font size="1" face="Verdana" color="#FFFFFF"></font></i></b></div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<input name="nome" type="text" class="fomu" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">CPF:</div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<input name="cpf" type="text" class="fomu" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">RG:<b><i><font size="1" face="Verdana" color="#FFFFFF"></font></i></b></div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<input name="rg" type="text" class="fomu" id="rg" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">Data Nascimento:<b><i><font size="1" face="Verdana" color="#FFFFFF"></font></i></b></div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<input name="data" type="text" class="fomu" id="data" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">Endere&ccedil;o:<b><i><font size="1" face="Verdana" color="#FFFFFF"></font></i></b></div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<input name="endereco" type="text" class="fomu" id="endereco" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">Bairro:<b><i><font size="1" face="Verdana" color="#FFFFFF"></font></i></b></div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<input name="bairro" type="text" class="fomu" id="bairro" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">Cidade:</div></td>

<td><b><i><b><i><font size="1" face="Verdana" color="#FFFFFF; color:#C40000">

<input name="cidade" type="text" class="fomu" size="38"/>

</font></i></b></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">Estado:<b><i><font size="1" face="Verdana" color="#FFFFFF; color:#C40000"></font></i></b></div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF; color:#C40000">

<input name="estado" type="text" class="fomu" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">Tel.Comercial:<b><i><font size="1" face="Verdana" color="#FFFFFF; color:#C40000"></font></i></b></div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF; color:#C40000">

<input name="fone" type="text" class="fomu" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">Tel. Residencial:<b><i><font size="1" face="Verdana" color="#FFFFFF; color:#C40000"></font></i></b></div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF; color:#C40000">

<input name="cel" type="text" class="fomu" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">E-mail:<b><i><font size="1" face="Verdana" color="#FFFFFF; color:#C40000"></font></i></b></div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF; color:#C40000">

<input name="email" type="text" class="fomu" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">Local de Interesse:</div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<input name="interesse" type="text" class="fomu" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">Capacidade de Investimento:</div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<input name="investimento" type="text" class="fomu" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td align="right" class="estilo">Depende do valor de algum bem,  outras fontes? 

  Caso positivo, especificar:<b><br />

     </b></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<input name="bem" type="text" class="fomu" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td align="right" class="estilo">Tem ponto comercial? Caso positivo, especificar:<b><br />

  

</b></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<input name="ponto" type="text" class="fomu" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right"><span class="style1">Como tomou conhecimento da marca Armaz&eacute;m?<b><br />



  </b></div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<input name="marca" type="text" class="fomu" size="38"/>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"><div align="right">Observa&ccedil;&otilde;es:</div></td>

<td><b><i><font size="1" face="Verdana" color="#FFFFFF">

<textarea name="textodamensagem" cols="30" rows="4" class="fomu"></textarea>

</font></i></b></td>

</tr>

<tr>

<td class="estilo"></td>

<td><input name="enviar" type="submit" value="Enviar Mensagem"/></td>

</tr>

</table> 
&nbsp;&nbsp;
    </form></td>
  </tr>
</table>
      
  
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
</div>

<?php echo $footer; ?> 