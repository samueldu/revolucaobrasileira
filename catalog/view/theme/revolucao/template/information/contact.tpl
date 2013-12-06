<?php echo $header; ?>


<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px;" />
<div id="content carrinho">
  <div class="top">
  <div class="middle account">
      <h1 ><?php echo $heading_title; ?></h1>

      <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="contact">

      <div class="content round" style="padding-top: 10px;">
        <table width="100%">
          <tr>
            <td width="30" style="padding-bottom:10px"><?php echo $entry_name; ?> <BR> <BR>
              <input type="text" name="name" class="inputContat" value="<?php echo $name; ?>" size="25" />
              <?php if ($error_name) { ?>
              <span class="error"><?php echo $error_name; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td style="padding-bottom:10px"><?php echo $entry_email; ?> <BR> <BR>
              <input type="text" name="email" class="inputContat" value="<?php echo $email; ?>" size="25" />
              <?php if ($error_email) { ?>
              <span class="error"><?php echo $error_email; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td ><?php echo $entry_enquiry; ?><br /> <BR>
              <textarea name="enquiry" class="inputContat" style="width: 400px; height: 200px" rows="4"><?php echo $enquiry; ?></textarea>
              <?php if ($error_enquiry) { ?>
              <span class="error"><?php echo $error_enquiry; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td ><img src="index.php?route=information/contact/captcha" /><br /><?php echo $entry_captcha; ?><BR><BR><BR>
              <input type="text" class="inputContat" name="captcha" value="<?php echo $captcha; ?>" autocomplete="off" />
              <?php if ($error_captcha) { ?>
              <span class="error"><?php echo $error_captcha; ?></span>
              <?php } ?>
           <BR><BR>
             <div class="button_loja"><a onclick="$('#contact').submit();" class=""><span><?php echo $button_continue; ?></span></a></div></td>
          </tr>
        </table>
      </div>

      <div class="buttons">
        <table>
          <tr>
            <td align="right"></td>
          </tr>
        </table>
      </div>
    </form>
  </div>
</div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 