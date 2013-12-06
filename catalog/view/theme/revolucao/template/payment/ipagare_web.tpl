<script language="javascript">

image1 = new Image();
image1.src = "<?=HTTPS_IMAGE?>loading.gif";

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
			url: '<?=HTTPS_SERVER?>index.php?route=payment/ipagare_web/confirm',
			success: function(data) {
			if(data == "OK")
			{
				$('.content.round').css("display" , "none");
				$('#loadingIpagare').css("display" , "block");
				
				$.ajax({ 
					type: 'GET',
					url: '<?=HTTPS_SERVER?>index.php?route=payment/ipagare_web/enviaPagamento',
					success: function(data) {
					if(data == "OK")
					{
						window.location = '<?=HTTPS_SERVER?>index.php?route=checkout/success';
					}
					else
					{
						window.location = '<?=HTTPS_SERVER?>index.php?route=checkout/success';
					}
					
					}		
				}
			);
				
				
				
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