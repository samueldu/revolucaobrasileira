<?php echo $header; ?><?php echo $column_left; ?>
<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css"
      xmlns="http://www.w3.org/1999/html"/>

<div class="escandalos">

<!--table border="1" width=100%>
    <tr>
        <td><h2>Enquanto isso <?=conector?> <?=estado_nome?></h2></td>
    </tr>
</table-->

<div class="inner-content">
<h1>Políticos do Brasil</h1>
<!--div class="share-holder">
  <div class="badges">
    <div class="dislikes"></div>
  </div>
  <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Frevolucaobrasileira.com.br&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font=arial&amp;height=21&amp;appId=143585905741403" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px; margin-left:20px; margin-top:5px;" allowTransparency="true"></iframe>
</div-->

<!--em class="date"><?=$politicos[0]['data']?></em-->

<!------------------  BUSCA -------------------->

<div class="busca_politico">
<form name="form" id="form">
<input type="text" name="nome" id="nome" class="none" placeholder="Ex.  Valdemar Costa Neto ">

<!--select id="cargo" name="cargo">
                <option selected="selected" value="Senador_1">Senador</option>
                <option value="Deputado Federal_1">Deputado Federal</option>
                <option value="Deputado Estadual_1">Deputado Estadual</option>
                <option value="Governador_1">Governador</option>
                <option value="Presidente_1">Presidente</option>
            </select-->

<select id="casa" name="casa">
  <option value=0>Todas as casas</option>
  <?

foreach($casas as $key=>$value)
                {
                ?>
  <option value="<?=$casas[$key]['casaId']?>">
  <?=$casas[$key]['casaNome']."-".$casas[$key]['casaUf']?>
  </option>
  <?
}
?>
</select>
<select id="estado" name="estado">
  <option value=0>Todos</option>
  <?

foreach($estados as $key=>$value)
                {
                ?>
  <option value="<?=$estados[$key]['uf_codigo']?>">
  <?=$estados[$key]['uf_descricao']?>
  </option>
  <?
}
?>
</select>
<select id="partido" name="partido">
  <option value=0>Todos</option>
  <?

foreach($partidos as $key=>$value)
                {
                ?>
  <option value="<?=$partidos[$key]['partidoId']?>">
  <?=$partidos[$key]['partidoNome']?>
  </option>
  <?
}
?>
</select>
<select id="resultsPage" name="resultsPage">
  <option value=100>100</option>
  <option value=200>200</option>
  <option value=500>500</option>
</select>
<input type="button" onclick="javascript:processa('0');" value="Buscar" name="Buscar" class="button ">
<div name="pagination" id="pagination"> </div>
<div name="politicos" id="politicos" class="lista_politicos"> </div>
</div>
<!------------------  FIM BUSCA -------------------->


<?

foreach($politicos as $chaveinicial=>$valuexxx)
{
    if($chaveinicial == "Assembleia Legislativa")
    $nome = " do ".estado_nome;
else
    $nome = "";
?>

    <div class="envolvidosnovo">
        <div class="users" style="width: 100%"><h3><?=$chaveinicial.$nome?></h3>
            <hr class="fancy-line"></hr>
        </div>
    
        <?
    
        foreach($politicos[$chaveinicial] as $key=>$value)
        {
    
        ?>
    
        <div class="users">
            <a  href="politico/politico/rank?rank=<?=$key?>"><h4 class="subtitulo"><?=$key?></h4></a>
                <ul>
                    <?
                    $i = 0;
                    foreach($politicos[$chaveinicial][$key] as $chave=>$valor)
                    {
                    $i = $i+1;

                    if($i > 5)
                    break;

                    ?>
                    <li class="active"><div class="photo"><a href="politico/politico?politicoid=<?=$politicos[$chaveinicial][$key][$chave]['id']?>"><img src="<?=$politicos[$chaveinicial][$key][$chave]['thumb']?>" alt="<?=$politicos[$chaveinicial][$key][$chave]['apelido']?>" title="<?=$politicos[$chaveinicial][$key][$chave]['apelido']?>"/></a></div><strong><?=($i."º")?> <a href="politico/politico?politicoid=<?=$politicos[$chaveinicial][$key][$chave]['id']?>"><?=$politicos[$chaveinicial][$key][$chave]['apelido']?></a></strong> </li>
                    <?
                    }
                    ?>
                    </ul>
    
        </div>
    
        <?
        }

    ?>

    </div>

<?
}
?>



<!--div class="casos-semelhantes">

            <h3>Negativados</h3>

            <div class="caso">

                <?
                foreach($politicos['deslike'] as $key=>$value)
                {
                print "<tr><td><img src=".$politicos['deslike'][$key]['thumb'].">
                <A href=politico/politico?politicoid=".$politicos['deslike'][$key]['id'].">".$politicos['deslike'][$key]['nome']."</a></td></tr>";
                }
                ?>
                <Tr><Td><b><a href="politico/politico/rank?rank=deslike">veja mais</a>

                <h5><a href="conteudo/corrupcao?corrupcao_id=<?=$casos_semelhantes[$key]['id']?>"><?=$casos_semelhantes[$key]['titulo']?></a></h5>
                <strong><?=$casos_semelhantes[$key]['data']?></strong>
                <span><a href="#"><?=$casos_semelhantes[$key]['descricao']?>...</a></span>
            </div>

            <div class="caso" style="float: right;">
                <h5> <a href="conteudo/corrupcao/lista">Veja a lista completa >>></a></h5>
            </div>

        </div-->



</div>

<div class="envolvidosnovo">
    <div class="users">
        <h3>Bancadas</h3>
        <ul>
            <?
              $i = 0;
                foreach($bancada as $key=>$value)
            {
            $i = $i+1;
            ?>
            <li class="active"><a href="politico/bancada?idGrupo=<?=$bancada[$key]['id']?>"><?=$bancada[$key]['descricao']?></a> </li>
            <?
							}
							?>
        </ul>
    </div>
</div>

</div>
<!-- escandalos --> 

<?php echo $column_right; ?>

<?php echo $footer ?>

<script>

$("form").bind("keypress", function (e) {
	if (e.keyCode == 13) {  
		processa('0'); 
		return false;
	}
});



	function processa(page)
	{
		if(page==0)
		page = 1;

		$.ajax({
		
			type: 'POST',
			url: 'index.php?route=ajax/ajax/getPoliticos',
			dataType: 'json',
			data: 'nome=' + encodeURIComponent($("#nome").val()) + '&partidoId=' + encodeURIComponent($("#partido").val()) + '&ufId=' + encodeURIComponent($("#estado").val()) + '&page='+page+'&resultsPage='+ encodeURIComponent($("#resultsPage").val())+'&casaId='+encodeURIComponent($("#casa").val()),
			beforeSend: function() {
				$('.success, .warning').remove();
				$('#review_button').attr('disabled', 'disabled');
				$('#review_title').after('<div class="wait"><img src="catalog/view/theme/<?=TEMPLATE?>/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
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
					$('#politicos').html(imprime(data.politicos));
					$('#pagination').html(data.pagination);                   
				}
			}
		});
	}


	function imprime(result)
	{
		var str;
		
		str = '<ul>'
		
		for (var i = 0; i < result.length; i++) { 
			str += '<li><div class="img_politico"><img src='+result[i].thumb+' alt='+result[i].nome+' title='+result[i].nome+'></div><a href=politico/politico?politicoid='+result[i].id+'>'+result[i].nome+'</a> <a class="partido_right">'+result[i].partidoNome+'</a></div>';
		}
		
		str += "</ul>";
		
		return str;
	}
</script>