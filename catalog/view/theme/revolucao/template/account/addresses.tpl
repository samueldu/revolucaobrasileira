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
    <span style="margin-bottom: 2px; display: block; color:#666; padding-bottom:10px"><?php echo $text_address_book; ?></span>
    <?php foreach ($addresses as $result) { ?>
    <div class="content round">
      <table width="100%">
        <tr>
          <td style="font-size:13px"><?php echo $result['address']; ?></td>
          <td style="text-align: right;" width="200px;"><a onclick="location = '<?php echo str_replace('&', '&amp;', $result['update']); ?>'" class="button"><span><?php echo $button_edit; ?></span></a>&nbsp;<a onclick="location = '<?php echo str_replace('&', '&amp;', $result['delete']); ?>'" class="button"><span><?php echo $button_delete; ?></span></a></td>
        </tr>
      </table>
    </div>
    <?php } ?>
    <div class="buttons">
      <table>
        <tr>
          <td align="left"><a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
          <td align="right"><a onclick="location = '<?php echo str_replace('&', '&amp;', $insert); ?>'" class="button"><span><?php echo $button_new_address; ?></span></a></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 