	<div id="module_cart" class="box">
 <a href="javascript:dimOff();" id="fechar" style="float:right"><img src="catalog/view/theme/<?=TEMPLATE?>/image/fecharQuick.png" alt="Fechar" title="Fechar" /></a>
  <div class="middle">
    <?php if ($products) { ?>
    <div id="cartScroll">
    <table cellpadding="2" cellspacing="0" style="width: 97%;" class="tableModule">
      <?php foreach ($products as $product) { ?>
      <tr>
        <td align="left" style="width:100px;">
        <a href="<?php echo $product['href']; ?>" class="image-holder"><img src="<?=$product['image']?>" style="float:left;margin:0 10px 0 0;"></a>  
    
       </td>
        <td align="left"> 
        <a href="<?php echo $product['href']; ?>" class="nomeProduto"><?php echo $product['name']; ?></a>
        </td>
        <td><span style="font-size:11px;margin-left:10px;display:inline; vertical-align: middle;">Qtd. <?php echo $product['quantity']; ?></span></td>
        <td><span class="cart_remove" id="remove_<?php echo $product['key']; ?>">&nbsp;</span></td>
        <td style="text-align:right"><span class="precoProduto"><?php echo $product['price']; ?></span>
          <div>
            <?php foreach ($product['option'] as $option) { ?>
            - <small style="color: #999;"><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
         
            <?php } ?>
          </div></td>
          <td style="text-align:right"><span class="precoProduto"><?php echo $product['sum_price']; ?></span></td>
      </tr>
     
      <?php } ?>
    </table>
    </div>
    <br />
    <?php if ($display_price) { ?>
	<table cellpadding="0" cellspacing="0" align="right" style="text-align:right;border-top:3px solid #ddd; padding:5px 0 10px 0" width="100%">
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td align="right"><span class="cart_module_total"><b><?php echo $total['title']; ?></b></span><span class="cart_module_total"><?php echo $total['text']; ?></span> </td>
      </tr>
      <?php } ?>
    </table>
	<?php } ?>
    <div style="text-align:right;clear:right;"><a href="javascript:dimOff();" id="fechar" class="buttonTiny"><span>Continuar Comprando</span></a>  <a href="<?php echo $checkout; ?>" class="buttonGreen"><span><?php echo $text_checkout; ?></span></a></div>
    <?php } else { ?>
    <div style="text-align: center;"><?php echo $text_empty; ?></div>
    <?php } ?>
  </div>
  
</div>
<?php if ($ajax) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajax_add.js"></script>
<?php } ?>

<script type="text/javascript">
<!--

jQuery.fn.center = function () {
    this.css("position","fixed");
    this.css("top", ( $(window).height() - this.height() ) / 3+$(window).scrollTop() + "px");
    this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
    return this;
}
$("#module_cart").center();


function getUrlParam(name) {
  var name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.href);
  if (results == null)
    return "";
  else
    return results[1];
}

$(document).ready(function () {
	$('.cart_remove').live('click', function () {
		if (!confirm('<?php echo $text_confirm; ?>')) {
			return false;
		}

		$(this).removeClass('cart_remove').addClass('cart_remove_loading');
		$.ajax({
			type: 'post',
			url: 'index.php?route=module/cart/callback',
			dataType: 'html',
			data: ({
					remove: $(this).attr("id"),
					opt_ajax: true
				}),
			success: function (html) {
				$('#module_cart .middle').html(html);
				if (getUrlParam('route').indexOf('checkout') != -1) {
					window.location.reload();
				}
			}
		
		});   
	});
	}); 

$(window).load(function() {

	$(".cartOver").click(function() {
		$("#module_cart").slideDown(500);
		$("#darkLayer").css("display","block");
	});

	$("#fechar").click(function(){
		$("#module_cart").css("display","none");
		$("#darkLayer").css("display","none");
	});

	$("#darkLayer").click(function(){
		$("#module_cart").css("display","none");
		$("#darkLayer").css("display","none");
	});
	
});

//-->
</script>