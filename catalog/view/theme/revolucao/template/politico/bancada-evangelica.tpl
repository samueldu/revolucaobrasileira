<?php echo $header; ?>

<?php echo $column_left; ?>

<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>

<div class="escandalos">


    <div class="inner-content">

        <h1><?=$titulo?></h1>

        <div class="share-holder">
            <div class="badges">
            </div>
            <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Frevolucaobrasileira.com.br&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font=arial&amp;height=21&amp;appId=143585905741403" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px; margin-left:20px; margin-top:5px;" allowTransparency="true"></iframe>
        </div>

        <!--em class="date"><?=$politicos[0]['data']?></em-->

        <div class="basic-text">
            <h3></h3>
            <p>O Brasil é um estado Láico ou Secular. Isso quer dizer que não temos religião declarada e que as religiões vigentes não podem interferir na política nacional. <BR>Mas não é isso que observamos na prática. <BR>
                Muito mais do que a <a href="http://www.youtube.com/watch?feature=player_embedded&v=zVE5zJNALZ0" target="_blank">cena tétrica</a> protagonizada pela <a href=politico/politico?politicoid=70413>Deputada Lauriete</a>
                ou pelo infeliz momento no qual o pastor <a href="politico/politico?politicoid=72575">Marco Feliciano</a> realiza um <a href="http://www.youtube.com/watch?v=_vkoHRj5SYw" target="_blank"> culto relígioso no Congresso Nacional</a>, a Bancada Evangélica representa uma ameaça a nossa liberdade com propostas como a <a href="http://www.camara.gov.br/proposicoesWeb/fichadetramitacao?idProposicao=524259">PEC 99/11</a><BR>
                O constante crescimento da Bancada Evangélica também coloca em cheque a representatividade dos mais de 12 milhões de brasileiros que não possuem religião e distancia o fim da absurda <a href="http://jus.com.br/revista/texto/4179/a-supressao-da-imunidade-tributaria-concedida-aos-cultos-religiosos" target="_blank">imunidade tributária</a> a cultos religiosos.<BR><BR>Estatisticas<BR><BR>
                Dos  <?=$estatisticas['numero']?> integrantes da Bancada Evangélica, <? print $estatisticas['numero']-$estatisticas['numProcZero']; ?> (<? print $estatisticas['numPorcentagem']?>) somam <?=$estatisticas['numProc']?> processos judiciais. <br>
                Os processos em questão envolvem acusações como peculato (furto ou apropriação de bens ou valores públicos), improbidade administrativa, corrupção eleitoral, abuso de poder econômico, sonegação fiscal e formação de quadrilha. <BR>
                <BR>A porcentagem de políticos "não evangélicos" que respondem a processos judiciais é de <?=$estatisticas['numPorcentagemTotal']?>. <BR><BR>As Igrejas representadas são:
                <?
                foreach($estatisticas['igrejas'] as $key=>$value)
                {
                print $key." (".$value."),  ";
                }
                ?>

            </p>
        </div>

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
                        <em><?=$politicosRank[0]['personagens'][$key]['desc']?>

                            <A href="politico/politico?politicoid=<?=$politicosRank[0]['personagens'][$key]['politicoId']?>">Veja o perfil</a>
                        </em>

                    </li>
                    <?
							}

							?>
                </ul>

            </div>

            <div class="users-content" style="height: 1000px">
                <?
						foreach($politicosRank[0]['personagens'] as $key=>$value)
                {





                ?>
                <div class="text">
                    <p><?=$politicosRank[0]['personagens'][$key]['politicoCargoRelevante']?></p>

                    <p><?=$politicosRank[0]['personagens'][$key]['politicoOutrosDados']?></p>

                    <?
                                        if((count($politicosRank[0]['personagens'][$key]['processos']) > 1))
                    {
                    ?>

                    <?
                                        foreach($politicosRank[0]['personagens'][$key]['processos'] as $keyx=>$valuex)
                    {
                    ?>

                    <?=$politicosRank[0]['personagens'][$key]['processos'][$keyx]['descricao']?>

                            <?
                                            if($politicosRank[0]['personagens'][$key]['processos'][$keyx]['link'] != "")
                                            {
                                            print "<a href=".$politicosRank[0]['personagens'][$key]['processos'][$keyx]['link'].">(Veja)</a>";
                                            }
                            ?>
                    <BR><BR>
                    <?
                                        }


                                        ?>

                    <A href="politico/politico?politicoid=<?=$politicosRank[0]['personagens'][$key]['politicoId']?>">Veja o perfil</a>



                <?
				}
				?>
				                </div>
                <?
				}
				?>

            </div><!-- users content -->


        </div><!-- envolvidos -->



    </div><!-- innercontent -->



</div><!-- escandalos -->

<?php echo $column_right; ?>

<?php echo $footer ?>