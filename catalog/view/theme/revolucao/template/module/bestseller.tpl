<div class="box">
  <div class="topGreen round"><?php echo $heading_title; ?></div>
  <div class="middle">
    <?php if ($products) { ?>
    <table cellpadding="2" cellspacing="0" class="maisVendidos">
      <?php foreach ($products as $product) { ?>
      <tr>
        <td valign="top" style="width:1px"><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" /></a></td>
        <td valign="top" style="padding-left:5px;"><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" class="nomeProduto" style="font-size: 11px;"><?php echo $product['name']; ?></a>
          <?php if ($product['rating']) { ?>
          <br />
          <img src="catalog/view/theme/default/image/stars_<?php echo $product['rating'] . '.png'; ?>" alt="<?php echo $product['stars']; ?>" />
          <?php } ?>
          
          <?php if ($display_price) { ?>
          <br />
          
          <?php if (!$product['special']) { ?>
          <span style="font-size: 11px; color: #5c936a;" ><?php echo $product['price']; ?></span>
          <?php } else { ?>
          <span style="font-size: 11px; color: #666; text-decoration: line-through;">de: <?php echo $product['price']; ?></span><br /> <span style="font-size: 11px; color: #5c936a;">por: <?php echo $product['special']; ?></span>
          <?php } ?>
          <?php } ?>
		  </td>
      </tr>
      <?php } ?>
    </table>
    <?php } ?>
  </div>
</div>
