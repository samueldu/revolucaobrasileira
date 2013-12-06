<?php
  $low_level = 2;
  $warning_level = 5;
?>
<?php echo $header; ?>
<style>
.list tbody tr.stocklow td {
	font-weight:bold;
	color: orange;
}
.list tbody tr.stockwarning td {
	font-weight:bold;
	color: red;
}
</style>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/report.png');"><?php echo $heading_title; ?></h1>
  </div>
  <div class="content">
<table class="list">
  <thead>
    <tr>
      <td class="left"><?php echo $column_name; ?></td>
      <td class="left"><?php echo $column_sku; ?></td>
      <td class="left"><?php echo $column_location; ?></td>
      <td class="left"><?php echo $column_model; ?></td>
      <td class="right"><?php echo $column_stock; ?></td>
    </tr>
  </thead>
  <tbody>
    <?php if ($products) { ?>
    <?php $class = 'odd'; ?>
    <?php foreach ($products as $product) { ?>
    <?php $class = ($class == 'even' ? 'odd' : 'even');
    $lowstyle = '';
    if ((int)$product['stock'] <= $warning_level && (int)$product['stock'] > $low_level) {
      $lowstyle = 'stocklow';
    } elseif ((int)$product['stock'] <= $low_level) {
      $lowstyle = 'stockwarning';
    }
    ?>
    <tr class="<?php echo $class . ' ' . $lowstyle; ?>">
      <td class="left"><?php echo '<a href="' . $url_product . $product['id'] . '&token=' . $this->session->data['token'] . '">' . $product['name'] . '</a>' ; ?></td>
      <td class="left"><?php echo $product['sku']; ?></td>
      <td class="left"><?php echo $product['location']; ?></td>
      <td class="left"><?php echo $product['model']; ?></td>
      <td class="right"><?php echo $product['stock']; ?></td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr class="even">
      <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
<?php echo $footer; ?>