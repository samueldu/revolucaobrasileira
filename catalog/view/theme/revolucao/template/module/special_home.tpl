<?php if ($products) { ?>
<div class="top">
  <div class="left"></div>
  <div class="right"></div>
  <div class="center">
    <div class="heading"><?php echo $heading_title; ?></div>
  </div>
</div>

<div class="middle">
  <table class="list">
  <?php for ($i = 0; $i < sizeof($products); $i = $i + 4) { ?>
    <tr>
      <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
      <td style="width: 25%;"><?php if (isset($products[$j])) { ?>
      <a href="<?php echo str_replace('&', '&amp;', $products[$j]['href']); ?>"><img src="<?php echo $products[$j]['thumb']; ?>" title="<?php echo $products[$j]['name']; ?>" alt="<?php echo $products[$j]['name']; ?>" /></a><br />
      <a href="<?php echo str_replace('&', '&amp;', $products[$j]['href']); ?>"  class="nomeProduto"><?php echo $products[$j]['name']; ?></a><br />
      <span style="color: #999; font-size: 11px;"><?php echo $products[$j]['model']; ?></span><br />
      <?php if ($products[$j]['rating']) { ?>
      <img src="catalog/view/theme/<?=TEMPLATE?>/image/stars_<?php echo $products[$j]['rating'] . '.png'; ?>" alt="<?php echo $products[$j]['stars']; ?>" />
      <?php } ?>
      <br />
      <?php if ($display_price) { ?>
      <?php if (!$products[$j]['special']) { ?>
      <span style="color: #5c936a; font-weight: bold;"><?php echo $products[$j]['price']; ?></span>
      <?php } else { ?>
      <span style="color: #666;  text-decoration: line-through;">de: <?php echo $products[$j]['price']; ?></span><br /> <span style="color: #5c936a;font-weight: bold;">por: <?php echo $products[$j]['special']; ?></span>
      <?php } ?>
      <a class="button_add_small" href="<?php echo $products[$j]['add']; ?>" title="<?php echo $button_add_to_cart; ?>" >&nbsp;</a>
      <?php } ?>
	    <a id="details<?php echo $products[$j]['product_id'];?>" href="javascript:quickView(<?php echo $products[$j]['product_id'];?>,$('#details<?php echo $products[$j]['product_id'];?>'));javascript:dimOn();" style="text-transform:uppercase;color:#858585;font-size:10px"  class="button_add_small" >&nbsp;</a>

      <?php } ?></td>
      <?php } ?>
    </tr>
    <?php } ?>
  </table>
</div>

<div class="bottom">
  <div class="left"></div>
  <div class="right"></div>
  <div class="center"></div>
</div>
<?php } ?>