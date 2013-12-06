<div class="box">
  <div class="topGreen round"><?php echo $heading_title; ?></div>
  <div class="middle" style="text-align: center;">
    <select onchange="location = this.value" class="marcas">
      <option value=""><?php echo $text_select; ?></option>
      <?php foreach ($manufacturers as $manufacturer) { ?>
      <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
      <option value="<?php echo str_replace('&', '&amp;', $manufacturer['href']); ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
      <?php } else { ?>
      <option value="<?php echo str_replace('&', '&amp;', $manufacturer['href']); ?>"><?php echo $manufacturer['name']; ?></option>
      <?php } ?>
      <?php } ?>
    </select>
  </div>
  
<?php 

foreach ($manufacturers as $manufacturer) { 
if($manufacturer['show_home'] == 1)
 {
?>
<div class="manuImg">
<a href="<?php echo str_replace('&', '&amp;', $manufacturer['href']); ?>"><img src="<?=$manufacturer['image']?>" alt="<?php echo $manufacturer['name']; ?>" title="<?php echo $manufacturer['name']; ?>"></a><br />
</div>
<?php 
 }
 
 }?>  
</div>
