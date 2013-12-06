<?php echo $header; ?>
<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px" />
<div id="content carrinho">
  <div class="middle account">
    <h1><?php echo $heading_title; ?></h1>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="newsletter">
      <div class="content round">
        <table>
          <tr>
            <td width="250"><?php echo $entry_newsletter; ?></td>
            <td><?php if ($newsletter) { ?>
              <input type="radio" name="newsletter" value="1" checked="checked" style="vertical-align:middle" />
              <?php echo $text_yes; ?>&nbsp;
              <input type="radio" name="newsletter" value="0" style="vertical-align:middle" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="newsletter" value="1" style="vertical-align:middle" />
              <?php echo $text_yes; ?>&nbsp;
              <input type="radio" name="newsletter" value="0" checked="checked" style="vertical-align:middle" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
        </table>
      </div> <BR><BR><BR>
      <div class="buttons" >
        <table>
          <tr>
            <td align="left"><a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
            <td align="right"><a onclick="$('#newsletter').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
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