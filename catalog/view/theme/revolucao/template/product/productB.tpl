
        <?php echo $header; ?>   
        
        <script>
        
        function get_facebook_friends(){
			$.ajax({
				type: 'GET',
				url: 'index.php?route=account/facebook',
				dataType: 'html',
				data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
				beforeSend: function(){
					$('#add_to_wl').after('<div class="wait"><img src="catalog/view/theme/default/image/loading_1.gif" alt="" /></div>');
				},
				complete: function() {
					$('.wait').remove();
				},
				success: function(data) {
					$('#add_to_wl').after('' + data + '');
				}
			});
		}
		
		</script>
 

<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px" />
  <?php echo $column_right; ?>       
 <?           
 if($zoom == 1)
 {
 ?> 
<script type='text/javascript' src='catalog/view/javascript/jquery/jqzoom/jqzoom.pack.1.0.1.js'></script>
<script type='text/javascript' src='catalog/view/javascript/jquery/jquery.ui.js'></script>        

<script type='text/javascript' src='catalog/view/javascript/product.js'></script>  
<script type="text/javascript">
<!--
$(document).ready(function() {   

 var options5 =
            {
                zoomWidth: 580,
                zoomHeight: 350,
                showEffect:'show',
                position : 'right',
                hideEffect:'fadeout',
                fadeoutSpeed: 'slow',
                title :false
            }
            $(".jqzoom5").jqzoom(options5);
            
          
});

function alterPicture(picture,thumb)
{
    document.getElementById('bigPicute').innerHTML = '<a name="demo5" style="outline-style: none; cursor: crosshair;margin:0;display: block;" class="jqzoom5" href="'+picture+'" title=""><img src="'+thumb+'"></a>';
    
    $(document).ready(function() {   

     var options5 =
            {
                zoomWidth: 580,
                zoomHeight: 350,
                showEffect:'show',
                position : 'right',
                hideEffect:'fadeout',
                fadeoutSpeed: 'slow',
                title :false
            }
    
    $(".jqzoom5").jqzoom(options5);
    
    });   
    
}



//-->
 	</script>
 	<link rel="stylesheet" type="text/css" href="catalog/view/javascript/facebook/face.css" />
 	<?
 	}
 	?>


