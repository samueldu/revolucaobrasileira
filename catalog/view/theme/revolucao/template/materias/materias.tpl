<?php echo $header; ?>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script src="<?=URL_TEMPLATE?>../../../javascript/jquery.selected-text-sharer.min.js"></script>

<script>

 $(document).ready(function() {   

	$('.noticia-content').selectedTextSharer({
		lists:"Twitter,http://twitter.com/home?status=%ts ,favicon|Facebook,http://www.facebook.com/sharer.php?t=%s&u=http://google.com,favicon|Wikipedia (en),http://en.wikipedia.org/w/index.php?title=Special:Search&search=%s,favicon|Google Maps,http://maps.google.com/?q=%s,favicon",
		extraClass: 'dark',
		title: 'Share this text ...',
		borderColor: '#00ccff',
		hoverColor: '#FFFFCC'
	});
	
	$('.demo2').selectedTextSharer({
		lists:"Add or remove any items. The format for adding a list is Name URL Icon-URL (Spaces indicate comma). Use %s in the search/share URL for the selected term. Also you can use favicon for the Icon URL to automatically detect the icon",
		title: 'Change everything you want',
		borderColor: '#00ccff',
		hoverColor: '#FFFFCC'
	});
	
	$('.demo3').selectedTextSharer({
		lists:"Email,mailto:?subject=Aakash Web  Just another WordPress weblog&body=%s - http://google.com,http://mail.google.com/favicon.ico|Print,http://www.printfriendly.com/print?url=http://google.com,http://www.printfriendly.com/images/printfriendly.ico|Blogger,http://www.blogger.com/blog_this.pyra?t&u=http://google.com&n=Aakash Web  Just another WordPress weblog&pli=1,favicon|Orkut,http://promote.orkut.com/preview?nt=orkut.com&tt=Aakash Web  Just another WordPress weblog&du=http://google.com&cn=%s,http://orkut.com/favicon.ico|Tumblr,http://www.tumblr.com/share?v=3&u=http://google.com&t=Aakash Web  Just another WordPress weblog&s=%s,favicon|LinkedIn,http://www.linkedin.com/shareArticle?mini=true&url=http://google.com&title=Aakash Web  Just another WordPress weblog&source=Aakash+Web+Just+another+WordPress+weblog&summary=%s,favicon|RSS,http://localhost/wordpress/feed/rss/,favicon|Sphinn,http://sphinn.com/index.php?c=post&m=submit&link=http://google.com,favicon|SphereIt,http://www.sphere.com/search?q=sphereit:http://google.com&title=Aakash Web  Just another WordPress weblog,favicon",
		truncateChars: "115",
		borderColor: "#430070",
		background: "#fff",
		titleColor: "#f2f2f2",
		hoverColor: "#c2f7ff",
		textColor: "#000"
	});
	
	$('.demo4').selectedTextSharer({
		lists:"Wikipedia (en),http://en.wikipedia.org/w/index.php?title=Special:Search&search=%s,favicon|Google Maps,http://maps.google.com/?q=%s,favicon",
		title: 'Search this text ...',
		borderColor: '#009900',
		hoverColor: '#FFFFCC'
	});

 /*
	  $(".text").click(function () {

	  
	  var pId = $(this).attr('id');                                        
	  var materia_id = <?=$politicos[0]['materia_id']?>;
 <?
if(isset($_SESSION['customer_id']))
{
?>
	  
	  var userId = <?=$_SESSION['customer_id']?>;
<?
}
else
{
?>
	  var userId = null;
<?
}
?>
 
		$.ajax({
		type: 'GET',
		url: 'index.php?route=ajax/ajax/mark',
		dataType: 'html',
		data: 'pId='+pId+'&materia_id='+materia_id+'&userId='+userId,    
		beforeSend: function() {
		//    $('.success, .warning').remove();
		//$('#gostei'+id).html('Aguarde...');
		//$('#review_title').after('<div class="wait"><img src="catalog/view/theme/armazem/image/loading_1.gif" alt="" /> Por favor, aguarde!</div>');
		},
		complete: function() {
	//	$('#'+name+id).html('<a href="javascript:votar('+id+',\''+actionback+'\',\''+page+'\')"><img src="catalog/view/theme/revolucao/image/'+name+on+'.png"/></a>');  
		//    $('#'+action+'num'+id).html(parseInt($('#'+action+'num'+id).text())+1);
		//    $('#'+action+'numa'+id).html(parseInt($('#'+action+'numa'+id).text())+1);    
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
		
	  
	  $(this).effect("highlight", {color:"#ffff99",mode:"show"}, 900);
	  
	  */
	  
  //min font size
	var min=9; 
 
	//max font size
	var max=16;
	 
	//grab the default font size
	var reset = $('p').css('fontSize');
	 
	//font resize these elements
	var elm = $('p.text'); 
	 
	//set the default font size and remove px from the value
	var size = str_replace(reset, 'px', '');
	 
	//Increase font size
	$('a.fontSizePlus').click(function() {
		 
		//if the font size is lower or equal than the max value
		if (size<=max) {
			 
			//increase the size
			size++;
			 
			//set the font size
			elm.css({'fontSize' : size});
		}
		 
		//cancel a click event
		return false;  
		 
	});
 
	$('a.fontSizeMinus').click(function() {
 
		//if the font size is greater or equal than min value
		if (size>=min) {
			 
			//decrease the size
			size--;
			 
			//set the font size
			elm.css({'fontSize' : size});
		}
		 
		//cancel a click event
		return false;  
		 
	});
	 
	//Reset the font size
	$('a.fontReset').click(function () {
		 
		//set the default font size
		 elm.css({'fontSize' : reset});    
	});

	  
});

 
 //A string replace function
