<?php echo $header; ?>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?=URL_JAVASCRIPT?>tagit/css/jquery.tagit.css">
<link href="<?=URL_JAVASCRIPT?>tagit/css/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">  
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script> 
<script src="<?=URL_JAVASCRIPT?>tagit/js/tag-it.js" type="text/javascript" charset="utf-8"></script>

<style>
    .image-selector { width:100px; }

    .news-list-containerfoto {
        height: 120px;
        width: 700px;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
    }

    .news-list-item {
        border: 1px solid #E5E5E5;
        height: 120px;
        padding: 5px;
        width: 110px;

        display: inline-block;
        /* for ie7 */
        *display: inline;
        zoom: 1;
    }
</style>

<form id="data" method="post" enctype="multipart/form-data">

</form>

<script>
	$(function(){
		var sampleTags = [
		'Paulo Maluf', 
		'Corrup��o', 
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
		<!--tr>
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
		  </tr-->

    <tr>
        <td><?php echo 'Categoria'; ?></td>
        <td><select name="blog_category" id="blog_category">
                <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo $category['category_id']; ?>" /><?php echo $category['name']; ?></option>

                <?php } ?>
            </select><BR><BR></td>
    </tr>

		  <tr>
			<td><?php echo 'Titulo'; ?></td>
			<td><input type="text" id="titulo" name="titulo" size="40"></td>
		  </tr>
		  <tr>
			<td><?php echo 'Palavras-chave'; ?></td>
			<td>     
			<p>       
			<input name="tags" id="mySingleField" type="hidden" disabled="false">
			</p>
			<ul id="singleFieldTags" style="width: 250px"></ul></td>
		  </tr>
          <tr>
              <Td>Imagem</Td>
              <td id="imagens">

                  <div class="news-list-containerfoto" id="fotoscontainer">
                      <div class="news-list-item">
                          A
                      </div><div class="news-list-item">
                          B
                      </div><div class="news-list-item">
                          C
                      </div><div class="news-list-item">
                          D
                      </div><div class="news-list-item">
                          E
                      </div><div class="news-list-item">
                          F
                      </div>
                  </div>

              </td>

          </tr>
</table> 
	

<iframe width=100% id="frameeditor" height="400" name="editor" frameborder="0" src="./catalog/view/javascript/editorHTML5/website/index.php">

</iframe>
    <BR><BR>


    <div class="button_loja"><a onclick="envia()" style="cursor:pointer"><span>Enviar</span></a></div>

		<script>

            function seleciona(id)
            {
             //   $('#'+id).css("border","4px solid green");

                $(".image-selector").each(function() {
                    $( this).css("border","");

                    //document.getElementById(id).style.cssText = 'border:4px solid green;';
                });

                document.getElementById(id).style.cssText = 'border:4px solid green;';

            }



                //e.stopPropagation();


                $("#titulo").focusout(function() {

                        $.ajax({
                            type: 'GET',
                            url: 'index.php?route=ajax/ajax/getImages',
                            dataType: 'json',
                            async: false,
                            data: 'titulo=' + encodeURIComponent($('input[name=\'titulo\']').val()) + '&tags='+encodeURIComponent($('input[name=\'tags\']').val()),
                            beforeSend: function() {
                                },
                            complete: function() {
                                $('#review_button').attr('disabled', '');
                                $('.wait').remove();
                            },
                            success: function(data) {
                                if (data.error) {
                                    alert(data.error);
                                }

                                if (data.success) {
                                    document.getElementById('fotoscontainer').innerHTML = data.fotos;
                                    //alert('aquyi');

                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false

                        });
            });

		function envia()
		{

            var count = 0;
            var countImg = 1;
            fotos = [];

            $("img").each(function() {

                if($(this).css('border-bottom-color') == "rgb(0, 128, 0)")
                {
                    count=count+1;
                    fotos[0] = $(this).attr("src");
                }

            })

            if(!fotos[0])
            {
                alert("Selecione uma imagem");
                exit;
            }


            //var formData = new FormData($("form#data")[0]);

			$.ajax({
			type: 'POST',
			url: 'index.php?route=ajax/ajax/gravaPost&',
			dataType: 'html',
			data:{'texto': encodeURIComponent(window.frames[0].document.forms[0].elements[3].value),
			'titulo': encodeURIComponent($('input[name=\'titulo\']').val()),
			'categorias': $('select[id=\'blog_category\']').val(),
			'tags':encodeURIComponent($('input[name=\'tags\']').val()),
			'imagem':fotos},
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


<script>
    $(function() {
        resizeFrame('frameeditor');
    });
</script>