<div id="content" class="product">
  <div class="middle">
   	<div style="width: 100%; margin-bottom: 10px;">
    	<div style="width:40%;float:left;min-height:350px">
   	  		<div id="demo">
   	  		
				<div id="bigPicute" style="position:relative; margin:0 auto" >
				
				<a href='<?php echo $popup; ?>' class="jqzoom5" style="margin:0;" >
				
				<img src="<?php echo $thumb; ?>" title="<?php echo $heading_title ?>" alt='<?php echo $heading_title ?>'  /></a>
		  		
				</div>      
       			   <?
        			  if(count($images) >= 1)
             	      {
           	      ?>
        		<div class="thumbnails">
        			<ul>
					  <li><a href="javascript:alterPicture('<?php echo $popup; ?>','<?php echo $thumb; ?>');">
             	      <img src="<?php echo $thumb_tiny; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>"/></a></li>
             	      <?php foreach ($images as $image) { ?>
					  <li><a href="javascript:alterPicture('<?php echo $image['popup']; ?>','<?php echo $image['thumb']; ?>');">
             	      <img src="<?php echo $image['thumb_tiny']; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>"/></a></li>
             	     <?php }
             	      ?>
                  </ul>
       	 		</div>
       	 		<?
       	 		}
       	 		?>
        	</div>
        </div>
        
        <div style="width:60%; float:right;">
        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
                <td colspan="4">
        	 <span class="Productname"><?php echo $heading_title; ?></span>
        	 <span class="modelCinza"><?php echo $model; ?></span>
        	 </td>
              </tr>

              <?php if ($display_price) { ?>
              <tr>
                
                <td class="linePrice"> 
                <?php if (!$special) { ?></b>
                
                 <b><?php echo $price; ?>
                  <?php } else { ?>
                  <span style="text-decoration: line-through;font-size:12px;color:#999"> de: <?php echo $price; ?></span> &nbsp;<b> por: <?php echo $special; ?>
                  <?php } ?></b></td>
                  
                   <?php if ($review_status) { ?>
			 
                <td align="right" style="font-size:11px;color:#333" valign="top"><?php echo $text_average; ?> </td>
                <td align="left" width="135" valign="top">&nbsp; <?php if ($average) { ?>
                  <img src="catalog/view/theme/<?=TEMPLATE?>/image/stars_<?php echo $average . '.png'; ?>" alt="<?php echo $text_stars; ?>" /><BR>
                   <a onclick="javascript:window.location.hash='tab_review'"  style="font-size:11px;color:#666"><?php echo $text_rate_too; ?></a>
                  <?php } else { ?>
                 <a onclick="javascript:window.location.hash='tab_review'"  style="font-size:11px;color:#666"><?php echo $text_no_rating; ?></a>
                  <?php } ?></td>
           
			  <?php } ?>
			  
			  
             
              <?php } ?>
              
   
              <?php if ($manufacturer_logo) { ?>
			<tr>
			                <td width="110"><?php echo $text_manufacturer; ?>:</td>
				<td><a href="<?php echo str_replace('&', '&amp;', $manufacturers); ?>" style="color: #5C936A;"><img src="<?php echo $manufacturer_logo; ?>"></td>
				<td></td>
			</tr>
			<?php }
			elseif ($manufacturer) { ?>
              <tr>
                <td width="110"><?php echo $text_manufacturer; ?>:</td>
                <td><a href="<?php echo str_replace('&', '&amp;', $manufacturers); ?>" style="color: #5C936A;"><?php echo $manufacturer; ?></a></td>
                <td></td>
                <td></td>
              </tr>
              <?php } ?>
             
            </table>
            <br />
            <?php if ($display_price) { ?>
            <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="product">
            
                          <div>
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                <input type="hidden" name="redirect" value="<?php echo str_replace('&', '&amp;', $redirect); ?>" />                
              </div> 
            
              <?php if ($options) { ?>
              <b><?php echo $text_options; ?></b><br />   
              <div style="background: #FFFFCC; border: 1px solid #FFCC33; padding: 10px; margin-top: 2px; margin-bottom: 15px;" class="content">
                
                  <?php foreach ($options as $option) { ?>
                  <?php echo $option['name']; ?>:<br />     
                  <? $opt = $option['option_id']; ?>
                      <select name="option[<?php echo $option['option_id']; ?>]" onchange="mostraEsconde(this.value);">
                        <?php foreach ($option['option_value'] as $option_value) { ?>
                        <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?>
                        <?php if ($option_value['price']) { ?>
                        <?php echo $option_value['prefix']; ?><?php echo $option_value['price']; ?>
                        <?php } ?>
                        </option>
                        <?php } ?>
                      </select>                  <?php } ?>
              
              </div>
              <?php } ?>
              <?php if ($display_price) { ?>
              <?php if ($discounts) { ?>
              <b><?php echo $text_discount; ?></b><br />
              <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-top: 2px; margin-bottom: 15px;">
                <table style="width: 100%;">
                  <tr>
                    <td style="text-align: right;"><b><?php echo $text_order_quantity; ?></b></td>
                    <td style="text-align: right;"><b><?php echo $text_price_per_item; ?></b></td>
                  </tr>
                  <?php foreach ($discounts as $discount) { ?>
                  <tr>
                    <td style="text-align: right;"><?php echo $discount['quantity']; ?></td>
                    <td style="text-align: right;"><?php echo $discount['price']; ?></td>
                  </tr>
                  <?php } ?>
                </table>
              </div>
              <?php } ?>
              <?php } ?>    
             
                                <?
                if(count($options) == 0)
                {  
                ?>       
              <div class="content">
              	<div class="qtd">
                 <?  
                if(trim($stock) == "In Stock" or trim($stock) == "Disponível" or trim($stock) == "Dispon�vel"  or $stock > 0 or $estoqueReal > 0)
                {
                ?>
                 <?php echo $text_qty; ?>
                <select name="quantity" style="vertical-align: middle;">
                
            <?       
            $qtNum = 1;
            
            $stock = $estoqueReal;
            
            if($stock > 10)
            $stock = 10;
            
            while ($qtNum <= $stock):
                                
            print '<option value="'.$qtNum.'">'.$qtNum.'</option>';  
            
                $qtNum++;
                
            endwhile;
          ?>
                
                </select>
                </div>
                <div class="links-add">
                <a onclick="$('#product').submit();" id="add_to_cart" class="button cartspecial"><span><?php echo $button_add_to_cart; ?></span></a>
                
                 <a href="javascript:add_wishlist('<?php echo $product_id; ?>');" id="add_to_wl" class="button wishlist"><span><?php echo $button_add_to_mywishlist; ?></span></a>            
			     </div>
                
		
		
                <?php 
                }
                else
                {
                
                ?>
                Seu email: <input type="text" name="email" id="email" style="background:#FFFEB7;">
                <a class="button"><span onclick="javascript:avise();">Avise-me quando disponivel.</span></a>
                
                <?php 
                }
                
                }
                else
                {
                
                ?>
                <input id="variacao"  name="variacao" type="hidden">
                <?
                 
                 $variacoes = array();
                 
					foreach($options as $option)
					{
						foreach($option['option_value'] as $opcoes)
						{
							$variacoes[$opcoes['option_value_id']] = array('quantity' =>  $opcoes['quantity'], 'id' => $opcoes['option_value_id']);
						}
					}
					
					$x = 0;
					
					foreach($variacoes as $variations)
					{
					
					$x = $x+1;
					
					if($x == 1)
					{
					$display = "block";
					}
					else
					{
					$display = "none";
					}
					
     				?>
               			
               		<div class="content" id ="<?=$variations['id']?>" style="display:<?=$display?>">
		              
		               <?
		                if($variations['quantity'] > 0)
		                {
			               echo $text_qty; 
			               ?>
			               <select name="quantity<?=$variations['id']?>">
			               <?       
					        $qtNum = 1;
					        
					        if($variations['quantity'] > 10)
					        $variations['quantity'] = 10;
					        
   					        while ($qtNum <= $variations['quantity']):
						        print '<option value="'.$qtNum.'">'.$qtNum.'</option>';  
						        $qtNum++;
						    endwhile;
							?>
				            </select>
				            <a onclick="compra('<?=$variations['id']?>')"; id="add_to_cartx" class="button"><span><?php echo $button_add_to_cart; ?></span></a>
				            <a href="javascript:add_wishlist('<?php echo $product_id; ?>');" id="add_to_wl" class="button"><span><?php echo $button_add_to_mywishlist; ?></span></a>            
			            <? 
			            }
			            else
			            {
			            ?>
				            Seu email: <input type="text" name="email" id="email<?=$variations['id']?>">
				            <a class="button"><span onclick="javascript:avise(<?=$variations['id']?>);">Avise-me quando disponivel.</span></a>
			            <? 
			            }
			            
			            print "</div>";
			            	
               		}
               	  }	     
?>
              

                <?php if ($minimum > 1) { ?><br/><small><?php echo $text_minimum; ?></small><?php } ?>
              </div>
            </form>
            <?php } 
            
            if(strlen($description))
            {
            ?>          
            <div id="descricao">
              <span class="descriType"><?php echo $tab_description; ?></span><hr />
      <!--a tab="#tab_image"><?php echo $tab_image; ?>  (<?php echo count($images); ?>)</a-->
      <?php echo $description; ?>
			</div>
			<?
			}
			?>
			
			</div>
			
			<?
			$link = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id='.$this->request->get['product_id']);
			?>
			
			<div class="bookmarks">
