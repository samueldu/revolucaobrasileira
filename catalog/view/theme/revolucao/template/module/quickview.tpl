<script type="text/javascript">
function dimOff()
{
    document.getElementById("darkLayer").style.display = "none";
    document.getElementById("module_cart").style.display = "none";
    
}
function dimOn()
{
    document.getElementById("darkLayer").style.display = "";
}

</script>


<div id="QuickView" class="details round">
	<input type="hidden" name="product_id" id="product_id" value="" />
	<input type="hidden" value="http://192.168.1.3/opencart/index.php?route=product/product&amp;product_id=7" name="redirect" />
	<a href="javascript:dimOff();" id="fecharQuick" style="float:right"><img src="catalog/view/theme/<?=TEMPLATE?>/image/fecharQuick.png" alt="Fechar" title="Fechar" /></a>
	<div><a href="#" class="photo"></a></div>
	
	<div class="contentQuickView">
	<div class="nameProduct"> </div>
	<div class="stars"></div><br />
	<div class="description"></div>
    <div class="linkProduto"><a href="#" id="verDetails">VER MAIS DETALHES</a></div>

	<div class="special" style="color: #999; text-decoration: line-through; "></div>		
    <span style="color: #2f2f2f; display:block;margin:10px 0 0 0" id="price"></span><br />
	 
	<div class="options" style="float:left; width:100%; margin-bottom:10px"></div>
	
    <div id="box_quantity">
    <span style="font-size:10px">Qtd.</span> 
	<select name="quantity" id="quantity" style="vertical-align:middle;display:inline">
	<?php /* for($i=1;$i<11;$i++){ ?>
	<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	<?php }*/ ?>
	</select>
	</div>
	
    <div style="float:left"><a href="javascript:void(0);" id="addToCart" class="buttonTes button"><span>Adicionar ao carrinho</span></a></div>
	
    <span id="avise"></span>
	</div>
</div>

<script type="text/javascript">

jQuery.fn.center = function () {
    this.css("position","fixed");
    this.css("top", ( $(window).height() - this.height() ) / 3+$(window).scrollTop() + "px");
    this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
    return this;
}
$('#QuickView').center();
var quantity = 0;

function quickView(id,element){
	
	$.ajax({ 
		type: 'GET',
		url: 'index.php?route=module/quickview/getDetails',
		dataType: "json",
		data: ({product_id : id}),
		success: function(data) {
			$(".nameProduct").html(data.product_info.name);
			$(".photo").html("<img src="+data.product_info.image+">");
			$(".photo").attr('href',data.url_product);
			$(".description").html(data.product_info.description);
			$("#product_id").val(data.product_info.product_id);
			/*$("#redirect").val(data.redirect);*/
			//$("#product").attr("action", data.action);
			$(".options").html("");
			$("#price").html(data.product_info.price);
			$(".stars").html('Avaliação:'+data.average);
			$(".special").html(data.special);
			$("#verDetails").attr('href',data.url_product);

			quantity = data.product_info.quantity;
			$("#quantity").text("");
			
			if(quantity > 0){
				$("#box_quantity").css("float","left");
				$("#avise").css("display","none");
				for(i=0;i<quantity;i++){
					$("#quantity").append($("<option></option>").attr("value",i+1).text(i+1));
				}
			}else{
				$("#box_quantity").css("display","none");
				$("#avise").css("display","block");
				$("#avise").html('<input type="text" name="email" id="email" value="Seu e-mail" style="background:#FFFEB7;margin-right: 5px;"><a class="button"><span onclick="javascript:avise(null,\''+data.product_info.product_id+'\');">Avise-me quando disponivel.</span></a>');
			}
	
			if(data.options.length > 0){
				options = data.options;
				for(i=0; i<options.length; i++){
					text = options[i]['name']+":&nbsp;"
		                +"<select name='option["+options[i]['product_option_id']+"]' id='option["+options[i]['product_option_id']+"]'>";
		            for(x=0;x<options[i]['option_value'].length;x++){
		            	text += "<option value='"+options[i]['option_value'][x]['option_value_id']+"'>"+options[i]['option_value'][x]['name'];
		                if (options[i]['option_value'][x]['price']){
		                	text += options[i]['option_value'][x]['prefix']+ " " +options[i]['option_value'][x]['price'];
		                }
		                text += "</option>";
		             }
		             text += "</select>";
		             $(".options").append(text);
				}
			}
		}		
	});

	$("#QuickView").css("display","block");

}

$("#addToCart").click(function(){
	$.ajax({ 
		type: 'POST',
		url: 'index.php?route=module/cart/callback',
		dataType: "html",
		data: ({
				product_id : $("#product_id").val(),
				quantity: $("#quantity").val(),
				option: $("#option").val(),
				opt_ajax: true
			  }),
		success: function(data) {
			$("#module_cart .middle").html(data);
			$("#QuickView").css("display","none");
			$('#module_cart').slideDown(500);
		}
	});
});

$("#fecharQuick").click(function(){
	$("#QuickView").css("display","none");
	$("#darkLayer").css("display","none");
});

$("#darkLayer").click(function(){
	$("#QuickView").css("display","none");
	$("#darkLayer").css("display","none");
});

$(window).load(function() {
	$("#email").live('focus',function(){
		if($(this).val() == 'Seu e-mail'){
			$(this).val('');
		}
	});
	
	$("#email").live('blur',function(){
		if($(this).val() == ''){
			$(this).val('Seu e-mail');
		}
	});
});

function avise(variacao, v_product_id) { 

	er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;

	if(!er.exec(document.getElementById('email').value)){
    alert('Por favor, insira um email válido');
	}
	else
	{
	$.post('index.php?route=product/product/avise&product_id='+v_product_id, { email: document.getElementById('email').value, product_id: v_product_id, variacao : variacao },
    function(data){
    alert("Obrigado, você será avisado assim que o produto estiver disponível.");
		   });
	}
}
</script>