function str_replace(haystack, needle, replacement) {
	var temp = haystack.split(needle);
	return temp.join(replacement);
}
 
</script>

<?php echo $column_left; ?>

<?
$novoTexto = "";
$tag = "";


foreach($politicos[0] as $key=>$value)
{
	if($key == "texto")
	{				
		preg_match_all('/<p class="text">(.+?)<\/p>/si', $value, $matches); 
					
		$i = 0;
		foreach($matches[0] as $keyx=>$valuex)
		{
		
			$i = $i + 1;
			
			if(isset($marks[$i]))
			{
				$valor = $marks[$i]; 
			}
			else
			{
				$valor = "";
			} 
						
			if(strlen($valuex) <= 57)
			$valuex = "<B>".$valuex."</B>";	
			
			$valuex = str_replace('<p class="text">','<p class="text">',$valuex);

            if(strip_tags($valuex) != "")
			$novoTexto .= $valuex;

		}
		
	}
}
?>

<link href="<?=URL_TEMPLATE?>static/css/noticia.css" rel="stylesheet" type="text/css" />  

<div class="noticia">
			
				<h1 class="title"><?=$politicos[0]['titulo']?></h1>
				<div class="basic-info">
					<span><?=date('d/m/Y',strtotime($politicos[0]['data']))?></span>
					<em>de <strong><a href=materias/materias?jornal_id=<?=$politicos[0]['jornalId']?>><?=$politicos[0]['nome']?></a></strong>, por <?=$politicos[0]['autor']?></em>
					
					<div class="font-size">
						<p><?=$tamanho_da_fonte?></p>
						<a href="#" class="fontSizePlus"> + </a>
						<a href="#" class="fontSizeMinus"> - </a>
					</div>
					
				</div><!-- basic info -->

				<div class="noticia-content">

					<div class="veja-tambem">
						<h4><?=$veja_mais?></h4>
						
						<dl>
						<?
						foreach($veja_tambem as $key=>$value)
						{
							print '<dd><a href="materias/materias?materia_id='.$veja_tambem[$key]['materia_id'].'">'.$veja_tambem[$key]['titulo'].'</a></dd>
							<dt>por <strong><a  href=materias/materias/?jornal_id='.$veja_tambem[$key]['jornalId'].'>'.$veja_tambem[$key]['nome'].'</a></strong> em '.date('d/m/Y',strtotime($veja_tambem[$key]['data'])).'</dt>';
						}
						?>
						</dl>
						
					</div>

					<?=$novoTexto?>

					<?=$politicos[0]['tag']?>
					

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

	 if(isset($_SESSION['votos']['like']['materia']) and in_Array($politicos[0]['materia_id'],$_SESSION['votos']['like']['materia']))
	 {
		$onLike = "on";
		$classLike = "likeon";
		$pref = "un";
	 }
	 else
	 {
		$onLike ="";
		$classLike = "like";
		$pref = "";
	 }
	 
	 if(isset($_SESSION['votos']['deslike']['materia']) and in_Array($politicos[0]['materia_id'],$_SESSION['votos']['deslike']['materia']))
	 {
		$onDeslike = "on";
		$classDeslike = "deslikeon";
		$prefDes = "un";
	 }
	 else
	 {
		$onDeslike ="";
		$classDeslike = "deslike";
		$prefDes = "";
	 }
 
 }