<div style="padding-top:5px"></div>



<?
if($config_face_comm_app){
	
	?>
	<script>
	function openFace(){
		window.open("https://www.facebook.com/dialog/oauth?client_id=182679918453386&redirect_uri=<?=HTTP_SERVER?>account/facebook/&scope=email,read_stream,status_update,publish_stream","mywindow","menubar=0,resizable=0,width=1000,height=600");
	}
	</script>
	<?
	if(!isset($_SESSION['amigos']))
	{
	print "<a href=\"javascript:openFace();\"><span style=\"color:#3d5a95;display: block;margin-bottom: 5px;\"><strong>Compartilhe com seus amigos:</strong></span></a>";
	}
	else
	{
?>	
<span style="color:#3d5a95;display: block;margin-bottom: 5px;"><strong>Compartilhe com seus amigos:</strong></span>

		<script src="catalog/view/javascript/facebook/GrowingInput.js" type="text/javascript" charset="utf-8"></script>
		<script src="catalog/view/javascript/facebook/TextboxList.js" type="text/javascript" charset="utf-8"></script>		
		<script src="catalog/view/javascript/facebook/TextboxList.Autocomplete.js" type="text/javascript" charset="utf-8"></script>

			<script type="text/javascript" charset="utf-8">		
			$(function(){
				// Standard initialization
			
				// Autocomplete with poll the server as you type
				var t5 = new $.TextboxList('#form_tags_input_4', {unique: true, plugins: {autocomplete: {
					minLength: 2,
					queryRemote: true,
					remote: {url: 'http://www.lojavilla.com.br/loja/account/autocomplete/'}
				}}});
				 //t5.add('Digite o nome de seus amigos e...');				
			});
		</script>
	
<div class="form_friends"><input type="text" name="test4" value="" id="form_tags_input_4"/>
<img src="catalog/view/theme/bongspipes/image/share_face.gif" onclick="javascript:compartilhaFace();" /></div>    
<?
}
?>	
<script src="http://connect.facebook.net/pt_BR/all.js#appId=211305652244952&xfbml=1">
</script>
<?
$proto = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL'])); //pegando s� o que for letra
$location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<span style="color:#3d5a95;margin-top:40px;display:inline-block"><strong>Comentar produto:</strong></span>
<div id="fb-root"></div>
<fb:comments href="<?=$location?>" num_posts="3" width="576" allowTransparency="true" frameborder="0" scrolling="no" style="float: right;margin: 5px 0 0;">
</fb:comments>		
<?
}
?>

	<div> 

            
		
	</div>
