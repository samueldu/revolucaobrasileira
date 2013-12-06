<?php echo $header; ?>
<div id="content carrinho">
  <div class="middle account">
      <h1><?php echo $heading_title; ?></h1>
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <p><?php echo $text_payment_address; ?></p>
    <div class="content round">
      <table width="100%">
        <tr>
          <td width="50%" valign="top"><b><?php echo $text_payment_address; ?></b><br />
            <span style="font-size:11px;"><?php echo $address; ?></span></td>
          <td width="50%" valign="top" align="right">
          <a onclick="location = '<?php echo str_replace('&', '&amp;', $change_address); ?>'" class="button"><span><?php echo $button_change_address; ?></span></a></td>

        </tr>
      </table>
    </div>
    <?php if ($coupon_status) { ?>
    <div class="content round">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="coupon">
        
        <table><tr><td valign="middle" width="580" style="font-size:10px; text-transform:uppercase"><?php echo $text_coupon; ?></td>
        <td align="right" width="280">
        <!--?php echo $entry_coupon; ?-->
        <input type="text" name="coupon" value="<?php echo $coupon; ?>" />&nbsp;
         <a onclick="$('#coupon').submit();" class="button"><span><?php echo $button_coupon; ?></span></a>
	    </td></tr></table>
      </form>
    </div>
    <?php } ?>
	<form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="payment">
      <?php if ($payment_methods) { ?>
      <h1><?php echo $text_payment_method; ?></h1>
      <div class="content round">
        <p><?php echo $text_payment_methods; ?></p>
        <table width="100%" cellpadding="3">
          <?php foreach ($payment_methods as $payment_method) { ?>
          <tr>
            <td width="1">
              <?php if ($payment_method['id'] == $payment || !$payment) { ?>
			  <?php $payment = $payment_method['id']; ?>
              <input type="radio" name="payment_method" value="<?php echo $payment_method['id']; ?>" id="<?php echo $payment_method['id']; ?>" checked="checked" style="margin: 0px;" />
              <?php } else { ?>
              <input type="radio" name="payment_method" value="<?php echo $payment_method['id']; ?>" id="<?php echo $payment_method['id']; ?>" style="margin: 0px;" />
              <?php } ?></td>
            <td><label for="<?php echo $payment_method['id']; ?>" style="cursor: pointer;"><?php echo $payment_method['title']; ?></label></td>
          </tr>
          <?php } ?>
        </table>
      </div>
      <?php } ?>
      <h1><?php echo $text_comments; ?></h1>
      <div class="content round">
        <textarea name="comment" rows="8" style="width: 99%;"><?php echo $comment; ?></textarea>
      </div>
      <?php if ($text_agree) { ?>
      <div class="buttons">
        <table>
          <tr>
            <td align="left"><a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
            <td align="right" style="padding-right: 5px;"><?php echo $text_agree; ?></td>
            <td width="5" style="padding-right: 10px;"><?php if ($agree) { ?>
              <input type="checkbox" name="agree" value="1" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="agree" value="1" />
              <?php } ?></td>
            <td align="right" width="5"><a onclick="$('#payment').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
      <?php } else { ?>
      <div class="buttons">
        <table>
          <tr>
            <td align="left"><a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
            <td align="right"><a onclick="$('#payment').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
      <?php } ?>
    </form>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 