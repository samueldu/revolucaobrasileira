<div id="content carrinho">
      <h1><?php echo $heading_title; ?></h1>

    <?php if ($error) { ?>
    <div class="warning"><?php echo $error; ?></div>
    <?php } ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="forgotten">
      <p style="padding:15px 0"><?php echo $text_email; ?></p>


      <div style="margin-bottom: 20px;" class="round">
        <table>
          <tr>
            <td width="120"><?php echo $entry_email; ?></td>
            <td><input type="text" id="email" name="email" size="30" class="input_grande" onkeydown="this.style.background = '#faffbd'" /></td>
          </tr>
        </table>
      </div>

        <table>
          <tr>
            <td align="right"  class="button_loja"><a onclick="recuperarSenha()" ><span><?php echo $button_continue; ?></span></a></td>
            <td align="left"  class="button_loja"><a onclick="navegaBox('<?=BASE_URL?>/account/login');" ><span><?php echo $button_back; ?></span></a></td>
          </tr>
        </table>
    </form>
  </div>
