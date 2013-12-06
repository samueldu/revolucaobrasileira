<?php echo $header; ?>
<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px" />
<div id="content carrinho">
  <div class="middle account">
      <h1><?php echo $heading_title; ?></h1>
  
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
  <div style="width:100%;display:block;top:50%;"> 
  <?
  if($idPagamento == "ipagare_web")
  {
  ?>
     <p align="center"><img alt="Seu Pagamento está sendo processado..." src="catalog/view/theme/<?=TEMPLATE?>/image/cadeado.jpg" align="center"></p>
    <p align="center" style="font-size:18px;margin-top:10px;display:block">Seu Pagamento está sendo processado...</p>
    </div>
    <?
  }
  ?>
    <div class="content round" style="display: none;">
      <table width="100%">
        <tr>
          <td width="33.3%" valign="top"><?php if ($shipping_method) { ?>
            <b><?php echo $text_shipping_method; ?></b><br />
            <?php echo $shipping_method; ?><br />
            <a href="<?php echo str_replace('&', '&amp;', $checkout_shipping); ?>"><?php echo $text_change; ?></a><br />
            <br />
            <?php } ?>
            <!--b><?php echo $text_payment_method; ?></b><br />
            <?php echo $payment_method; ?><br />
            <a href="<?php echo str_replace('&', '&amp;', $checkout_payment); ?>"><?php echo $text_change; ?></a--></td>
          <td width="33.3%" valign="top"><?php if ($shipping_address) { ?>
            <b><?php echo $text_shipping_address; ?></b><br />
            <?php echo $shipping_address; ?><br />
            <a href="<?php echo str_replace('&', '&amp;', $checkout_shipping_address); ?>"><?php echo $text_change; ?></a>
            <?php } ?></td>
          <td width="33.3%" valign="top"><!--b><?php echo $text_payment_address; ?></b><br />
            <?php echo $payment_address; ?><br />
            <a href="<?php echo str_replace('&', '&amp;', $checkout_payment_address); ?>"><?php echo $text_change; ?></a--></td>
        </tr>
      </table>
    </div>
    <div class="content round" style="display: none;">
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr class="barraTitulo">
          <th align="left"><?php echo $column_product; ?></th>
          <th align="left"><?php echo $column_model; ?></th>
          <th align="right"><?php echo $column_quantity; ?></th>
          <th align="right"><?php echo $column_price; ?></th>
          <th align="right"><?php echo $column_total; ?></th>
        </tr>
        <?php foreach ($products as $product) { ?>
        <tr class="listaProdutos">
          <td align="left" valign="top"><b><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" style="color:#666"><?php echo $product['name']; ?></a></b>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            &nbsp;<small> - <?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
            <?php } ?></td>
          <td align="left" valign="top"><?php echo $product['model']; ?></td>
          <td align="right" valign="top"><?php echo $product['quantity']; ?></td>
          <td align="right" valign="top"><?php echo $product['price']; ?></td>
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
            <td align="right"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
        </table>
        <br />
      </div>
    </div>
    <?php if ($coupon_status) { ?>
    <!--div class="content round">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="coupon">
        <p><?php echo $text_coupon; ?></p>
        <div style="text-align: right;"><?php echo $entry_coupon; ?>&nbsp;
        <input type="text" name="coupon" value="<?php echo $coupon; ?>" />
        &nbsp;<a onclick="$('#coupon').submit();" class="button"><span><?php echo $button_coupon; ?></span></a></div>
      </form>
    </div-->
    <?php } ?>
    <?php if ($comment) { ?>
    <b style="margin-bottom: 2px; display: block;"><?php echo $text_comment; ?></b>
    <div class="content"><?php echo $comment; ?></div>
    <?php } ?>
    <div id="payment"><?php echo $payment; ?></div>
    </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?>

<script>

window.onload= function(){
        DisableEnableLinks(true)
}

function DisableEnableLinks(xHow){
  objLinks = document.links;
  for(i=0;i<objLinks.length;i++){
    objLinks[i].disabled = xHow;
    //link with onclick
    if(objLinks[i].onclick && xHow){  
        objLinks[i].onclick = new Function("return false;" + objLinks[i].onclick.toString().getFuncBody());
    }
    //link without onclick
    else if(xHow){  
      objLinks[i].onclick = function(){return false;}
    }
    //remove return false with link without onclick
    else if(!xHow && objLinks[i].onclick.toString().indexOf("function(){return false;}") != -1){            
      objLinks[i].onclick = null;
    }
    //remove return false link with onclick
    else if(!xHow && objLinks[i].onclick.toString().indexOf("return false;") != -1){  
      strClick = objLinks[i].onclick.toString().getFuncBody().replace("return false;","")
      objLinks[i].onclick = new Function(strClick);
    }
  }
}

String.prototype.getFuncBody = function(){ 
  var str=this.toString(); 
  str=str.replace(/[^{]+{/,"");
  str=str.substring(0,str.length-1);   
  str = str.replace(/\n/gi,"");
  if(!str.match(/\(.*\)/gi))str += ")";
  return str; 
} 


var workIsDone = false;

window.onbeforeunload = confirmBrowseAway;

function confirmBrowseAway()
{
    return "Por favor, aguarde alguns segundos e n�o Recarregue a pagina ' " +
    "ou Volte. Caso acredite que tenha cometido algum erro, aguarde alguns segundos ate seu pedido ser finalizado e realize um novo pedido.";
  
  
  return false;
  
}
</script>