<?php echo $header; ?>   

<?php echo $column_left; ?>   

<?
$classLike = "";
$onLike = "";
$pref = "";
$onDeslike = "";
$prefDes = "";
$onDeslike = "";
$classDeslike = "";

if(isset($_SESSION['customer_id']))
{

	 if(isset($_SESSION['votos']['like']['poderes']) and in_Array($politicos[0]['id'],$_SESSION['votos']['like']['poderes']))
	 {
		$onLike = "-on";
		$classLike = "gosteion";
		$pref = "un";
	 }
	 else
	 {
		$onLike ="";
		$classLike = "gostei";
		$pref = "";
	 }
	 
	 if(isset($_SESSION['votos']['deslike']['poderes']) and in_Array($politicos[0]['id'],$_SESSION['votos']['deslike']['poderes']))
	 {
		$onDeslike = "-on";
		$classDeslike = "gosteion";
		$prefDes = "un";
	 }
	 else
	 {
		$onDeslike ="";
		$classDeslike = "gostei";
		$prefDes = "";
	 }
 
}
?>

<link href="<?=URL_TEMPLATE?>static/css/politico.css" rel="stylesheet" type="text/css" /> 
			
<div class="politico">   
			<div class="wall">   
					
					<h1 class="name"><?=$politicos[0]['nome']?> - <?=$politicos[0]['cargo']?></h1><BR>

					<div class="badges">
						
						<div class="likes"><?=$politicos[0]['like']?></div>
						<div class="dislikes"><?=$politicos[0]['deslike']?></div>
						<div class="comments">123</div>
						<div class="trend">123</div>
						
					</div>
					<!-- badges -->
									  
					<!-- share -->  
					<div class="share">
						<div class="facebook">
							<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fglobo.com&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
						</div>
						
						<div class="twitter">
							<a href="https://twitter.com/share" class="twitter-share-button" data-lang="pt">Tweetar</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
						</div>
						
					</div>
					<!-- share -->
					
					<!-- bio -->  
					<div class="bio">
					
						<p>

					</div>
					<!-- bio -->  

					<!-- content -->
					<div class="container">
					
						<div class="item news">
							<h3><?=$noticias_txt?></h3>
							
							<?
							foreach($materias as $key=>$value)
							{
							?>
							<dl>
								<dt><a href="#"><a href="materias/materias?materia_id=<?=$materias[$key]['id']?>"><?=$materias[$key]['titulo']?></a></dt>
								<dd><a href="#"><?=$materias[$key]['nome']?> em <?=$materias[$key]['data']?></a></dd>
							</dl>
							<?
							}
							?>
							<div class="see-more">
								<a href="#"><?=$veja_mais_txt?></a>
							</div>
							
						</div>
						<!-- item -->

					</div>
					<!-- container -->
					
					
					<!--h2>Comentários</h2-->
					
					<link href="catalog/view/javascript/facebox/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
					<link href="catalog/view/javascript/facebox/examples/css/example.css" media="screen" rel="stylesheet" type="text/css" />
					<script src="catalog/view/javascript/facebox/src/facebox.js" type="text/javascript"></script>
					<script type="text/javascript">
						jQuery(document).ready(function($) {
						  $('a[rel*=facebox]').facebox({
							loadingImage : 'catalog/view/javascript/facebox/src/loading.gif',
							closeImage   : 'catalog/view/javascript/facebox/src/closelabel.png'
						  })
						})
					  </script>
					  
					  <?
					//  print_R($_SERVER);
					//  include("G:/projeto/VertrigoServ224/www/revolucaobrasileira/site/wall/profile.php");
					  ?>
					
					<iframe border=0 src="<?=BASE_URL?>wall/profile.php?id_wall=<?=$politicos[0]['id']?>&origem=5" width="700" height="800"></iframe>
					
										

				</div>
				
				<!-- wall -->

				<div class="picture">
					<div class="photo">
						<img src="<?=HTTP_IMAGE?>data/fotos/<?=$politicos[0]['avatar']?>">
					</div>
					<?
					if(isset($frases[0]['frase']))
					{
					?>
					<em><?=$frases[0]['frase']?><BR><?=$frases[0]['explicacao']?> 
					<?
					}
					?>
					<? 
					if(isset($frases[0]['corrupcaoId']) and $frases[0]['corrupcaoId'] != "")
					{
					?>
					<BR><?=$saiba_mais_txt?>: <a href="conteudo/corrupcao?corrupcao_id=<?=$frases[0]['corrupcaoId']?>"><?=$frases[0]['nome']?></a>
					<?
					}
					?>
					</em>
				</div>
				<!-- wall -->
			</div><!-- politico -->
		 </div><!-- content -->
	</div><!-- #main -->
  <BR>
  
  


<?php echo $column_right; ?>

<?php echo $footer ?>

<script>

<?

if(isset($_SESSION['customer_id']))
{
?>
		function votar(id,action,page){
		
		alert(action);
		
		if(action == "deslike")
		{
		var actionback = 'undeslike'; 
		var name = action;
		var on = "-on";
		}
		
		if(action == "like")
		{
		var actionback = 'unlike';
		var name = action;  
		var on = "-on";     
		}
		
		if(action == "undeslike")
		{
		var actionback = 'deslike';
		var name = actionback;
		var on = "";    
		}

		if(action == "unlike")
		{
		var actionback = 'like';
		var name = actionback;  
		var on = "";
		}
		
	//	alert(actionback);

			$.ajax({
			type: 'GET',
			url: 'index.php?route=ajax/ajax/like',
			dataType: 'html',
					data: 'action='+action+'&page='+page+'&userId=<?=$_SESSION['customer_id']?>&id=<?=$politicos[0]['id']?>',    
			beforeSend: function() {
			//    $('.success, .warning').remove();
				$('#gostei'+id).html('Aguarde...');
	//            $('#review_title').after('<div class="wait"><img src="catalog/view/theme/armazem/image/loading_1.gif" alt="" /> Por favor, aguarde!</div>');
			},
			complete: function() {
				$('#'+name+id).html('<a href="javascript:votar('+id+',\''+actionback+'\',\''+page+'\')"><img src="catalog/view/theme/revolucao/image/'+name+on+'.png"/></a>');  
			//	$('#'+action+'num'+id).html(parseInt($('#'+action+'num'+id).text())+1);
			//	$('#'+action+'numa'+id).html(parseInt($('#'+action+'numa'+id).text())+1);    
			   // $('.wait').remove();
			},
			success: function(data) {
				if (data.error) {
			//        $('#review_title').after('<div class="warning">' + data.error + '</div>');
				}
				
				if (data.success) {
			  //      $('#review_title').after('<div class="success">' + data.success + '</div>');
				}
			}
		});
		}
		
<?
}
else
{
?>
function like(){  
alert("Vc precisa se cadastrar");
}
<?
}
?>
</script>