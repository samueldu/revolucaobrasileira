<?php echo $header; ?>

<?php echo $column_left; ?>

<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<!-- Additional files for the Highslide popup effect -->
<script type="text/javascript" src="http://www.highcharts.com/highslide/highslide-full.min.js"></script>
<script type="text/javascript" src="http://www.highcharts.com/highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="http://www.highcharts.com/highslide/highslide.css" />

<Script>
    $(function () {
        // Register a parser for the American date format used by Google
        Highcharts.Data.prototype.dateFormats['d/m/Y'] = {
            regex: '^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2})$',
            parser: function (match) {
                return Date.UTC(+('20' + match[3]), match[1] - 1, +match[2]);
            }
        };

        $.get('/revolucaobrasileira/rb/ajax/ajax/mediaVerbas', function (csv) {

            $('#containerx').highcharts({

                data: {
                    csv: csv
                },

                chart:{
                    margin: ['165', 0, 0, 0]
                },

                title: {
                    text: 'Categorização do uso de verbas idenizatórias'
                },

                subtitle: {
                    text: 'Fonte: http://www2.camara.leg.br ¹</a>'
                },

                xAxis: {
                    type: 'datetime',
                    tickInterval: 24 * 3600 * 1000*365, // one week
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
                        x: 15,
                        y: 16,
                        formatter: function() {
                            return 'R$ '+Highcharts.numberFormat(this.value, 0);
                        }
                    },
                    showFirstLabel: false
                }, { // right y axis
                    linkedTo: 0,
                    gridLineWidth: 0,
                    opposite: false,
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
                    layout: 'horizontal',
                    align: 'right',
                    verticalAlign: 'top',
                    y: 70,
                    x:-150,
                    floating: false,
                    borderWidth: 0
                },

                tooltip: {
                    shared: false,
                    crosshairs: true,
                    valuePrefix: 'R$ '
                },

                navigation: {
                    buttonOptions: {
                        enabled: false
                    }
                },

                /*

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
                                        maincontentText: Highcharts.dateFormat('%b de %Y', this.x) +':<br/> '+
                                                this.y +' visits',
                                        width: 400
                                    });
                                }
                            }
                        },
                        marker: {
                            lineWidth: 1
                        }
                    }
                },
                */
                series: [
                    {
                        name: 'Alimentação e hospedagem',
                        visible: false
                    },
                    {
                        name: 'Assinatura de publicações',
                        visible: false
                    },
                    {
                        name: 'Combustíveis e locação de carros e barcos',
                        visible: false
                    },
                    {
                        name: 'Consultorias'
                    },
                    {
                        name: 'Divulgação de atividade parlamentar'
                    },
                    {
                        name: 'Gastos com escritório'
                    },
                    {
                        name: 'Locomoção alimentação e hospedagem'
                    },
                    {
                        name: 'Passagens aéreas e fretamentos de aeronaves'
                    },
                    {
                        name: 'Segurança',
                        visible: false
                    },
                    {
                        name: 'Serviços postais',
                        visible: false
                    },
                    {
                        name: 'Telefonia'
                    }
                ]

            });
        });

    });

    var highchartsOptions = Highcharts.setOptions({
                lang: {
                    loading: 'Aguarde...',
                    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                    shortMonths: ['Jan', 'Feb', 'Mar', 'Abr', 'Maio', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    exportButtonTitle: "Exportar",
                    printButtonTitle: "Imprimir",
                    rangeSelectorFrom: "De",
                    rangeSelectorTo: "Até",
                    rangeSelectorZoom: "Periodo",
                    downloadPNG: 'Download imagem PNG',
                    downloadJPEG: 'Download imagem JPEG',
                    downloadPDF: 'Download documento PDF',
                    downloadSVG: 'Download imagem SVG'
                    // resetZoom: "Reset",
                    // resetZoomTitle: "Reset,
                    // thousandsSep: ".",
                    // decimalPoint: ','
                }
            }
    );
</Script>

<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>

<div class="escandalos">


    <div class="inner-content">

        <h1><?=$titulo?></h1>    <BR><BR>

        A verba indenizatória do exercício parlamentar é uma verba pública mensal, destinada aos membros de um parlamento, seja ele em nível municipal, estadual ou nacional, para ressarcimento das despesas relacionadas ao exercício do mandato.
        Os valores não utilizados ficam acumulados para o mês seguinte, durante o prazo de um semestre o que explica algumas inconstâncias na distribuição dos gastos.<BR><BR>
        O Brasil é conhecido internacionalmente, a muitos tempo, como um dos países de maior custo parlamentar do mundo.<BR><BR><BR>

        <!--iframe width="100%" height="360" src="http://www.youtube.com/embed/whcMuMvCLuA" frameborder="0" allowfullscreen></iframe-->

        <div id="containerx" style="min-width: 100%; height: 500px; float:left; margin: 0 auto"></div>

        <!--em class="date"><?=$politicos[0]['data']?></em-->

        <div class="basic-text">
            <h3></h3>
            <p></p>
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
                        <em><?=$politicosRank[0]['personagens'][$key]['partidoNome']?>

                            <A href="politico/politico?politicoid=<?=$politicosRank[0]['personagens'][$key]['id']?>">Veja o perfil</a>
                        </em>

                    </li>
                    <?
							}
							?>
                </ul>

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

        <BR>Referências:<BR><BR>
        1 - <a href=http://www2.camara.leg.br/transparencia/cota-para-exercicio-da-atividade-parlamentar/dados-abertos-cota-parlamentar>http://www2.camara.leg.br/transparencia/cota-para-exercicio-da-atividade-parlamentar/dados-abertos-cota-parlamentar</a><BR><BR>




    </div><!-- innercontent -->

</div><!-- escandalos -->

<?php echo $column_right; ?>

<?php echo $footer ?>
