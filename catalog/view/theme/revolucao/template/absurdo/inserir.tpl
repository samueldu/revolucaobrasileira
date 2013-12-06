<?php echo $header; ?>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?=URL_JAVASCRIPT?>tagit/css/jquery.tagit.css">
<link href="<?=URL_JAVASCRIPT?>tagit/css/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">  
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script> 
<script src="<?=URL_JAVASCRIPT?>tagit/js/tag-it.js" type="text/javascript" charset="utf-8"></script>
 
<script>
	$(function(){
		var sampleTags = [
		'Paulo Maluf', 
		'Corrupção', 
		'php', 
		'coldfusion', 
		'javascript', 
		'asp', 
		'ruby', 
		'python', 
		'c', 
		'scala', 
		'groovy', 
		'haskell', 
		'perl', 
		'erlang', 
		'apl', 
		'cobol', 
		'go', 
		'lua'];
		
		$('#singleFieldTags').tagit({      
			availableTags: sampleTags,
			singleField: true,
			singleFieldNode: $('#mySingleField'),
			allowSpaces: true,
			removeConfirmation: true 
	});
});  
</script>

<?php echo $column_left; ?>

<div class="politico">  

<table>
		<tr>
			<td><?php echo 'Categorias'; ?></td>
			<td><div class="scrollbox">
				<?php $class = 'odd'; ?>
				<?php foreach ($categories as $category) { ?>
				<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
				<div class="<?php echo $class; ?>">
				  <?php if (in_array($category['category_id'], $blog_category)) { ?>
				  <input type="checkbox" id="blog_category" name="blog_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
				  <?php echo $category['name']; ?>
				  <?php } else { ?>
				  <input type="checkbox" id="blog_category" name="blog_category[]" value="<?php echo $category['category_id']; ?>" />
				  <?php echo $category['name']; ?>
				  <?php } ?>
				</div>
				<?php } ?>
			  </div></td>
		  </tr>
		  <tr>
			<td><?php echo 'Título'; ?></td>
			<td><input type="text" id="titulo" name="titulo"></td>
		  </tr>
		  <tr>
			<td><?php echo 'palavras-chave'; ?></td>
			<td>     
			<p>       
			<input name="tags" id="mySingleField" value="Apple, Orange" type="hidden" disabled="false"> 
			</p>
			<ul id="singleFieldTags"></ul></td>
		  </tr> 
</table> 
	

<iframe width=100% id="editor" name="editor" height=700 src="<?=URL_JAVASCRIPT?>editorHTML5/website/index.php"></iframe> 

	
		<a href=javascript:envia()>Enviar</a>
		
		<script>
		function envia()
		{	
			$.ajax({
			type: 'POST',
			url: 'index.php?route=ajax/ajax/gravaPost&',
			dataType: 'xml',
			data: 'texto='+encodeURIComponent(window.frames[0].document.forms[0].elements[3].value)+
			'&titulo=' + encodeURIComponent($('input[name=\'titulo\']').val()) + 
			'&categorias='+encodeURIComponent($("#blog_category:checked").serialize()) +  
			'&tags='+encodeURIComponent($('input[name=\'tags\']').val()),                    
			beforeSend: function() {
				$('.success, .warning').remove();
				$('#review_button').attr('disabled', 'disabled');
				$('#review_title').after('<div class="wait"><img src="catalog/view/theme/<?=TEMPLATE?>/image/loading_1.gif" /></div>');
			},
			complete: function() {
				$('#review_button').attr('disabled', '');
				$('.wait').remove();
			},
			success: function(data) {
				if (data.error) {
					$('#review_title').after('<div class="warning">' + data.error + '</div>');
				}
				
				if (data.success) {
					$('#review_title').after('<div class="success">' + data.success + '</div>');
					$('input[name=\'email\']').val('');                
					$('input[name=\'name\']').val('');
					$('input[name=\'address\']').val('');
					$('input[name=\'cep\']').val('');
					$('input[name=\'phone\']').val('');
					$('textarea[name=\'text\']').val('');
				}
			}
		});
		}
		</script>  
		
</div>

<?php echo $column_right; ?>

<?php echo $footer ?>