?>
					
					<div class="share-etc">
						
						<a href="javascript:votar(<?=$politicos[0]['materia_id']?>,'<?=$pref?>like','materia')" id="like<?=$politicos[0]['materia_id']?>" class="<?=$classLike?>">Curtiu?</a>
						<a href="javascript:votar(<?=$politicos[0]['materia_id']?>,'<?=$prefDes?>deslike','materia')" id="deslike<?=$politicos[0]['materia_id']?>" class="<?=$classDeslike?>">N�o curtiu?</a>
						<!--a href="#" class="fav">Adicionar aos favoritos</a-->

						<!--div class="facebook">
								<div id="fb-root"></div>
								<script>(function(d, s, id) {
								  var js, fjs = d.getElementsByTagName(s)[0];
								  if (d.getElementById(id)) return;
								  js = d.createElement(s); js.id = id;
								  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=143585905741403";
								  fjs.parentNode.insertBefore(js, fjs);
								}(document, 'script', 'facebook-jssdk'));</script>
								
								<div class="fb-like" data-href="http://facebook.com" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-action="recommend" data-font="arial"></div>
								
						</div-->
						
					</div>
					
				</div><!-- noticia content -->

				<!--h1>Essa semana</h1>
													
				<div class="this-week">
					<div class="content grid three">

						
						<?
						foreach($essa_semana as $key=>$value)
						{
						?>
						<div class="item article">   
							<div class="photo">
								<a href="#"><img src="static/images/banners/trending1.jpg"/></a>
							</div>
							<em><a href="#"><?=utf8_encode("Pol�tica")?></a></em>
							<h3><a href="materias/materias?materia_id=<?=$essa_semana[$key]['materia_id']?>"><?=$essa_semana[$key]['titulo']?></a></h3>
							<span><a href="materias/materias?materia_id=<?=$essa_semana[$key]['materia_id']?>"><?=strip_tags($essa_semana[$key]['texto'])?> ...</a></span>
							
							<div class="badges">
								<div class="likes">307</div>
								<div class="favs">29</div>
							</div>
						</div>
						<?
						}
						?>
						
						<div class="item video">
							<div class="photo">
								<div class="play"></div>
								<a href="#"><img src="static/images/banners/trending1.jpg"/></a>
							</div>
							<em><a href="#">Política</a></em>
							<h3><a href="#">Tortor Sollicitudin Commodo Consectetur Cursus</a></h3>
							<div class="badges">
								<div class="likes">307</div>
								<div class="favs">29</div>
							</div>
						</div>
					</div>
				</div-->

                <?=wall($politicos[0]['materia_id'],3)?>

				</div>
				
				
				




<script>

<?

if(isset($_SESSION['customer_id']))
{
?>
		function votar(id,action,page){
		
		if(action == "deslike")
		{
			var actionback = 'undeslike'; 
			var name = action;
			var on = "on";
			var text = 'Não curtiu';
			var classe = "deslike";
		}
		
		if(action == "like")
		{
			var actionback = 'unlike';
			var name = action;  
			var on = "on"; 
			var text = 'Curtiu'; 
			var classe = "like"; 
				
		}
		
		if(action == "undeslike")
		{
			var actionback = 'deslike';
			var name = actionback;
			var on = ""; 
			var text = 'Não curtiu';
			var classe = "deslike"; 
		}

		if(action == "unlike")
		{
			var actionback = 'like';
			var name = actionback;  
			var on = "";
			var text = 'Curtiu';  
			var classe = "like"; 
		}

		
			$.ajax({
			type: 'GET',
			url: 'index.php?route=ajax/ajax/like',
			dataType: 'html',
					data: 'action='+action+'&page='+page+'&userId=<?=$_SESSION['customer_id']?>&id=<?=$politicos[0]['materia_id']?>',    
			beforeSend: function() {
			//    $('.success, .warning').remove();
			//	  $('#gostei'+id).html('Aguarde...');
	//            $('#review_title').after('<div class="wait"><img src="catalog/view/theme/armazem/image/loading_1.gif" alt="" /> Por favor, aguarde!</div>');
			},
			complete: function() {
				//$('#'+name+id).remove();
				
				$('#'+name+id).replaceWith('<a id='+name+id+' class='+classe+on+' href="javascript:votar('+id+',\''+actionback+'\',\''+page+'\')">'+text+'?</a>');  
			//    $('#'+action+'num'+id).html(parseInt($('#'+action+'num'+id).text())+1);
			//    $('#'+action+'numa'+id).html(parseInt($('#'+action+'numa'+id).text())+1);    
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
function votar(){  
alert("Vc precisa se cadastrar");
}
<?
}
?>        
</script>



<?php echo $column_right; ?>

<?php echo $footer ?>

</div><!-- noticia -->