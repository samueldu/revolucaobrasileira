<?php echo $header; ?>
<?php 

	$dataXau = $dataInicio;
  	$dataInicio = implode(preg_match("~\/~", $dataXau) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $dataXau) == 0 ? "-" : "/", $dataXau)));
  	
  	$dataXau = $dataFim;
  	$dataFim = implode(preg_match("~\/~", $dataXau) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $dataXau) == 0 ? "-" : "/", $dataXau)));

?>

<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/product.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <div id="tabs" class="htabs">
    <a tab="#tab_general"><?php echo $tab_general; ?></a>
    <a tab="#tab_image"><?php echo $tab_image; ?></a></div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab_general">
        <div id="language">
          <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><input type="text" name="name" value="<?php echo $name; ?>" />
              <?php if ($error_name) { ?>
              <span class="error"><?php echo $error_name; ?></span>
              <?php } ?></td>
          </tr>  
          <tr>
            <td><span class="required">*</span> <?php echo $entry_url; ?></td>
            <td><input type="text" name="url" value="<?php echo $url; ?>" /></td>
          </tr>  
          <tr>
            <td><span class="required">*</span> <?php echo $entry_dataIni; ?></td>
            <td><input type="text" name="dataInicio" value="<?php echo $dataInicio; ?>" /></td>
          </tr>  
          <tr>
            <td><span class="required">*</span> <?php echo $entry_dataFim; ?></td>
            <td><input type="text" name="dataFim" value="<?php echo $dataFim; ?>" /></td>
          </tr>  
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="status">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr> 
          <tr>
            <td><?php echo $entry_model; ?></td>
            <td><select name="model">
                <?php if ($model) { 
                
                $baixoCheck = '';
                $topoCheck = '';
                                
                	if($model == "topo")
                	$topoCheck = 'selected="selected"';
                	
                	if($model == "baixo")
                	$baixoCheck = 'selected="selected"'
                	
                	?>
                
                <option value="topo" <?=$topoCheck?>>topo</option>
                <option value="baixo" <?=$baixoCheck?>>baixo</option>
                <?php } else { ?>
                <option value="topo">topo</option>
                <option value="baixo">baixo</option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_category; ?></td>
            <td><div class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php foreach ($categories as $category) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                  <?php if (in_array($category['category_id'], $product_category)) { ?>
                  <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                  <?php echo $category['name']; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" />
                  <?php echo $category['name']; ?>
                  <?php } ?>
                </div>
                <?php } ?>
              </div></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="2" /></td>
          </tr>
          
          </table>
        </div>
      </div>
      <div id="tab_image">
        <table id="images" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_image; ?></td>
              <td></td>
            </tr>
          </thead>
          <?php $image_row = 0; ?>
          <?php foreach ($product_images as $product_image) { ?>
          <tbody id="image_row<?php echo $image_row; ?>">
            <tr>
              <td class="left"><input type="hidden" name="product_image[<?php echo $image_row; ?>]" value="<?php echo $product_image['file']; ?>" id="image<?php echo $image_row; ?>"  />
                <img src="<?php echo $product_image['preview']; ?>" alt="" id="preview<?php echo $image_row; ?>" class="image" onclick="image_upload('image<?php echo $image_row; ?>', 'preview<?php echo $image_row; ?>');" /></td>
              <td class="left"><a onclick="$('#image_row<?php echo $image_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
            </tr>
          </tbody>
          <?php $image_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td></td>
              <td class="left">
              <?php 
              if(!$image_row)
              {
              ?>
                        
              <a onclick="addImage();" id="addRow" class="button"><span><?php echo $button_add_image; ?></span></a>
              <?php 
              }
              ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script>
<script type="text/javascript"><!--
function addRelated() {
	$('#product :selected').each(function() {
		$(this).remove();
		
		$('#related option[value=\'' + $(this).attr('value') + '\']').remove();
		
		$('#related').append('<option value="' + $(this).attr('value') + '">' + $(this).text() + '</option>');
		
		$('#product_related input[value=\'' + $(this).attr('value') + '\']').remove();
		
		$('#product_related').append('<input type="hidden" name="product_related[]" value="' + $(this).attr('value') + '" />');
	});
}

function removeRelated() {
	$('#related :selected').each(function() {
		$(this).remove();
		
		$('#product_related input[value=\'' + $(this).attr('value') + '\']').remove();
	});
}

function getProducts() {
	$('#product option').remove();
	
	$.ajax({
		url: 'index.php?route=catalog/product/category&token=<?php echo $token; ?>&category_id=' + $('#category').attr('value'),
		dataType: 'json',
		success: function(data) {
			for (i = 0; i < data.length; i++) {
	 			$('#product').append('<option value="' + data[i]['product_id'] + '">' + data[i]['name'] + ' (' + data[i]['model'] + ') </option>');
			}
		}
	});
}

function getRelated() {
	$('#related option').remove();
	
	$.ajax({
		url: 'index.php?route=catalog/product/related&token=<?php echo $token; ?>',
		type: 'POST',
		dataType: 'json',
		data: $('#product_related input'),
		success: function(data) {
			$('#product_related input').remove();
			
			for (i = 0; i < data.length; i++) {
	 			$('#related').append('<option value="' + data[i]['product_id'] + '">' + data[i]['name'] + ' (' + data[i]['model'] + ') </option>');
				
				$('#product_related').append('<input type="hidden" name="product_related[]" value="' + data[i]['product_id'] + '" />');
			} 
		}
	});
}

getProducts();
getRelated();
//--></script>
<script type="text/javascript"><!--
$('#option').bind('change', function() {
	$('.option').hide();
	
	$('#' + $('#option option:selected').attr('value')).show();
});

$('#option option:first').attr('selected', 'selected');

$('#option').trigger('change');
//--></script>
<script type="text/javascript"><!--							 
var option_row = <?php echo $option_row; ?>;

function addOption() {	
	html  = '<div id="option' + option_row + '" class="option">';
	html += '<table class="form">';
	html += '<tr>';
	html += '<td><?php echo $entry_option; ?></td>';
	html += '<td>';
	<?php foreach ($languages as $language) { ?>
	<?php if ($language['language_id'] == $language_id) { ?>
	html += '<input type="text" name="product_option[' + option_row + '][language][<?php echo $language['language_id']; ?>][name]" value="Option ' + option_row + '" onkeyup="$(\'#option option[value=\\\'option' + option_row + '\\\']\').text(this.value);" />&nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
	<?php } else { ?>
	html += '<input type="text" name="product_option[' + option_row + '][language][<?php echo $language['language_id']; ?>][name]" value="Option ' + option_row + '" />&nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
	<?php } ?>
	<?php } ?>
	html += '</td>';
	html += '</tr>';
	html += '<tr>';
	html += '<td><?php echo $entry_sort_order; ?></td>';
	html += '<td><input type="text" name="product_option[' + option_row + '][sort_order]" value="" size="2" /></td>';
	html += '</tr>';
	html += '<tr>';
	html += '<td colspan="2"><a onclick="addOptionValue(\'' + option_row + '\');" class="button"><span><?php echo $button_add_option_value; ?></span></a> <a onclick="removeOption(\'' + option_row + '\');" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '</tr>';
	html += '</table>';
	html += '</div>';
		 
	$('#options').append(html);
	
	$('#option').append('<option value="option' + option_row + '"><?php echo $text_option; ?> ' + option_row + '</option>');
	$('#option option[value=\'option' + option_row + '\']').attr('selected', 'selected');
	$('#option').trigger('change');

	option_row++;
}

function removeOption(option_row) {
	$('#option option[value=\'option' + option_row + '\']').remove();
	$('#option option[value^=\'option' + option_row + '_\']').remove();
	
	$('#options div[id=\'option' + option_row + '\']').remove();
	$('#options div[id^=\'option' + option_row + '_\']').remove();
}

var option_value_row = <?php echo $option_value_row; ?>;

function addOptionValue(option_id) {
	html  = '<div id="option' + option_id + '_' + option_value_row + '" class="option">';
	html += '<table class="form">';
	html += '<tr>';
	html += '<td><?php echo $entry_option_value; ?></td>';
	html += '<td>';
	<?php foreach ($languages as $language) { ?>
	<?php if ($language['language_id'] == $language_id) { ?>
	html += '<input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][language][<?php echo $language['language_id']; ?>][name]" value="Option Value ' + option_value_row + '" onkeyup="$(\'#option option[value=\\\'option' + option_id + '_' + option_value_row + '\\\']\').text(\'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\' + this.value);" />&nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
	<?php } else { ?>
	html += '<input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][language][<?php echo $language['language_id']; ?>][name]" value="Option Value ' + option_value_row + '" />&nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
	<?php } ?>	
	<?php } ?>
	html += '</td>';
	html += '</tr>';
	html += '<tr>';
	html += '<td><?php echo $entry_quantity; ?></td>';
	html += '<td><input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][quantity]" value="' + '" size="2" /></td>';	
	html += '</tr>';
	html += '<tr>';
	html += '<td><?php echo $entry_subtract; ?></td>';
	html += '<td><select name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][subtract]">';
    html += '<option value="1"><?php echo $text_yes; ?></option>';
    html += '<option value="0"><?php echo $text_no; ?></option>';
    html += '</select></td>';
	html += '</tr>';
	html += '<tr>';
	html += '<td><?php echo $entry_price; ?></td>';
	html += '<td><input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][price]" value="" /></td>';
	html += '</tr>';
	html += '<tr>';	
	html += '<td><?php echo $entry_prefix; ?></td>';
	html += '<td><select name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][prefix]">';
	html += '<option value="+"><?php echo $text_plus; ?></option>';
	html += '<option value="-"><?php echo $text_minus; ?></option>';
	html += '</select></td>';
	html += '</tr>';
	html += '<tr>';	
	html += '<td><?php echo $entry_sort_order; ?></td>';	
	html += '<td><input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][sort_order]" value="" size="2" /></td>';
	html += '</tr>';
	html += '<tr>';		
	html += '<td colspan="2"><a onclick="removeOptionValue(\'' + option_id + '_' + option_value_row + '\');" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '</tr>';
	html += '</table>';
	html += '</div>';
	
	$('#options').append(html);
	
	option = $('#option option[value^=\'option' + option_id + '_\']:last');
	
	if (option.size()) {
		option.after('<option value="option' + option_id + '_' + option_value_row + '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $text_option_value; ?> ' + option_value_row + '</option>');
	} else {
		$('#option option[value=\'option' + option_id + '\']').after('<option value="option' + option_id + '_' + option_value_row + '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $text_option_value; ?> ' + option_value_row + '</option>');
	}
	
	$('#option option[value=\'option' + option_id + '_' + option_value_row + '\']').attr('selected', 'selected');
	
	$('#option').trigger('change');
	
	option_value_row++;
}

function removeOptionValue(option_value_row) {
	$('#option option[value=\'option' + option_value_row + '\']').remove();
	
	$('#option' + option_value_row).remove();
}
//--></script>
<script type="text/javascript"><!--
var discount_row = <?php echo $discount_row; ?>;

function addDiscount() {
	html  = '<tbody id="discount_row' + discount_row + '">';
	html += '<tr>'; 
    html += '<td class="left"><select name="product_discount[' + discount_row + '][customer_group_id]" style="margin-top: 3px;">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
    <?php } ?>
    html += '</select></td>';		
    html += '<td class="left"><input type="text" name="product_discount[' + discount_row + '][quantity]" value="" size="2" /></td>';
    html += '<td class="left"><input type="text" name="product_discount[' + discount_row + '][priority]" value="" size="2" /></td>';
	html += '<td class="left"><input type="text" name="product_discount[' + discount_row + '][price]" value="" /></td>';
    html += '<td class="left"><input type="text" name="product_discount[' + discount_row + '][date_start]" value="" class="date" /></td>';
	html += '<td class="left"><input type="text" name="product_discount[' + discount_row + '][date_end]" value="" class="date" /></td>';
	html += '<td class="left"><a onclick="$(\'#discount_row' + discount_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '</tr>';	
    html += '</tbody>';
	
	$('#discount tfoot').before(html);
		
	$('#discount_row' + discount_row + ' .date').datepicker({dateFormat: 'yy-mm-dd'});
	
	discount_row++;
}
//--></script>
<script type="text/javascript"><!--
var special_row = <?php echo $special_row; ?>;

