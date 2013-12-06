<?php echo $header; ?>
<script type="text/javascript">

function dimOffx()
{    
	document.getElementById("darkLayer").style.display = "none";
	document.getElementById("QuickViewX").style.display = "none";
}
function dimOnx()
{    
	document.getElementById("darkLayer").style.display = "block";
}

$(window).load(function() {

	$.ajax({ 
		type: 'GET',
		url: 'information/information/loadInfo?',
		dataType: "html",
		data: ({information_id : 4}),
		success: function(data) {
			$("#QuickViewX").html(data);
		}
	})

	$('input[class=card]').mask('9999-9999-9999-9999')
	
	$('.clickBoomx').click(function() {

		$('#QuickViewX').slideDown(500);
		$("#darkLayer").css("display","block");
		
			$("#darkLayer").click(function(){			
			$("#QuickViewX").css("display","none");			
			$("#darkLayer").css("display","none");

		});
		});
		jQuery.fn.centerx = function () {    
			this.css("position","fixed");  
			this.css("top","20%");
			this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");   
				return this;
			}
			$('#QuickViewX').centerx();

	
	});

</script>
<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px;" />
<div id="content carrinho">
  <div class="middle account">
      <h1><?php echo $heading_title; ?></h1>  
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
      <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" name="shipping" id="shipping">
      <!--b style="margin-bottom: 2px; display: block;"><?php echo $text_shipping_address; ?></b-->
      <p><?php echo $text_shipping_to; ?></p>
      <div class="content round">
        <table width="100%">
          <tr>
          <td width="50%" valign="top"><b><?php echo $text_shipping_address; ?></b><br />
              <span style="font-size:11px"><?php echo $address; ?></span></td>
            <td width="50%" valign="bottom">
              <div style="text-align: right; padding-top:15px;"><a onclick="location = '<?php echo str_replace('&', '&amp;', $change_address); ?>'" class="button"><span><?php echo $button_change_address; ?></span></a></div></td>
            
          </tr>
        </table>
      </div>
      
      <?


      
      if ($shipping_methods) { ?>
      
      <h1><?php echo $text_shipping_method; ?></h1><p><?php echo $text_shipping_methods; ?></p>
      <div class="content round">
        
        <table width="100%" cellpadding="3">
          <?php foreach ($shipping_methods as $shipping_method) { ?>
          <tr>
            <td colspan="3"><b><?php echo $shipping_method['title']; ?></b></td>
          </tr>
          <?php if (!$shipping_method['error']) { ?>
          <?php foreach ($shipping_method['quote'] as $quote) { ?>
          <tr>
            <td><label for="<?php echo $quote['id']; ?>">
                <?php if ($quote['id'] == $shipping) { ?>
				<?php $shipping = $quote['id']; ?>
                <input type="radio" id="shipping_method" name="shipping_method" value="<?php echo $quote['id']; ?>" id="<?php echo $quote['id']; ?>" checked="checked" onclick="$('#shipping').submit();" style="margin: 0 5px 0 0;vertical-align:middle" />
                
                <?php } else { ?>
                <input type="radio" id="shipping_method" name="shipping_method" value="<?php echo $quote['id']; ?>" id="<?php echo $quote['id']; ?>" onclick="$('#shipping').submit();" style="margin: 0 5px 0 0;vertical-align:middle" />
                <?php } ?>
              </label>
              <label for="<?php echo $quote['id']; ?>" style="cursor: pointer;margin: 0 15px 0 0;"><?php echo $quote['title']; ?></label>
           
              <label for="<?php echo $quote['id']; ?>" style="cursor: pointer;color:#990000;"><?php echo $quote['text']; ?></label></td>
            <td></td>
            <td></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td colspan="3"><div class="error"><?php echo $shipping_method['error']; ?></div></td>
          </tr>
          <?php } ?>
          <?php } ?>
        </table>
             </div>  
        <?
	  

	  ?>

      <?php } ?>
       <?php if ($coupon_status) { ?>
		<h1><?php echo $coupon_title; ?></h1>
		<p><?php echo $coupon_text; ?></p>  
		<div class="content round">
            <input type=hidden name="comment" rows="2" style="width: 99%;" /><?php echo $comment; ?>

	        <table width="100%" cellpadding="3" cellspacing="2">
	        	<tr>
	        		<td valign="middle"  style="font-size:11px;font-weight:bold; text-transform:uppercase" width="200"><?php echo $text_coupon; ?></td>
	        		<td style="color:#5c936a" valign="top">
	        			<!--?php echo $entry_coupon; ?-->
	        			<?php if(@empty($valueCoupon)){?>
	        				<input type="text" name="coupon" value="<?php echo $coupon; ?>" style="vertical-align:middle" />&nbsp;
	         				<a onclick="$('#shipping').submit();" class="button"><span><?php echo $button_coupon; ?></span></a>
	         			<?php }else{ ?>
	         				<input type="hidden" name="coupon" value="<?php echo $coupon; ?>" />
	         				<span style='color:#666;'>Cupom: </span><b><?php echo $coupon." </b><br /><span style='color:#666;'>Valor:</span> <b> ".$valueCoupon; ?></b>
	         			<?php } ?>
		    		</td>
		    	</tr>
		    </table>
		</div>

      <?php 
	   }
      foreach ($totals as $total) {   
	      if($total['title'] == "Total:")
	      {
      		$valorCompra = $total['value'];
      		$valorCompraTexto = $total['text']; 
		  }
	  }  
	  ?>
	  
    
      <h1><?php echo $text_payment; ?></h1>
                <table class="iconCard">
                	<tr>
                    	<td>Cartões de Crédito</td>
                        <!--td style="width:200px">Boleto Bancário</td>
                        <td>Transferência Online</td-->
                    </tr>
                	<tr>
                        <td><a class="visa selected" onclick=esconde('visa'); id="bx38"></a><a class="master" onclick=esconde('master'); id="bx41"></a>
                        <a class="amex" onclick=esconde('amex'); id="bx28" style="display:none"></a></td>
                        <!--td style="width:200px"><a class="boleto" onclick=esconde('boleto'); id="bx15"></a></td>
<td><a class="itau" onclick=esconde('itau'); id="bx13"></a><a class="bb" onclick=esconde('bb'); id="bx9" ></a><a class="bradesco" onclick=esconde('bf'); id="bx3"></a><a class="bradescoTransf" onclick=esconde('bt'); id="bx4"></a></td-->
                    </tr>                    
                </table>
      

      <!--p><?php echo $text_shipping_methods; ?></p-->     
      <div class="content round">
      <?
      
      $ix = 0;
      
      foreach($formasPagamento as $key=>$value)
	  {

	  	  if($payment_id == $key)
	  	  {
		  $styleDisplay = 'block';
?>
	  	  <input type="hidden" id="formaPagamento" name="formaPagamento" value="<?=$key?>">    
<?
		  }
		  else 
	  	  {
	  	  	$styleDisplay = 'none';
		  }

	  	  print "<input type=hidden name='tipo".$key."' value='".$formasPagamento[$key]['tipo']."'>"; 
	  	  
		  if($formasPagamento[$key]['tipo'] == "cartao")
		  {

	      for($i = 2; $i<=$formasPagamento[$key]['numeroParcela']; $i++){
			  $valorParcela = ($valorCompra/$i);
			  if($valorParcela >= $formasPagamento[$key]['parcelaMinima'])
				$parcela[$i] = $valorParcela;
		  }
			
	  ?>
        
        <table width="100%" cellpadding="3" border="0" id="x<?=$key?>" style="display:<?=$styleDisplay?>" class="boxPagamento">
			<tbody>
			<tr>
	 			<td width="28%" align="right"> <?php echo $card_number; ?>:</td>
				<td width="38%"><input type="text" tabindex="1" class="card" value="" name="numberCard<?=$key?>" id="numberCard<?=$key?>"></td>
				<td width="34%" valign="top" style="line-height: 21px;" rowspan="4">
					<h3><?php echo $card_vista; ?></h3>
					<label id="parcel">
					<input type="radio" tabindex="6" checked="checked" value="1" style="background: none repeat scroll 0% 0% rgb(246, 246, 246);" class="radioButton" id="parcel<?=$key?>" name="parcel<?=$key?>"> à vista <?=$valorCompraTexto?><br>
					<?php
					if(isset($parcela)){
                        ?>
                        <h3 style="padding-top:15px"><?php echo $card_parcel; ?></h3></label>
					    <?php
                        foreach($parcela as $keyx => $valuex){ 
					    ?>
					    <label id="parcel">
					    <input name="parcel<?=$key?>" id="parcel<?=$keyx?>" type="radio"  class="radioButton"  style="background:#f6f6f6" value="<?=$keyx?>" /> <?=$keyx?> x de R$<?php echo number_format($valuex,2,",",".");?>   <br />
					    <?php
					    }
                    }
                    unset($parcela);
					?></label></td>
			</tr>
            <tr>
            	<td align="right">* Nome do TITULAR impresso no Cartão:</td>
                <td><input type="text" id="nome<?=$key?>" name="nome<?=$key?>" size="30" /></td>
            </tr>
			<tr>
				<td align="right"><?php echo $card_valid; ?>:</td>
				<td>
					<select tabindex="3" name="monthCard<?=$key?>" id="monthCard<?=$key?>">
						<option>01</option>
						<option>02</option>
						<option>03</option>
						<option>04</option>
						<option>05</option>
						<option>06</option>
						<option>07</option>
						<option>08</option>
						<option>09</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
					</select>
					<select tabindex="4" style="margin-left: 4px;" name="yearCard<?=$key?>" id="yearCard<?=$key?>">
						<option value="2011">2011</option>
						<option value="2012">2012</option>
						<option value="2013">2013</option>
						<option value="2014">2014</option>
						<option value="2015">2015</option>
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right"><?php echo $card_security; ?>:</td>
				<td>
					<input type="text" tabindex="5" style="width: 40px;vertical-align:middle" value="" class="securityCode" name="securityCode<?=$key?>" id="securityCode<?=$key?>">
					<span class="formInfo"><a id="one" class="tooltip">? <span> <img src="catalog/view/theme/<?=TEMPLATE?>/image/card01.jpg" /></span></a></span>       
				</td>
			</tr>
		</tbody>
 		</table>
 		
 		<?
	  	}
	  	else
	  	{
	  		?>
	  <table width="100%" cellpadding="3" border="0" id="x<?=$key?>" style="display:<?=$styleDisplay?>;">
			<tbody>
			<tr>
	 			<td width="28%" align="left"> <?=nl2br($formasPagamento[$key]['texto'])?></td>
			</tr>
		</tbody>
 		</table>
 		<?
		}
	  }
 		
 		?>
 		
      </div>
    
          <h1><?php echo $carrinho_title; ?></h1>
      <p><?php echo $carrinho_text; ?></p>
        <div class="content round">
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr class="barraTitulo">
          <th align="left"></th>      
          <th align="left"><?php echo $column_product; ?></th>
          <th align="center"><?php echo $column_model; ?></th>
          <th align="center"><?php echo $column_quantity; ?></th>
          <th align="left"><?php echo $column_price; ?></th>
          <th align="right"><?php echo $column_total; ?></th>
        </tr>
        <?php foreach ($products as $product) { ?>
        <tr class="listaProdutos">
        <td><img src=<?=$product['image']?>></td>
          <td align="left" valign="top"><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" style="color:#666"><?php echo $product['name']; ?></a>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            &nbsp;<small> - <?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
            <?php } ?></td>
          <td align="center" valign="top"><?php echo $product['model']; ?></td>
          <td align="center" valign="top"><?php echo $product['quantity']; ?></td>
          <td align="left" valign="top"><?php echo $product['price']; ?></td>
          <td align="right" valign="top"><?php echo $product['total']; ?></td>
        </tr>
        <?php } ?>
      </table>
      <br />
      <div style="width: 100%; display: inline-block;">
        <table style="float: right; display: inline-block;">       
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td align="right"><b><?php echo $total['title']; ?></b></td>
            <td align="right"><span style="color:#2f2f2f"><?php echo $total['text']; ?></span></td>
          </tr>
          <?php } ?>
        </table>
        <br />
      </div>
    </div>
    

      <!-- COMENTÃ?RIO -->
      <!--h1><?php echo $text_comments; ?></h1>
      <div class="content round"-->
        <input type=hidden name="comment" rows="2" style="width: 99%;"><?php echo $comment; ?>
      <!--/div--> 
      
      <div class="buttons">
        <table width="100%" cellpadding="0" cellpadding="0" border="0">
        <?php if ($text_agree) { ?>
          <tr  height="30">
            <td align="left"><!--a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a--></td>
            <td align="right" ><?php echo $text_agree; ?></td>
            <td width="5" style="padding-left:6px"><?php if ($agree) { ?>
              <input type="checkbox" name="agree" value="1" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="agree" value="1" />
              <?php } ?></td>
    	  </tr>
    	  <?
		   }
		   ?>
          <tr>
            <td align="left"><a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
            <td align="right"><a onclick="processaCompra();" class="buttonFin"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>             
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
</form>
<?php echo $footer; ?> 
<? print "aqui".count($shipping_methods).$frete_unico;?>
<script>
function processaCompra()
{
	
	<?
	if ($text_agree) {
	?>
	if(document.getElementById('shipping').agree.checked == false)
	{
		alert('<?=$text_agree_erro?>');
		return false;
	}
	
	<?
	}
	?>

	
	var id = document.getElementById('formaPagamento').value;

	//var shipping = 'shipping';
	//var shipping_method = 'shipping_method';
	
	<?
	
	if($frete_unico != 0 and count($shipping_methods) > 0){
	?>
	
	var send_to_checked = 0;
	
	alert(document.getElementById('shipping').shipping_method.length);
	
	for(i=0; i<document.getElementById('shipping').shipping_method.length; i++){
    if(document.getElementById('shipping').shipping_method[i].checked){
        send_to_checked = document.getElementById('shipping').shipping_method[i].value;
        }
    }
	if(send_to_checked == 0)
	{
	alert('<?=$text_shipping_erro?>');
	return false;
	}
	
	<?
	}
	?>
	
	if(id == 27 || id == 28 || id == 32 || id == 41 || id == 38)
	{		
		if(document.getElementById('numberCard'+id).value.length < 16)
		{
			alert('<?=$text_numberCard?>');
			document.getElementById('numberCard'+id).focus();
			return false;
		}
		
		if(document.getElementById('nome'+id).value.length < 5)
		{
			alert('<?=$text_nome?>');
			document.getElementById('nome'+id).focus();
			return false;
		}
		
		if(document.getElementById('securityCode'+id).value.length < 2)
		{
			alert('<?=$text_securityCode?>');
			document.getElementById('securityCode'+id).focus();
			return false;
		}
	}


	$.ajax({ 
	            type: 'GET',
	            url: 'index.php?route=checkout/confirm/confirm',
	            success: function(data) {
	            if(data == "OK")
	            {
	                document.forms.shipping.action="index.php?route=checkout/confirm";
	                $('#shipping').submit();
	                  
	            }
	            else
	            {
	                alert('Algum produto do seu carrinho não se encontra mais disponivel para venda, você será redirecionado ao carrinho para poder verificar quais são esses produtos.');
	            }
	            
	            }        
	        });
	    
}

