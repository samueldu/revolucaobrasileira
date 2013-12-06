<?php echo $header; ?>

<?php echo $column_right; ?>

<div id="content" class="departamento">
  <div class="middle">

    <table>
	  <tr>
	    <?php if ($thumb) { ?>
        <td><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></td>	  
        <?php } ?>
        <?php if ($description) { ?>
	    <td><?php echo $description; ?></td>
	    <?php } ?>
	  </tr>
	</table>
	<?php if (!$categories && !$products) { ?>
    <div class="content"><?php echo $text_error; ?></div>
    <?php } ?>
  
  
    <?php if ($categories) { ?>
    <!--table class="list">
      <?php for ($i = 0; $i < sizeof($categories); $i = $i + 4) { ?>
      <tr>  
        <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
        <td width="25%">
        <?php if (isset($categories[$j])) { ?>
          <a href="<?php echo $categories[$j]['href']; ?>"><img src="<?php echo $categories[$j]['thumb']; ?>" title="<?php echo $categories[$j]['name']; ?>" alt="<?php echo $categories[$j]['name']; ?>" style="margin-bottom: 3px;" /></a><br />
          <a href="<?php echo $categories[$j]['href']; ?>"><?php echo $categories[$j]['name']; ?></a>
          <?php } ?></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </table-->
    <?php } ?>
    <?php if ($products) { ?>
    <div class="sort">
      <div class="div2"><?php echo $text_sort; ?></div>     
      <div class="div1">
        <select name="sort" onchange="location = this.value">
          <?php foreach ($sorts as $sorts) { ?>
          <?php if (($sort . '-' . $order) == $sorts['value']) { ?>
          <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </div>
      <!--div class="div2"><?php echo $text_filter_manufactures; ?></div>
      <div class="div1">
      	  <select name='filterManufactures' onchange="location = this.value">
      	  	<option value="<?php echo $selectManufacurer;?>"><?php echo $text_all_brands; ?></option>
      	  <?php foreach ($manufactures as $values) { ?>
      	  	<?php if($values["manufacturer_id"] == $manufacturer_id){?>
	          <option value="<?php echo $values['href_url']; ?>" selected="selected"><?php echo $values['name']; ?></option>
	        <?php }else{ ?>
	          <option value="<?php echo $values['href_url']; ?>"><?php echo $values['name']; ?></option>
	        <?php } ?>
          <?php } ?>
          </select>
      </div>
    </div-->
    <div class="div2"><?php echo $text_filter_sizes; ?></div>
      <div class="div1">
      	  <select name='filterSizes' onchange="location = this.value">
      	  	<option value="<?php echo $selectSize;?>"><?php echo $text_all_sizes; ?></option>
      	  <?php foreach ($sizes as $values) { ?>
      	  	<?php if($values["name"] == $option_id){?>
	          <option value="<?php echo $values['href_url']; ?>" selected="selected"><?php echo $values['name']; ?></option>
	        <?php }else{ ?>
	          <option value="<?php echo $values['href_url']; ?>"><?php echo $values['name']; ?></option>
	        <?php } ?>
          <?php } ?>
          </select>
      </div>
    </div>
      <div class="pagination paginationTop"><?php echo $pagination; ?></div>
    
    <table class="list">
      <?php for ($i = 0; $i < sizeof($products); $i = $i + 4) { ?>
      <tr>
        <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
        <td width="25%"><?php if (isset($products[$j])) { ?>
         
         
          <?=$products[$j]['txt']?>

          
          <?php } ?></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </table>
    <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 