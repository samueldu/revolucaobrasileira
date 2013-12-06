<?php echo $header; ?><?php //echo $column_left; ?>
<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px" />
<div id="content carrinho" >
  <div class="middle account">
        <h1><?php echo $heading_title; ?></h1>
  <?php echo $text_message; ?>


    <div class="buttons">
      <table>
        <tr>
          <td align="right"><a onclick="location = '<?php echo str_replace('&', '&amp;', $continue); ?>'" class="button"><span><?php echo $button_continue; ?></span></a></td>
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