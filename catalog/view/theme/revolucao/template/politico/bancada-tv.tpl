<?php echo $header; ?>

<?php echo $column_left; ?>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>

<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<!-- Additional files for the Highslide popup effect -->
<script type="text/javascript" src="http://www.highcharts.com/highslide/highslide-full.min.js"></script>
<script type="text/javascript" src="http://www.highcharts.com/highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="http://www.highcharts.com/highslide/highslide.css" />

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<Script>
    $(function () {

        // Register a parser for the American date format used by Google
        Highcharts.Data.prototype.dateFormats['m/d/Y'] = {
            regex: '^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2})$',
            parser: function (match) {
                return Date.UTC(+('20' + match[3]), match[1] - 1, +match[2]);
            }
        };

        // Get the CSV and create the chart
        $.get('http://www.highcharts.com/samples/highcharts/demo/line-ajax/analytics.csv', function (csv) {

            $('#container').highcharts({

                data: {
                    csv: csv
                },

                title: {
                    text: 'Daily visits at www.highcharts.com'
                },

                subtitle: {
                    text: 'Source: Google Analytics'
                },

                xAxis: {
                    type: 'datetime',
                    tickInterval: 7 * 24 * 3600 * 1000, // one week
                    tickWidth: 0,
                    gridLineWidth: 1,
                    labels: {
                        align: 'left',
                        x: 3,
                        y: -3
                    }
                },

                yAxis: [{ // left y axis
                    title: {
                        text: null
                    },
                    labels: {
                        align: 'left',
                        x: 3,
                        y: 16,
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0);
                        }
                    },
                    showFirstLabel: false
                }, { // right y axis
                    linkedTo: 0,
                    gridLineWidth: 0,
                    opposite: true,
                    title: {
                        text: null
                    },
                    labels: {
                        align: 'right',
                        x: -3,
                        y: 16,
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0);
                        }
                    },
                    showFirstLabel: false
                }],

                legend: {
                    align: 'left',
                    verticalAlign: 'top',
                    y: 20,
                    floating: true,
                    borderWidth: 0
                },

                tooltip: {
                    shared: true,
                    crosshairs: true
                },

                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function() {
                                    hs.htmlExpand(null, {
                                        pageOrigin: {
                                            x: this.pageX,
                                            y: this.pageY
                                        },
                                        headingText: this.series.name,
                                        maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+
                                                this.y +' visits',
                                        width: 200
                                    });
                                }
                            }
                        },
                        marker: {
                            lineWidth: 1
                        }
                    }
                },

                series: [{
                    name: 'All visits',
                    lineWidth: 4,
                    marker: {
                        radius: 4
                    }
                }, {
                    name: 'New visitors'
                }]
            });
        });

    });


</Script>

<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css"
      xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"/>



<!--link rel="stylesheet" type="text/css" href="aciTree/css/demo.css" media="all" /-->
<!--script src="../js/jquery.min.js" type="text/javascript"></script>
<script src="<?=URL_JAVASCRIPT?>aciTree/js/jquery.aciPlugin.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=URL_JAVASCRIPT?>aciTree/css/aciTree.css" media="all" />
<script type="text/javascript" src="<?=URL_JAVASCRIPT?>aciTree/js/jquery.aciTree.min.js"></script-->

<div class="escandalos">


    <div class="inner-content">

        <h1><?=$titulo?></h1>

        <div class="share-holder">
            <div class="badges">
            </div>

        </div>

        <!--em class="date"><?=$politicos[0]['data']?></em-->

        <div class="basic-text">
            <h3></h3>
            <p>Alguns dizem 6 outros 9 e até quem diga 11 famílias controlam a mídia nacional. Atualmente temos cerca de 60 parlamentares que são investidores, donos ou ligados a redes de rádio e TV. Apesar de não se reconhecerem como uma bancada esses parlamentares formam um grupo numeroso quando se tem em mente o número reduzido de pessoas que controlam a "grande mídia" mas a maioria desses parlamentares são donos de pequenas rádios locais.

                A questão se esses parlamentares tem vantagem para se eleger pode ser analisada na tabela referente ao primeiro turno de 2010:  <BR>
                <img src="<?=HTTP_IMAGE?>data/tabela_2010.jpg"> <BR>

               <i> Parlamentares concessionários de rádio e TV tiveram um índice de reeleição alto.        </i><BR><BR>

                A relação entre o alto nível de reeleição desses parlamentares e o fato de serem concessionários é discutida por muitos e ja existe discurssões na Câmara <a href=="http://www2.camara.leg.br/camaranoticias/noticias/COMUNICACAO/193798-LEI-DE-COMUNICACOES:-INFLUENCIA-DA-BANCADA-DE-RADIODIFUSAO-DIVIDE-OPINIOES.html">sobre a inelegibilidade</a> de quem se enquadrar nessa categoria. Sem dúvida essa discussão não possui o mérito que merece em nossa sociedade visto a sua importância e complexidade Mas de maneira análoga, pode-se imaginar que qualquer parlmamentar com acesso a recursos financeiros possa conseguir bons resultados nas urnas.

                Como podemos observar nos números a seguir referente ao uso de verbas indenizatórias para divulgação de atividade parlamentar:

            <div id="containerx" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

            a tarefa é

            <BR><BR>Estatisticas<BR><BR>
                Dos  <?=$estatisticas['numero']?> integrantes da Bancada Evangélica, <? print $estatisticas['numero']-$estatisticas['numProcZero']; ?> (<? print $estatisticas['numPorcentagem']?>) somam <?=$estatisticas['numProc']?> processos judiciais. <br>
                Os processos em questão envolvem acusações como peculato (furto ou apropriação de bens ou valores públicos), improbidade administrativa, corrupção eleitoral, abuso de poder econômico, sonegação fiscal e formação de quadrilha. <BR>
                <BR>A porcentagem de políticos "não evangélicos" que respondem a processos judiciais é de <?=$estatisticas['numPorcentagemTotal']?>.</p>
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

