<?php echo $header; ?>
	<?php if(!is_null($orderDetails) && !is_null($orderProducts)) { ?>

    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', '<?=$google_analytics_ua_code?>']);
      _gaq.push(['_addTrans',
        '<?php echo $orderDetails['order_id']; ?>',
        '<?=$config_name?>',
        '<?php echo $orderDetails['total']; ?>',
        '',
        '',
        '',
        '',
        ''
       ]);

       <?php foreach($orderProducts as $product) { ?>
          _gaq.push(['_addItem',
              "<?php echo $product['order_id']; ?>",
              "<?php echo $product['product_id']; ?>",
              <?php echo json_encode($product['name']); ?>,
              "<?php echo $product['model']; ?>",
              "<?php echo $product['price']+($product['price']*$product['tax']/100); ?>",
              "<?php echo $product['quantity']; ?>"
           ]);
       <? } ?>
       
       _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <?php } ?>
<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px" />
<div id="content carrinho">
  <div class="middle account">
    <h1><?php echo $heading_title; ?></h1>
    <div class="content round">
      <table>
        <tr>
          <td width="300" valign="top">
          <div class="boxAmarelo round"><?php if ($invoice_id) { ?>
            <b><?php echo $text_invoice_id; ?></b><br />
            <?php echo $invoice_id; ?><br />
            <br />
            <?php } ?>
            <?php echo $text_order_id; ?><br />
            <span style="font-size:22px"><?php echo $order_id; ?></span><br /><br />
            
            <div style="text-align:left; border-top:1px solid #EEDD9F; padding-top:10px">  <?php if ($shipping_address) { ?>
            <b><?php echo $text_shipping_address; ?></b><br />
            <?php echo $shipping_address; ?><br />
            <?php } ?></div>
            
             <div style="text-align:left; border-top:1px solid #EEDD9F; margin-top:10px; padding-top:10px">
                         <b><?php echo $text_email; ?></b> <?php echo $email; ?><br />
            <b><?php echo $text_telephone; ?></b> <?php echo $telephone; ?><br />
            </div>
          </div>
         </td>
          <td valign="top">

            <span style="font-size:11px"><?php echo $text_payment_method; ?></span ><BR> 
            <span style="font-size:16px"><?php echo $payment_method; ?></span><br />  <BR>
            <span style="font-size:11px"><?php echo $text_status; ?></span ><BR> 
            <span style="font-size:16px"><?php echo $status_atual; ?></span><br />  <BR>
            <p style="font-size:11px"><?=$text_invoice_long?></p>
            <?php if ($shipping_method) { ?>
              <span style="font-size:11px"><?php echo $text_shipping_method; ?></span><br />
              <span style="font-size:16px"><?php echo $shipping_method; ?></span><br />
            <?php } ?>
         </td>
          <!--td width="33.3%" valign="top"><b><?php echo $text_payment_address; ?></b><br />
            <?php echo $payment_address; ?><br /></td-->
        </tr>
      </table>
    </div>
    <div class="content round">
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr class="barraTitulo">
          <th align="left"><?php echo $text_product; ?></th>
          <th align="left"><?php echo $text_model; ?></th>
          <th align="center"><?php echo $text_quantity; ?></th>
          <th align="right"><?php echo $text_price; ?></th>
          <th align="right"><?php echo $text_total; ?></th>
        </tr>
        <?php foreach ($products as $product) { ?>
        <tr class="listaProdutos">
          <td align="left" valign="top"><b><?php echo $product['name']; ?></b>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            &nbsp;<small> - <?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
            <?php } ?></td>
          <td align="left" valign="top"><?php echo $product['model']; ?></td>
          <td align="center" valign="top"><?php echo $product['quantity']; ?></td>
          <td align="right" valign="top"><?php echo $product['price']; ?></td>
          <td align="right" valign="top"><?php echo $product['total']; ?></td>
        </tr>
        <?php } ?>
      </table>
      <br />
      <div style="width: 100%; display: inline-block;">
        <table style="float: right; display: inline-block;">
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td align="right"><b><?php echo $total['title']; ?></b></td>
            <td align="right" style="font-size:14px"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
        </table>
      </div>
    </div>
    <?php if ($comment) { ?>
    <b style="margin-bottom: 2px; display: block;"><?php echo $text_comment; ?></b>
    <div class="content"><?php echo $comment; ?></div>
    <?php } ?>
    <!--
    <?php if ($historys) { ?>
    <h1><?php echo $text_order_history; ?></h1>
    <div class="content round">
      <table width="536">
        <tr>
          <th align="left"><?php echo $column_date_added; ?></th>
          <th align="left"><?php echo $column_status; ?></th>
          <th align="left"><?php echo $column_comment; ?></th>
        </tr>
        <?php foreach ($historys as $history) { ?>
        <tr>
          <td valign="top"><?php echo $history['date_added']; ?></td>
          <td valign="top"><?php echo $history['status']; ?></td>
          <td valign="top"><?php echo $history['comment']; ?></td>
        </tr>
        <?php } ?>
      </table>
    </div>
    <?php } ?>
    -->
    <div class="buttons">
      <table>
        <tr>
          <td align="right"><a onclick="location = '<?php echo str_replace('&', '&amp;', $continue); ?>'" class="button"><span><?php echo $button_continue; ?></span></a></td>
        </tr>
      </table>
    </div>
  </div>
  
</div>
<?php echo $footer; ?> 