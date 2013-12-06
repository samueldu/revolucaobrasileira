<?php echo $header; ?>
<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px" />
<div id="content carrinho">
    <div class="middle account">
   <h1><?php echo $heading_title; ?></h1>
  <span style="margin-bottom: 2px; display: block; padding-bottom:20px; color:#666">Aqui você tem acesso a todas as informações sobre o histórico dos seus pedidos, rastreamento e outros dados importantes que ficam disponíveis neste serviço</span>   
    <?php foreach ($orders as $order) { ?>
    <div style="display: inline-block; margin-bottom: 10px; width: 100%;">
      <div style="width: 49%; float: left; margin-bottom: 2px;" class="title"><?php echo $text_order; ?> <?php echo $order['order_id']; ?></div>
      <div style="width: 49%; float: right; margin-bottom: 2px; text-align: right;"><b><?php echo $text_status; ?></b> <?php echo $order['status']; ?></div>
      <div class="content round" style="clear: both;">
          <table width="100%">
            <tr>
              <td><b><?php echo $text_date_added; ?></b> <?php echo $order['date_added']; ?></td>
              <td><b>Forma de Pagamento:</b> <?=$order['payment_method']?></td>
              <td rowspan="2" style="text-align: right;"><a onclick="location = '<?php echo str_replace('&', '&amp;', $order['href']); ?>'" class="button"><span><?php echo $button_view; ?></span></a></td>
            </tr>
            <tr>
              <td><b><?php echo $text_products; ?></b> <?php echo $order['products']; ?></td>
              <td><b><?php echo $text_total; ?></b> <?php echo $order['total']; ?></td>
            </tr>
          </table>
      </div>
    </div>
    <?php } ?>
    <div class="pagination"><?php echo $pagination; ?></div>
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