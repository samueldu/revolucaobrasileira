<?php echo $header; ?>
<hr style="border-top:1px dotted #CCC; border-bottom:none;height:1px;margin-bottom:10px" />
<div id="content" style="margin-left:0; margin-right:0" class="carrinho">
 <h1><?php echo $heading_title; ?></h1>  

<script>

function deletaProduto(produto){
	$('#remove'+produto).attr('checked', true);
    $('#cart').submit();
}

</script> 

  <div class="middle account">
  
  	<?
  	if(isset($text_error))
  	{
  	?>
  	<div class="warning"><?php echo $text_error; ?></div>
  	<?
  	
  	}
  	else
  	{
  	?>
    
  
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="cart">

      <table class="cart">
        <tr class="titulo">
          <th align="center"><?php echo $column_image; ?></th>
          <th align="left" width="300"><?php echo $column_name; ?></th>
          <th align="center"><?php echo $column_model; ?></th>
          <th align="center"><?php echo $column_quantity; ?></th>
          <th align="center"><?php echo $column_remove; ?></th>
          <?php if ($display_price) { ?>
		  <th align="center"><?php echo $column_price; ?></th>
          <th align="center" style="padding-right:20px;"><?php echo $column_total; ?></th>
		  <?php } ?>
        </tr>
        <?php $class = 'odd'; ?>
        <?php foreach ($products as $product) { ?>
        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
        <tr class="<?php echo $class; ?>">
          <td align="center"><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></td>
          <td align="left" valign="top"><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" class="nomeProduto"><?php echo $product['name']; ?></a>
            <?php if (!$product['stock']) { ?>
            <span style="color: #990000; font-weight: bold;">***</span>
            <?php } ?>
            <div>
              <?php foreach ($product['option'] as $option) {
              $product['estoque'] = $option['quantity'] ?>
              <small style="color:#999"><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
              <?php } ?>
            </div></td>
          <td align="center" valign="top" style="color:#666"><?php echo $product['model']; ?></td>
          <td align="center" valign="top">
          <?php  
          if($product['estoque'] > 0)
          {?>
          <select onchange="$('#cart').submit();" name="quantity[<?php echo $product['key']; ?>]">
          <?       
          
            $qtNum = 1;
            
            if($product['estoque'] > 10)
            $product['estoque'] = 10;
            
            $stock = $product['estoque'];
            
            while ($qtNum <= $stock):
            
                if($qtNum==$product['quantity'])
                    $selected = "selected";
                else
                    $selected = "";
                    
            print '<option value="'.$qtNum.'" '.$selected.' >'.$qtNum.'</option>';  
            
                $qtNum++;
                
            endwhile;
          ?>
          </select>
          <?php 
          }
          else
          {
          print "Indisponivel";
          }
          ?>
          
          </td>
          <td align="center">
 
 <?php 
 $product['key'] = str_replace(":","_",$product['key']);
 ?>
 
           <a onclick="deletaProduto('<?=$product['key']?>')" ><img src="catalog/view/theme/<?=TEMPLATE?>/image/list_remove_btn.gif" /></a>
<input type="checkbox" name="remove[<?php echo $product['key'];?>]" id="remove<?php echo $product['key'];?>" style="visibility:hidden">


          
          </td>
          <?php  if ($display_price) { ?>
		  <td align="center" valign="top" style="color:#333"><?php echo $product['price']; ?></td>
          <td align="center" valign="top"  style="padding-right:20px; color:#333"><?php echo $product['total']; ?></td>
		  <?php } ?>
        </tr>
        <?php } ?>
      </table>

	  <?php if ($display_price) { ?>
	  <div style="width: 100%; display: inline-block;">
        <table style="float: right; display: inline-block;">
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td align="right"  style="padding-right:20px; color:#666"><?php echo $total['title']; ?></td>
            <td align="right"  style="padding-right:20px; color:#2f2f2f; font-size:14px"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
        </table>
        <br />
      </div>
	  <?php } ?>
      
  </div>

      
            <!-- td align="left"><a onclick="$('#cart').submit();" class="button"><span><?php echo $button_update; ?></span></a></td-->
            <p style="float:left;margin-top:10px"><a onclick="location = '<?php echo str_replace('&amp;', '&', $continue); ?>'" class="button"><span><?php echo $button_shopping; ?></span></a></p>
            <p  style="float:right;margin-top:10px"><a onclick="location = '<?php echo str_replace('&amp;', '&', $checkout); ?>'" class="button checkoutArmazem" ><span><?php echo $button_checkout; ?></span></a></p>
          </tr>
        </table>

    </form>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
  
  <?
  }
  ?>
  
</div>

<?php echo $footer; ?> 