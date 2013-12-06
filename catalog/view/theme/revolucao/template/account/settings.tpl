<?php echo $header; ?>
<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px" />
<div id="content carrinho">
  <div class="middle account">
	  <h1><?php echo $heading_title; ?></h1>
	<?php if ($success) { ?>
	<div class="success"><?php echo $success; ?></div>
	<?php } ?>
	   <div class="content round central">
		<ul>
		  <li class="title"><?php echo $text_my_account; ?></li>
		  <li><img src="catalog/view/theme/<?=TEMPLATE?>/image/edit1.png" alt="" style="float: left; margin-right: 8px;">
		  <a href="<?php echo str_replace('&', '&amp;', $information); ?>"><?php echo $text_information; ?></a></li>
		  <li><a href="<?php echo str_replace('&', '&amp;', $password); ?>"><?php echo $text_password; ?></a></li>
		</ul>
		<BR><BR><BR>
		<ul>
		  <li class="title"><?php echo $text_my_newsletter; ?></li>
		  <li><img src="catalog/view/theme/<?=TEMPLATE?>/image/newsletter.png" alt="" style="float: left; margin-right: 8px;"><a href="<?php echo str_replace('&', '&amp;', $newsletter); ?>"><?php echo $text_newsletter; ?></a></li>
		</ul>
	  </div>
  </div>
</div>

<Script>
    function confirm(meuId,amigoId)
    {

        var dataString = "toid="+meuId+'&fromid='+amigoId;

        $.ajax({
            type: "POST",
            url: "ajax/ajax/confirm",
            data: dataString,
            cache: false,
            success: function(response){

                document.getElementById("link").style.display="none";
                document.getElementById("adicionado"+amigoId).style.display="block";

            }
        });
    }
</script>

<?php echo $footer; ?> 