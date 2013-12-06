<?php echo $header; ?>

<?php echo $column_left; ?>

<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>

<script type="text/javascript" src="<?=DIR_JS?>accordion/jquery.easing.1.3.js"></script>

<script type="text/javascript" src="<?=DIR_JS?>accordion/script.js"></script>


<div class="escandalos">

    <div class="inner-content">

        <h1>Corrupção no Brasil</h1>

        <div class="share-holder">
            <div class="badges">
                                   <div class="dislikes"><?=$politicos[0]['like']?></div>
                               </div>
                               <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Frevolucaobrasileira.com.br&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font=arial&amp;height=21&amp;appId=143585905741403" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px; margin-left:20px; margin-top:5px;" allowTransparency="true"></iframe>

        </div>

        <!--em class="date"><?=$politicos[0]['data']?></em-->

        <div class="basic-text">
            <!--h4>R$ 100 bilhões anuais</h4-->
            <p>O que o Brasil perde exatamente com a corrupção é incalculável, porém estímasse cifras em torno de 1,38% a 2,3% do PIB, isto é, de <a href="http://www.bbc.co.uk/portuguese/noticias/2012/11/121031_corrupcao_numeros_mdb.shtml" target="_blank"> R$ 50,8 bilhões a R$ 84,5 bilhões por ano</a>
                O grande problema é que tendemos a ver a corrupção política como algo totalmente à parte da sociedade, como se fossem "os políticos corruptos lá e eu aqui". <BR>
                A nossa representatividade política nada mais é do que uma amostragem social e o que vemos é isso: o brasileiro muitas vezes é corrupto ou tem grande tolerância a corrupção alheia. Ser silente diante da corrupção alheia é praticamente ser corrupto também. <BR>
                <br>O estilo de vida que compartilhamos, completamente centrado no capital, é propenso a desvios morais mas se ampliar-mos de forma revolucionária a <a href="politico/politico/rank?rank=transparencia">transparência governamental</a> e trabalhar-mos com vigilância esses números irão diminuir.
                <BR><BR>O objetivo deses ranking é enumerar os políticos que estão em exercício ou que estavam até recentemente e que ficaram famosos, dentre outros motivos, por se envolverem em grandes escândalos de corrupção.<BR><BR>
                <!--div id="counter" name="counter">3270</div-->

            <!--Em 2012, quase 3 mil casos de corrupção e improbidade prescreveram por falta de julgamento.

            As causas desses problemas moral e a tolerância do povo brasileiro são de difícil compreensão podem basear-se num sistema que-->

            </p>

            <ul class="container">

                <?
                    $i = 0;
							foreach($politicosRank[0]['personagens'] as $key=>$value)
                {
                $i = $i+1;
                ?>

                <li class="menu"> <!-- This LI is positioned inside the main UL -->

                    <ul>

                        <!-- The click-able section title with a unique background: -->
                        <li class="button"><a href="#" class="green"><img src="<?=$politicosRank[0]['personagens'][$key]['thumb']?>"/><span class="info_principais"><?=($i."º")?> -  <?=$politicosRank[0]['personagens'][$key]['apelido']?><div><?=$politicosRank[0]['personagens'][$key]['partidoNome']?></div></span></a>
                        <a class="ver_perfil" href="politico/politico?politicoid=<?=$politicosRank[0]['personagens'][$key]['id']?>">Ficha completa</a> </li>

                        <li class="dropdown">
                           <div class="dropdown_cargo">
                           		<span class="font_destaque">Cargo:</span> <?=$politicosRank[0]['personagens'][$key]['politicoCargoRelevante']?><br />
                           		<span class="font_destaque">Bancada:</span> <a href="#">Ruralista</a> 
                           </div>
                           <div class="dropdown_passado">
                           		<span class="font_destaque">Passado:</span> <?=$politicosRank[0]['personagens'][$key]['politicoOutrosDados']?>
                           </div>
			               <div class='destaque01 destaque02'><a href='politico/politico/rank?rank=processos' tittle='Ranking de uso de verbas' class='rank'></a><span class='percentual'>50</span><span class='text1'>Está entre os<br>com mais processos<br>na justiça</div>
			               <div class='destaque01 destaque02'><a href='politico/politico/rank?rank=bens' tittle='Ranking Declaração de Bens' class='rank'></a><span class='percentual'>12ª</span><span class='text3'><span class='text2'>Maior</span><br>declaração de bens.</span></div>
						
                        </li>

                    </ul>

                </li>
                <?
							}
							?>

        </div>

       <!--div class="basic-text">
        <h4>Sobr</h4>
        <p> </p>
        </div-->

        <div class="envolvidos">

            <div class="users">
                <ul>
                    <?
                    $i = 0;
							foreach($politicosRank[0]['personagens'] as $key=>$value)
                    {
                    $i = $i+1;
                    ?>

                    <li class="active">
                        <div class="photo"><img src="<?=$politicosRank[0]['personagens'][$key]['thumb']?>"/></div>
                        <strong><?=($i."º")?> - <?=$politicosRank[0]['personagens'][$key]['apelido']?> </strong>
                        <em><?=$politicosRank[0]['personagens'][$key]['partidoNome']?>

                            <A href="politico/politico?politicoid=<?=$politicosRank[0]['personagens'][$key]['id']?>">Veja o perfil</a>
                        </em>

                    </li>
                    <?
							}
							?>
                </ul>

                    <h5> <a href="politico/politico/rank?rank=corrupcao">Veja a rank completo >>></a></h5>


            </div>

            <div class="users-content">
                <?
						foreach($politicosRank[0]['personagens'] as $key=>$value)
                {
                ?>
                <div class="text">
                    <p><?=$politicosRank[0]['personagens'][$key]['politicoCargoRelevante']?></p>

                    <p><?=$politicosRank[0]['personagens'][$key]['politicoOutrosDados']?></p>

                    <A href="politico/politico?politicoid=<?=$politicosRank[0]['personagens'][$key]['id']?>">Veja o perfil</a>



                </div>
                <?
				}
				?>

            </div><!-- users content -->


        </div><!-- envolvidos -->

        <div class="casos-semelhantes">

            <h3>Você se lembra?</h3>

            <?
                        foreach($casos_semelhantes as $key=>$value)
            {
            ?>

            <div class="caso">
                <h5><a href="conteudo/corrupcao?corrupcao_id=<?=$casos_semelhantes[$key]['id']?>"><?=$casos_semelhantes[$key]['titulo']?></a></h5>
                <strong><?=$casos_semelhantes[$key]['data']?></strong>
                <span><a href="#"><?=$casos_semelhantes[$key]['descricao']?>...</a></span>
            </div>
            <?
                        }
                        ?>

            <div class="caso" style="float: right;">
                <h5> <a href="conteudo/corrupcao/lista">Veja a lista completa >>></a></h5>
                </div>

        </div>



        <div class="frases-marcantes">

            <h3>Direto dos anais</h3>

            <?
						foreach($frases as $key=>$value)
            {
            ?>
            <div class="frase">
                <h5><?=$frases[$key]['frase']?></h5>
                <em><?=$frases[$key]['explicacao']?>. <a href="conteudo/corrupcao?corrupcao_id=<?=$frases[$key]['corrupcaoId']?>">Veja mais</a></em>
                <div class="badges">
                    <div class="likes"><?=$frases[$key]['like']?></div>
                    <div class="dislikes"><?=$frases[$key]['deslike']?></div>
                </div>
            </div>
            <?
						}
						?>
        </div>

    </div><!-- innercontent -->



</div><!-- escandalos -->

<script>
function counter() {
add = 100000000000/(31536000);
var count = parseInt($('#counter').text());
var newx = count + add;
var result = newx.toFixed(0);
$('#counter').text(result);
}

setInterval(counter, 1000);

    function loadPolitico(politicoId)
    {
        $.ajax({
        type: 'POST',
        url: 'corrupcao/corrupcao/getPoliticoCorrupcao?politicoId='+politicoId,
        dataType: 'json',
        beforeSend: function() {
            $('.success, .warning').remove();
            $('#review_button').attr('disabled', 'disabled');
            $('#contactArea').after('<div class="wait">Aguarde...</div>');

            $("#click").click();

        },
        complete: function() {
            $('#review_button').attr('disabled', '');
            $('.wait').remove();
        },
        success: function(data) {
            if (data['error']) {
            $('#contactArea').html('<div class="warning_venda">' + data.error + '</div>');
        }

        if (data.success) {
            $('#contactArea').after('<div class="success">' + data.success + '</div>');
        }
        }
        });
    }
</script>

<?php echo $column_right; ?>

<?php echo $footer ?>