function addSpecial() {
	html  = '<tbody id="special_row' + special_row + '">';
	html += '<tr>'; 
    html += '<td class="left"><select name="product_special[' + special_row + '][customer_group_id]">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
    <?php } ?>
    html += '</select></td>';		
    html += '<td class="left"><input type="text" name="product_special[' + special_row + '][priority]" value="" size="2" /></td>';
	html += '<td class="left"><input type="text" name="product_special[' + special_row + '][price]" value="" /></td>';
    html += '<td class="left"><input type="text" name="product_special[' + special_row + '][date_start]" value="" class="date" /></td>';
	html += '<td class="left"><input type="text" name="product_special[' + special_row + '][date_end]" value="" class="date" /></td>';
	html += '<td class="left"><a onclick="$(\'#special_row' + special_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '</tr>';
    html += '</tbody>';
	
	$('#special tfoot').before(html);
 
	$('#special_row' + special_row + ' .date').datepicker({dateFormat: 'yy-mm-dd'});
	
	special_row++;
}
//--></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.draggable.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.resizable.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.dialog.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/external/bgiframe/jquery.bgiframe.js"></script>
<script type="text/javascript"><!--
function image_upload(field, preview) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + preview).replaceWith('<img src="' + data + '" alt="" id="' + preview + '" class="image" onclick="image_upload(\'' + field + '\', \'' + preview + '\');" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 700,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;
var image_row2 = 0;

function addImage() {

		image_row = 0;
		
	    html  = '<tbody id="image_row' + image_row + '">';
		html += '<tr>';
		html += '<td class="left"><input type="hidden" name="product_image[' + image_row + ']" value="" id="image' + image_row + '" /><img src="<?php echo $no_image; ?>" alt="" id="preview' + image_row + '" class="image" onclick="image_upload(\'image' + image_row + '\', \'preview' + image_row + '\');" /></td>';
		html += '<td class="left"><a onclick="$(\'#image_row' + image_row  + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
		html += '</tr>';
		html += '</tbody>';
		
		$('#images tfoot').before(html);
		
		image_row2++;
}
//--></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.datepicker.js"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script type="text/javascript"><!--
$.tabs('#tabs a'); 
$.tabs('#languages a'); 
//--></script>
<?php echo $footer; ?>