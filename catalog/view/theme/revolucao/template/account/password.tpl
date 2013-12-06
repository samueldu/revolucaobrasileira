<?php echo $header; ?>
<div id="content carrinho">
  <div class="middle account">
      <h1><?php echo $heading_title; ?></h1>

    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="password">
      <span style="margin-bottom: 2px; display: block; padding-bottom:10px; color:#666"><?php echo $text_password; ?></span>
      <div class="content round">
        <table>
          <tr>
            <td width="120" align="right"><span class="required">*</span> <?php echo $entry_password; ?></td>
            <td><input type="password" name="password" value="<?php echo $password; ?>" onkeydown="this.style.background = '#faffbd'"  />
              <?php if ($error_password) { ?>
              <span class="error"><?php echo $error_password; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td align="right"><span class="required">*</span> <?php echo $entry_confirm; ?></td>
            <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" onkeydown="this.style.background = '#faffbd'"  />
              <?php if ($error_confirm) { ?>
              <span class="error"><?php echo $error_confirm; ?></span>
              <?php } ?></td>
          </tr>
        </table>
      </div>
      <div class="buttons">
        <table>
          <tr>
            <td align="left"><a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
            <td align="right"><a onclick="$('#password').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
    </form>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 