<script>

    /*

    $(function() {

        // tree with #2 columns: type/size (read from JSON itemData)

        $('#tree1,#tree2').aciTree({
            jsonUrl: 'ajax/ajax/verbasDivulgacao',
            fullRow: true,
            // define the columns
            columnData: [{
                props: 'type'
            }, {
                props: 'size'
            }]

        }).on('acitree', function(event, api, item, eventName, options) {

                    // tell what tree it is
                    var index = ($(this).attr('id') == 'tree1') ? 0 : 1;

                    switch (eventName) {

                        case 'init':

                            // at init open the first folder
                            api.open(api.first(), {
                                success: function(item) {
                                    if (index == 0) {
                                        // select first file for #tree1
                                        this.select(this.first(item), {
                                            select: true
                                        });
                                    } else {
                                        // select second file for #tree2
                                        this.select(this.next(this.first(item)), {
                                            select: true
                                        });
                                    }
                                }

                            });

                            // set focus so we can use the keyboard already
                            $('#tree1').focus();

                            break;

                        case 'selected':

                            // show image when selected
                            var image = $('.image').eq(index);

                            if (api.isFile(item)) {
                                image.html('<img src="aciTree/images' + api.getId(item) + '" border="0" alt="" />');
                            } else {
                                image.html('please select a file');
                            }

                            break;
                    }

                });

    });
    */

</script>

<script>

    /*

    $(function () {
        // Get the CSV and create the chart
        $.get('http://www.highcharts.com/samples/highcharts/demo/line-ajax/analytics.csv', function (csv) {

            $('#container').highcharts({

                data: {
                    csv: csv
                },

                title: {
                    text: 'Daily visits at www.highcharts.com'
                },

                subtitle: {
                    text: 'Source: Google Analytics'
                },

                xAxis: {
                    type: 'datetime',
                    tickInterval: 7 * 24 * 3600 * 1000, // one week
                    tickWidth: 0,
                    gridLineWidth: 1,
                    labels: {
                        align: 'left',
                        x: 3,
                        y: -3
                    }
                },

                yAxis: [{ // left y axis
                    title: {
                        text: null
                    },
                    labels: {
                        align: 'left',
                        x: 3,
                        y: 16,
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0);
                        }
                    },
                    showFirstLabel: false
                }, { // right y axis
                    linkedTo: 0,
                    gridLineWidth: 0,
                    opposite: true,
                    title: {
                        text: null
                    },
                    labels: {
                        align: 'right',
                        x: -3,
                        y: 16,
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0);
                        }
                    },
                    showFirstLabel: false
                }],

                legend: {
                    align: 'left',
                    verticalAlign: 'top',
                    y: 20,
                    floating: true,
                    borderWidth: 0
                },

                tooltip: {
                    shared: true,
                    crosshairs: true
                },

                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function() {
                                    hs.htmlExpand(null, {
                                        pageOrigin: {
                                            x: this.pageX,
                                            y: this.pageY
                                        },
                                        headingText: this.series.name,
                                        maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+
                                                this.y +' visits',
                                        width: 200
                                    });
                                }
                            }
                        },
                        marker: {
                            lineWidth: 1
                        }
                    }
                },

                series: [{
                    name: 'All visits',
                    lineWidth: 4,
                    marker: {
                        radius: 4
                    }
                }, {
                    name: 'New visitors'
                }]
            });
        });

    });

    */


</script>

<?php echo $column_right; ?>

<?php echo $footer ?>