function esconde(forma)
{
	var id = "";
      	  
	switch(forma)
	{
	  case "visa":
	    id = 38;
	  break;   		  
	  case "master":
	    id = 41;
	  break;

	}
	
var arrayTp = new Array();
<?
$i = 0;
foreach($formasPagamento as $key=>$value)
{
	$i = $i +1;
	?>         
	arrayTp[<?=$i?>] = 'x<?=$key?>';
<?	
}
?>

var novaClasse = '';

for(i=1; i<arrayTp.length; i++) {
	if(arrayTp[i] == 'x'+id)
	{
		document.getElementById('x'+id).style.display = 'block'; 
		var novaClasse = document.getElementById('bx'+id).className;
		var novaClasse = novaClasse.replace('selected','');
		//document.getElementById('bx'+id).setAttribute("class", novaClasse+' selected');
		document.getElementById('bx'+id).className = novaClasse+' selected';
		document.getElementById('formaPagamento').value = id;
	}
	else
	{
		document.getElementById(arrayTp[i]).style.display='none';
		if(document.getElementById('b'+arrayTp[i]))
		{
			var novaClasse = document.getElementById('b'+arrayTp[i]).className;
			var novaClasse = novaClasse.replace('selected','');
			document.getElementById('b'+arrayTp[i]).className = novaClasse;
		}
		else
		alert('b'+arrayTp[i]);
	}
}

}

<?

if(isset($payment_id))
{
	
	$id = "";
	
	switch($payment_id)
	{
  
		
	  case "38":
	    $id = "visa";
	  break;
   
	  case "41": 
	    $id = "master";
	  break;
   
	}
?>
esconde('<?=$id?>');
<?
}
?>
</script>

<div id="QuickViewX"></div>

<script type="text/javascript" src="catalog/view/javascript/jquery.maskedinput-1.2.2.js"></script>