</div>

        </div><a name="tab_review"></a>
    </div>
    
    <div class="tabs">
          <?php if ($review_status) { ?><a tab="#tab_review" ><?php echo $tab_review; ?></a><?php } ?>
          
          <?php if($products){?><a tab="#tab_related"><?php echo $tab_related; ?> (<?php echo count($products); ?>)</a><?php } ?>
    </div>

    <?php if ($review_status) { ?>
    <script type="text/javascript"><!--
	$.tabs('.tabs a',"#tab_review");
	//--></script>
    <div id="tab_review" class="tab_page">
      <div id="review"></div>
      
      <div class="heading" id="review_title"><?php //echo $text_write; 
      ?>
      </div>
      <div class="content round"><b><?php echo $entry_name; ?></b><br />
        <input type="text" name="name" value="" />
        <br />
        <br />
        <b><?php echo $entry_review; ?></b>
        <textarea name="text" style="width: 98%;" rows="8"></textarea>
        <span style="font-size: 11px;"><?php //echo $text_note; ?></span><br />
        <br />
        <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
        <input type="radio" name="rating" value="1" style="margin: 0;" />
        &nbsp;
        <input type="radio" name="rating" value="2" style="margin: 0;" />
        &nbsp;
        <input type="radio" name="rating" value="3" style="margin: 0;" />
        &nbsp;
        <input type="radio" name="rating" value="4" style="margin: 0;" />
        &nbsp;
        <input type="radio" name="rating" value="5" style="margin: 0;" />
        &nbsp; <span><?php echo $entry_good; ?></span><br />
        <br />
        <b><?php echo $entry_captcha; ?></b><br />
        <input type="text" name="captcha" value="" autocomplete="off" />
        <br />
        <img src="index.php?route=product/product/captcha" id="captcha" /></div>
      <div style="text-align:right"><a onclick="review();" class="button"><span><?php echo $button_comment; ?></span></a></div>
    </div>
    <?php } ?>
    <!--div id="tab_image" class="tab_page">
      <?php if ($images) { ?>
      <div style="display: inline-block;">
        <?php foreach ($images as $image) { ?>
        <div style="display: inline-block; float: left; text-align: center; margin-left: 5px; margin-right: 5px; margin-bottom: 10px;"><a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="thickbox" rel="gallery"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" style="border: 1px solid #DDDDDD; margin-bottom: 3px;" /></a><br />
          <span style="font-size: 11px;"><?php echo $text_enlarge; ?></span></div>
        <?php } ?>
      </div>
      <?php } else { ?>
      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;"><?php echo $text_no_images; ?></div>
      <?php } ?>
    </div-->         
    <?php if ($products) { ?>
    <script type="text/javascript"><!--
	$.tabs('.tabs a',"#tab_related");
	//--></script>
    <div id="tab_related" class="tab_page">

      
      <table class="list">
      <?php for ($i = 0; $i < sizeof($products); $i = $i + 4) { ?>
      <tr>
        <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
        <td width="25%"><?php if (isset($products[$j])) { ?>
          <a href="<?php echo $products[$j]['href']; ?>"><img src="<?php echo $products[$j]['thumb']; ?>" title="<?php echo $products[$j]['name']; ?>" alt="<?php echo $products[$j]['name']; ?>" /></a>
          
          <div><a href="<?php echo $products[$j]['href']; ?>" class="nomeProduto"><?php echo $products[$j]['name']; ?></a></div>
          <?php if ($products[$j]['rating']) { ?>
          <img src="catalog/view/theme/<?=TEMPLATE?>/image/stars_<?php echo $products[$j]['rating'] . '.png'; ?>" alt="<?php echo $products[$j]['stars']; ?>" />
          <?php } ?>
          
          <!-- div style="color: #999; font-size: 11px;"><?php echo $products[$j]['model']; ?></div-->
          <?php if ($display_price) { ?>
          <?php if (!$products[$j]['special']) { ?>

          <div><span class="apenas">Apenas:</span> <span class="precoProduto"><?php echo $products[$j]['price']; ?></span></div>
          <?php } else { ?>
          
          <div style="color:#858585"><span class="apenas">De:</span> <span style="text-decoration: line-through;"><?php echo $products[$j]['price']; ?></span></div> 
          <div><span class="apenas">Por apenas:</span> <span  class="precoProduto"><?php echo $products[$j]['special']; ?></span></div>
          <?php } ?>
		  <a id="details<?php echo $products[$j]['product_id'];?>" href="javascript:quickView(<?php echo $products[$j]['product_id'];?>,$('#details<?php echo $products[$j]['product_id'];?>'));javascript:dimOn();" style="text-transform:uppercase;color:#858585;font-size:10px"  class="button_add_small">&nbsp;</a>
          
          <?php } ?>
          
          <?php } ?></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </table>       
    </div> 
      <?php 
      }
      ?>

  </div>
  <?php if ($tags) { ?>
  <div class="tags"><?php echo $text_tags; ?>
  <?php foreach ($tags as $tag) { ?>
  <a href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?></a>, 
  <?php } ?>
  </div>
  <?php } ?>
</div>     
<script type="text/javascript"><!--

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

function add_wishlist(id){
			$.ajax({
				type: 'POST',
				url: 'index.php?route=account/mywishlist&action=add&id='+id,
				dataType: 'html',
				data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
				beforeSend: function(){
					$('.success').remove();
					$('.warning').remove();
					$('#add_to_wl').after('<div class="wait"><img src="catalog/view/theme/default/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
				},
				complete: function() {
					$('.wait').remove();
				},
				success: function(data) {
					$('#add_to_wl').after('' + data + '');
				}
			});
		}
		
function compartilhaFace(){
	$.ajax({
		type: 'POST',
		url: 'index.php?route=account/facebook/compartilha&action=compartilha&',
		dataType: 'html',
		data: 'name=' + encodeURIComponent($('input[name=\'test4\']').val()),
		beforeSend: function(){
			$('.success').remove();
			$('.warning').remove();
			$('#add_to_wl').after('<div class="wait"><img src="catalog/view/theme/default/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(data) {
			$('#add_to_wl').after('' + data + '');
		}
	});
}

function review() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#review_button').attr('disabled', 'disabled');
			$('#review_title').after('<div class="wait"><img src="catalog/view/theme/<?=TEMPLATE?>/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#review_button').attr('disabled', '');
			$('.wait').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#review_title').after('<div class="warning">' + data.error + '</div>');
			}
			
			if (data.success) {
				$('#review_title').after('<div class="success">' + data.success + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
}


function avise(variacao) { 
    
	er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;

	if(!er.exec(document.getElementById('email'+variacao).value)){
    alert('Por favor, insira um email válido');
	}
	else
	{
	$.post('index.php?route=product/product/avise&product_id=<?php echo $product_id;?>', { email: document.getElementById('email'+variacao).value, product_id: "<?php echo $product_id;?>", variacao : variacao },
    function(data){
    alert("Obrigado, você será avisado assim que o produto estiver disponível.");
		   });
	}
}


<?
if(isset($variacoes))
{
?>
function mostraEsconde(id)
{
	
arrayTp = new Array();


	<?
	
	$i = 0;
	
	foreach($variacoes as $variations)
	{
	$i = $i+1;
	?>
	arrayTp[<?=$i?>] = '<?=$variations['id']?>';
	<?
	}
	?>
	
   for(i=1; i<arrayTp.length; i++) {
	if(arrayTp[i] == id)
	{
		document.getElementById(id).style.display = 'block';   
	}
	else
	{
		document.getElementById(arrayTp[i]).style.display='none';
	}
	
}

}
<?
}
?>

function compra(id)
{
	$('#variacao').val(id);
	$('#product').submit(); 
}

//--></script>

<?php echo $footer; ?> 
