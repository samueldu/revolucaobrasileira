<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
<div class="heading">
	 <h1 style="background-image: url('view/image/module.png');"><?php echo $heading_title; ?></h1>
	<div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
</div>
<div id="tabs" class="htabs"><a tab="#tab_general"><?php echo $tab_general; ?></a><a tab="#tab_data"><?php echo $tab_data; ?></a><a tab="#tab_links"><?php echo $tab_link; ?></a></div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <div id="tab_general" class="page">
	<table class="form">
	<tr>
			<td width="25%"><?=$author_name; ?></td>
			<td><?=$author; ?></td>
	</tr>
	<tr>
		<td width="25%"><span class="required">*</span> <?php echo $entry_url; ?></td>
		<td><input size="75" name="url" value="<?php echo isset($url) ? $url : ''; ?>" />
	</tr>
	  <?php foreach ($languages as $language) { ?>
	  <tr>
		<td width="25%"><?php echo $entry_status; ?></td>
		<td><select name="status">
			<option value="published" <?php echo ($status == "published") ? "selected" : ""; ?>><? echo $blog_published; ?></option>
			<option value="draft" <?php echo ($status == "draft") ? "selected" : ""; ?>><? echo $blog_draft; ?></option>
			</select>
	  </tr>
	<?php if ($error_subject) { ?>
		<tr class="warning"><td colspan='2'><?php echo $error_subject; ?></td></tr>
	<?php } ?>
	  <tr>
		<td width="25%"><span class="required">*</span> <?php echo $entry_subject; ?></td>
		<td><input size="75" name="subject" value="<?php echo isset($subject) ? $subject : ''; ?>" />
	  </tr>
	  <?php if ($error_content) { ?>
		<tr class="warning"><td colspan='2'><?php echo $error_resumo; ?></td></tr>
	  <?php } ?>
	  <tr>
		<td><span class="required">*</span> <?php echo $entry_resumo; ?></td>
		<td><textarea name="resumo" id="resumo<?php echo $language['language_id']; ?>"><?php echo isset($resumo) ? $resumo : ''; ?></textarea>
		  <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
	  </tr>
	<?php if ($error_content) { ?>
		<tr class="warning"><td colspan='2'><?php echo $error_content; ?></td></tr>
	<?php } ?>
	  <tr>
		<td><span class="required">*</span> <?php echo $entry_content; ?></td>
		<td><textarea name="content" id="description<?php echo $language['language_id']; ?>"><?php echo isset($content) ? $content : ''; ?></textarea>
		  <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
	  </tr>
	  <?php } ?>
	  
	  <tr>
	  <td colspan=2>
	  
			<?php foreach ($languages as $language) { ?>
		<div id="language<?php echo $language['language_id']; ?>">
		  <table class="form">
		  <tr>
			  <td><?php echo $entry_meta_keywords; ?></td>
			  <td><textarea name="blog_description[<?php echo $language['language_id']; ?>][meta_keywords]" cols="40" rows="5"><?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['meta_keywords'] : ''; ?></textarea>           <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
			</tr>
			<tr>
			  <td><?php echo $entry_meta_description; ?></td>
			  <td><textarea name="blog_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['meta_description'] : ''; ?></textarea>           <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
			</tr>
			<tr>
			  <td><?php echo $entry_description; ?></td>
			  <td><textarea name="blog_description[<?php echo $language['language_id']; ?>][description]" cols="40" rows="5" id="description<?php echo $language['language_id']; ?>"><?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['description'] : ''; ?></textarea>           <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
			</tr>
		</table>
		</div>
		<?php } ?>
	  
	  </tr>
	  </td>
	  
	</table>
  </div>
  <div id="tab_data" class="page">
	<table class="form">
		<tr>
			<td><?php echo $entry_youtube; ?></td>
			<td><input type="text" name="youtube" value="<?php echo isset($youtube)?$youtube:''; ?>" size="60" /></td>
			<td><?php echo $entry_video_destaque; ?></td>
			<td><input type="checkbox" name="video_destaque" value="1" <?php echo (isset($video_destaque) && $video_destaque == 1)?"checked='checked'":''; ?> /></td>
		</tr>
		<tr>
			<td>Repasse de negocios</td>
			<td><input type="checkbox" name="repasse" value="1" <?php echo (isset($repasse) && $repasse == 1)?"checked='checked'":''; ?>></td>
			<td>Pontos comerciais</td>
			<td><input type="checkbox" name="pontos" value="1" <?php echo (isset($pontos) && $pontos == 1)?"checked='checked'":''; ?>></td>
		</tr>
	</table>
	<table id="images" class="list">
		  <thead>
			<tr>
			  <td class="left"><?php echo $entry_image; ?></td>
			  <td></td>
			</tr>
		  </thead>
		  <?php $image_row = 0; ?>
		  <?php foreach ($news_images as $news_image) { ?>
		  <tbody id="image_row<?php echo $image_row; ?>">
			<tr>
			  <td class="left"><input type="hidden" name="news_image[<?php echo $image_row; ?>]" value="<?php echo $news_image['file']; ?>" id="image<?php echo $image_row; ?>"  />
				<img src="<?php echo $news_image['preview']; ?>" alt="" id="preview<?php echo $image_row; ?>" class="image" onclick="image_upload('image<?php echo $image_row; ?>', 'preview<?php echo $image_row; ?>');" /></td>
			  <td class="left"><a onclick="$('#image_row<?php echo $image_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
			</tr>
		  </tbody>
		  <?php $image_row++; ?>
		  <?php } ?>
		  <tfoot>
			<tr>
			  <td></td>
			  <td class="left"><a onclick="addImage();" class="button"><span><?php echo $button_add_image; ?></span></a></td>
			</tr>
		  </tfoot>
		</table>
  </div>
  <div id="tab_links" class="page">
	<table>
		<tr>
			<td><?php echo $entry_category; ?></td>
			<td><div class="scrollbox">
				<?php $class = 'odd'; ?>
				<?php foreach ($categories as $category) { ?>
				<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
				<div class="<?php echo $class; ?>">
				  <?php if (in_array($category['category_id'], $blog_category)) { ?>
				  <input type="checkbox" name="blog_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
				  <?php echo $category['name']; ?>
				  <?php } else { ?>
				  <input type="checkbox" name="blog_category[]" value="<?php echo $category['category_id']; ?>" />
				  <?php echo $category['name']; ?>
				  <?php } ?>
				</div>
				<?php } ?>
			  </div></td>
		  </tr>
		  
		  <?
		  if(isset($user_id_product))
		  print "<input type=\"hidden\" name=\"product_id\" value=\"".$user_id_product."\">";
		  else
		  {
		  ?>
		  
		  <tr>
			<td><?php echo $entry_franquia; ?></td>  
			
			<td><select name="product_id">
				<?php foreach ($products as $product) { ?>
				<?php if ($product['product_id'] == $product_id) { ?>
				<option value="<?php echo $product['product_id']; ?>" selected="selected"><?php echo $product['name']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></option>
				<?php } ?>
				<?php } ?>
			  </select></td>
		  </tr>
		  <?
		  }
		  ?>
		  
	</table>
  </div>
</form>
<br />
<div class="success"><? echo $footblog;?></div>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.draggable.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.resizable.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.dialog.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('resumo<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'}
	);

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
$.tabs('#tabs a');
//--></script>
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

function addImage() {
	html  = '<tbody id="image_row' + image_row + '">';
	html += '<tr>';
	html += '<td class="left"><input type="hidden" name="news_image[' + image_row + ']" value="" id="image' + image_row + '" /><img src="<?php echo $no_image; ?>" alt="" id="preview' + image_row + '" class="image" onclick="image_upload(\'image' + image_row + '\', \'preview' + image_row + '\');" /></td>';
	html += '<td class="left"><a onclick="$(\'#image_row' + image_row  + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '</tr>';
	html += '</tbody>';
	
	$('#images tfoot').before(html);
	
	image_row++;
}
//--></script>
<?php echo $footer; ?>
