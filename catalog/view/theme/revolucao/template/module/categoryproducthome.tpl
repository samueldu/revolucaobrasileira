<?php foreach ($products as $key => $product){ ?>
<?php if ($product) { ?>
<div class="top">
  <div class="left"></div>
  <div class="right"></div>
  <div class="center">
    <h1><?php echo $heading_title[$key]["name"]; ?></h1>
  </div>
</div>

<div class="middle">
  <table class="list">
  <?php for ($i = 0; $i < sizeof($product); $i = $i + 4) { ?>
    <tr>
      <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
      <td style="width: 25%;"><?php if (isset($product[$j])) { ?>
			
			          <?
			          print $product[$j]['txt'];
			          }?>
			
			</td>
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
<?php } ?>