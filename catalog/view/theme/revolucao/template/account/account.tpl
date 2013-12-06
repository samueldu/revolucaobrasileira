<?php echo $header; ?>
<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px" />
<div id="content carrinho">
  <div class="middle account">
	<?php if ($success) { ?>
	<div class="success"><?php echo $success; ?></div>
	<?php } ?>
	   <div class="content round central" style="padding-top: 10px"> <?=wall($id_wall,$origem)?>
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