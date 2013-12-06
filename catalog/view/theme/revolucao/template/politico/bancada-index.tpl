<?php echo $header; ?>

<?php echo $column_left; ?>

<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>

<div class="escandalos">


    <div class="inner-content">

        <h1>Bancadas</h1>

        <div class="share-holder">
            <div class="badges">
            </div>
            <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Frevolucaobrasileira.com.br&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font=arial&amp;height=21&amp;appId=143585905741403" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px; margin-left:20px; margin-top:5px;" allowTransparency="true"></iframe>
        </div>

        <!--em class="date"><?=$politicos[0]['data']?></em-->

        <div class="basic-text">
            <h3>Bancadas são agrupamentos de parlamentares que compartilham de interesse comum. </h3>
            <p>
            <?
    foreach($bancada as $key=>$value)
                print "<li><span class='black'>Bancada:</span> <a href='politico/bancada?idGrupo=".$bancada[$key]['id_bancada']."'>".$bancada[$key]['descricao']."</a></li>";
?>
            </p>
        </div>

        <!--div class="envolvidos">

            <div class="users">
                <ul>
                    <?
                    $i = 0;
							foreach($politicosRank[0]['personagens'] as $key=>$value)
                    {

                    if($politicosRank[0]['personagens'][$key]['processos'] != "0")
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
							}
							?>
                </ul>

            </div>

            <div class="users-content" style="height: 1000px">
                <?
						foreach($politicosRank[0]['personagens'] as $key=>$value)
                {

                if($politicosRank[0]['personagens'][$key]['processos'] != "0")
                {



                ?>
                <div class="text">
                    <p><?=$politicosRank[0]['personagens'][$key]['politicoCargoRelevante']?></p>

                    <p><?=$politicosRank[0]['personagens'][$key]['politicoOutrosDados']?></p>

                    <?
                                        if((count($politicosRank[0]['personagens'][$key]['processos']) > 0))
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
                                        }
                                        else
                                        {
                                        ?>
                    <dl><dt>Esse pol�tico n�o possui processos ou eles n�o est�o dispon�veis</dt></dl>
                    <?
                                        }

                                        ?>

                    <A href="politico/politico?politicoid=<?=$politicosRank[0]['personagens'][$key]['politicoId']?>">Veja o perfil</a>



                </div>
                <?
				}
				}
				?>

            </div><!-- users content -->


        </div><!-- envolvidos -->



    </div><!-- innercontent -->



</div><!-- escandalos -->

<?php echo $column_right; ?>

<?php echo $footer ?>