<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
</head>
<body>
<table style="font-family: Verdana,sans-serif; font-size: 11px; color: #374953; width: 600px;">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0"><tr>
    <td align="left"><a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><img src="<?=HTTP_IMAGE?>data/logo.png" alt="<?php echo $store_name; ?>" style="border: none;" ></a></td>
    <td valign="bottom"  style=" color:#666; font-size: 18px; text-align:right"><?php echo $text_order_detail; ?></td></tr></table>
  </tr>
  
  </table>
  
  <table style="background:#f7f7f7; border:1px solid #ddd; width:600px; padding:15px; color:#666;">
  <tr>
  <td><table width="100%"><tr>
    <td style="background:#FDF4D3; border:1px solid #EEDD9F; padding:10px; width:200px; text-align:center; font-size:11px;">
    
    <div style="padding-bottom:10px"><?php echo $text_order_id; ?> <br><span style="color: #666; font-size:22px; font-weight: bold;"><?php echo $order_id; ?></span><br>
      <?php echo $text_date_added; ?> <?php echo $date_added; ?><br ></div>
      
      <div style="text-align: left; border-top: 1px solid rgb(238, 221, 159); padding-top: 10px;"><?php echo $text_email; ?> <strong><?php echo $customer_email; ?></strong><br />
	  <?php echo $text_telephone; ?> <strong><?php echo $customer_telephone; ?></strong><br />
	  <?php echo $text_ip; ?> <strong><?php echo $customer_ip; ?></strong></div>
	</td>
    <td valign="top" style="padding:10px; font-size:11px">
      <?php echo $text_payment_method; ?> <strong><?php echo $payment_method; ?></strong><br />   <br>
      <?php echo $text_greeting; ?><br><br>
      <?php echo $text_shipping_method; ?> <strong><?php echo $shipping_method; ?></strong><br />
	  
    </td></tr></table>
  </tr>
  <tr>
          <td style="text-align: left; padding: 10px; font-size:11px; color:#666">
          <span style="font-size:18px;"><?php echo $text_shipping_address; ?></span><br><?php echo $shipping_address; ?>
          <!--th style="text-align: left; padding: 0.3em;"><?php echo $text_payment_address; ?></th-->

        <!--tr>
          <td style="padding: 0.3em; background-color: #EEEEEE; color: #000;"></td>
          <td style="padding: 0.3em; background-color: #EEEEEE; color: #000;"><?php echo $payment_address; ?></td>
        </tr-->
</td>
  </tr>
  <tr>
    <td align="left">
    <table style="width: 100%; font-family: Verdana,sans-serif; font-size: 11px; color: #000000;" cellpadding="0" cellspacing="0">
        <tr style="background-color: #e9e9e9; color:#666; font-size:11px">
          <th width="30%" align="left" style=" padding: 8px;"><?php echo $column_product; ?></th>
          <th width="16%" align="left"><?php echo $column_model; ?></th>
          <th width="20%" align="right" style=" padding: 8px;"><?php echo $column_price; ?></th>
          <th width="17%" align="right" style=" padding: 8px;"><?php echo $column_quantity; ?></th>
          <th width="17%" align="right" style=" padding: 8px;"><?php echo $column_total; ?></th>
        </tr>
        <?php foreach ($products as $product) { ?>
        <tr style=" text-align: center; color:#666">
          <td align="left" style="border-bottom:1px solid #ddd; padding:10px"><?php echo $product['name']; ?>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            &nbsp;&nbsp;- <?php echo $option['name']; ?>: <?php echo $option['value']; ?>
            <?php } ?></td>
          <td align="left" style="border-bottom:1px solid #ddd; padding:10px"><?php echo $product['model']; ?></td>
          <td align="right" style="border-bottom:1px solid #ddd; padding:10px"><?php echo $product['price']; ?></td>
          <td align="right" style="border-bottom:1px solid #ddd; padding:10px"><?php echo $product['quantity']; ?></td>
          <td align="right" style="border-bottom:1px solid #ddd; padding:10px"><?php echo $product['total']; ?></td>
        </tr>
        <?php } ?>
        <?php foreach ($totals as $total) { ?>
        <tr style="text-align: right; color:#666">
          <td colspan="2">&nbsp;</td>
          <td colspan="2" style=" font-weight: bold; padding: 0.3em;"><?php echo $total['title']; ?></td>
          <td style=" padding: 0.3em; font-size:13px"><?php echo $total['text']; ?></td>
        </tr>
        <?php } ?>
      </table></td>
  </tr>

  <?php if ($comment) { ?>
  <tr>
    <td align="left" style="background-color: #d1d1d1; color: #666; font-size: 12px; font-weight: bold; padding: 0.5em 1em;"><?php echo $text_comment; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><?php echo $comment; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <?php } ?>
  <?php if ($customer_id) { ?>
  <!--tr>
    <td align="left" style=" color: #666; font-size: 11px;  padding: 10px; padding-bottom:0; color:#666"><?php echo $text_invoice; ?></td>
  </tr-->
  <tr>
    <td align="left" style="padding:10px; padding-top:5px"><a href="<?php echo $invoice; ?>"><img border="0" style="cursor:pointer" src="<?=HTTP_IMAGE?>mail_acompanhe.png"></a></td>
  </tr>
  <?php } ?>
  <tr>
    <td align="center" style="font-size: 10px; border-top: 1px solid #ccc;"><a href="<?php echo $store_url; ?>" style="color: #666; font-weight: bold; text-decoration: none;"><?php echo $store_name; ?></a> <?php echo $text_powered_by; ?> <a href="http://www.globalwebmasters.com" style="text-decoration: none; color: #374953;">GW Group</a></td>
  </tr>
</table>
</body>
</html>
