<div class="boxNews">

  
  <?php 
   if($thickbox) { ?>
	<a href="#TB_inline?height=300&width=300&inlineId=frm_subscribe" title="Newsletter Subcribe" class="thickbox"> <?php echo($text_subscribe); ?> </a>
  <?php }  ?>
  <div id="frm_subscribe" <?php 
   if($thickbox) { ?> style="display:none;" <?php } ?>>
  <form name="subscribe" id="subscribe">
  <table border="0" cellpadding="2" cellspacing="2">
    <tr>
     <td align="left"><input type="text" value="<?php echo $entry_name; ?>" name="subscribe_name" id="subscribe_name"> </td>
     <td align="left"><input type="text" value="<?php echo $entry_email; ?>" name="subscribe_email" id="subscribe_email"></td>
         <td align="left">
     <a onclick="email_subscribe()"><img src="catalog/view/theme/<?=$template?>/image/btCadastrar.gif" alt="Cadastrar" class="btCadastro" /></a>
     
     <?php if($option_unsubscribe) { ?>
          <a onclick="email_unsubscribe()"><img src="catalog/view/theme/<?=$template?>/image/btDecadastrar.gif.gif" alt="Cadastrar" class="btCadastro" /></a>
      <?php } ?> 
     </td>
     <td align="center" id="subscribe_result">
     </td>     
   </tr>
 
   <?php 
     for($ns=1;$ns<=$option_fields;$ns++) {
     $ns_var= "option_fields".$ns;
   ?>
   <tr>
    <td align="left">
      <?php 
       if($$ns_var!=""){
         echo($$ns_var."&nbsp;<br/>");
         echo('<input type="text" value="" name="option'.$ns.'" id="option'.$ns.'">');
       }
      ?>
     </td>
   </tr>
   <?php 
     }
   ?>
   <tr>
 
   </tr>
   <tr>

   </tr>
  </table>
  </form>

  </div>

<script language="javascript">
	<?php 
  		if(!$thickbox) { 
	?>	
function email_subscribe(){
	$.ajax({
			type: 'post',
			url: 'index.php?route=module/newslettersubscribe/subscribe',
			dataType: 'html',
            data:$("#subscribe").serialize(),
			success: function (html) {
				eval(html);
			}}); 
}
function email_unsubscribe(){
	$.ajax({
			type: 'post',
			url: 'index.php?route=module/newslettersubscribe/unsubscribe',
			dataType: 'html',
            data:$("#subscribe").serialize(),
			success: function (html) {
				eval(html);
			}}); 
}
   <?php }else{ ?>
function email_subscribe(){
	$.ajax({
			type: 'post',
			url: 'index.php?route=module/newslettersubscribe/subscribe',
			dataType: 'html',
            data:$("#TB_ajaxContent #subscribe").serialize(),
			success: function (html) {
				eval(html);
			}}); 
}
function email_unsubscribe(){
	$.ajax({
			type: 'post',
			url: 'index.php?route=module/newslettersubscribe/unsubscribe',
			dataType: 'html',
            data:$("#TB_ajaxContent #subscribe").serialize(),
			success: function (html) {
				eval(html);
			}}); 
}
   <?php } ?>
</script>
</div>
