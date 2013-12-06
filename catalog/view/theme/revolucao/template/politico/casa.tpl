<?php echo $header; ?>

<?php echo $column_left; ?>

<?
foreach($casa_description as $key=>$value)
{  
	print $casa_description[$key]['descricao']." ".$casa_description[$key]['valor']."<BR>";
} 
?>

<?php

$classLike = "";
$onLike = "";
$pref = "";
$onDeslike = "";
$prefDes = "";
$onDeslike = "";
$classDeslike = "";

if(isset($_SESSION['customer_id']))
{

	 if(isset($_SESSION['votos']['like']['casa']) and in_Array($casaId,$_SESSION['votos']['like']['casa']))
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
	 
	 if(isset($_SESSION['votos']['deslike']['politico']) and in_Array($casaId,$_SESSION['votos']['deslike']['politico']))
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

print '<ul><li class="avaliacao">';
				
print '<div id="like'.$casaId.'" class="'.$classLike.'"><a href="javascript:votar('.$casaId.',\''.$pref.'like\',\'casa\')"><img src="catalog/view/theme/revolucao/image/like'.$onLike.'.png"  /></a></div>';
print '<div id="deslike'.$casaId.'" class="'.$classDeslike.'"><a href="javascript:votar('.$casaId.',\''.$prefDes.'deslike\',\'casa\')"><img src="catalog/view/theme/revolucao/image/deslike'.$onDeslike.'.png"  /></a></div>';
print '</li></ul>';
?>

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

function envia()
{

			$.ajax({
			type: 'GET',
			url: 'index.php?route=ajax/ajax/mandaMsgPolitico',
			dataType: 'html',
					data: 'msg='+encodeURIComponent($("textarea#text").val())+'&email='+encodeURIComponent($("input#email").val())+'&userId=<?=$_SESSION['customer_id']?>&politicoId=<?=$politicos[0]['id']?>&politicoEmail='+encodeURIComponent($("input#politicoEmail").val()),    
			beforeSend: function() {
			//    $('.success, .warning').remove();
				//$('#gostei'+id).html('Aguarde...');
	//            $('#review_title').after('<div class="wait"><img src="catalog/view/theme/armazem/image/loading_1.gif" alt="" /> Por favor, aguarde!</div>');
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

}	
</script>

<iframe src="http://192.168.1.2/revolucaobrasileira/site/wall/profile.php?id=<?=$politicos[0]['id']?>&origem=2" width="100%" height="400"></iframe>

<?php echo $column_right; ?>

<?php echo $footer ?>