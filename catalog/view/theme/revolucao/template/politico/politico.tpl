<?php echo $header; ?>
<link href="<?=URL_TEMPLATE?>static/css/politico.css" rel="stylesheet" type="text/css" />
<link href="<?=URL_TEMPLATE?>static/css/tabs.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?=DIR_CSS?>prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="<?=DIR_JS?>jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script src="catalog/view/javascript/grafico/js/highcharts.js"></script>
<script src="catalog/view/javascript/grafico/js/modules/data.js"></script>
<?php echo $column_left; ?>
<script src="<?=URL_JAVASCRIPT?>jquery.hashchange.js" type="text/javascript"></script>
<!--script src="<?=URL_JAVASCRIPT?>jquery.easytabs.js" type="text/javascript"></script-->
<script type="text/javascript" src="catalog/view/javascript/tinybox2/tinybox.js"></script>
<link rel="stylesheet" href="catalog/view/javascript/tinybox2/style.css">


<script>
    function openBox(urlEnviada)
    {
        TINY.box.show({url:urlEnviada,boxid:'frameless',animate: true, mask:true, maskid:"bluemask", fixed:true,maskopacity:0});
    }
</script>

<!--script type="text/javascript">
    $(function () {
                $('#containerx').highcharts({
                    chart: {
                        type: 'line',
                        marginRight: 130,
                        marginBottom: 25,
                        zoomType: 'x'
                    },

                    title: {
                        text: 'Verbas idenizatórias',
                        x: -20 //center
                    },
                    /*
                    subtitle: {
                        text: 'Source: WorldClimate.com',
                        x: -20
                    },
                    */
                    xAxis: {

                            <?php
                            $categorias = "";
                foreach($verbasGrafico as $key=>$value)
                {
                    $categorias .= "'".$key."',";
                }
                $categorias = substr($categorias,0,-1);
                ?>

                categories: [<?=$categorias?>],
                //tickInterval: 24*3600*1000
            },
            yAxis: {
        title: {
            text: 'R$'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },
    tooltip: {
        valuePrefix: 'R$ '
    },
    legend: {
        layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
    },
    series: [{
        name: 'Valor por mês',
            <?php
            $valoresx = "";
    foreach($verbasGrafico as $key=>$value)
    {
        $valoresx.= "".$value.",";
    }
    $valoresx = substr($valoresx,0,-1);
    ?>

    data: [<?=$valoresx?>]
    },
    {

    name: 'Valor médio por mês',

    <?php
            $valoresx = "";
    foreach($mediaVerbasGrafico as $key=>$value)
    {
        $valoresx.= "".$value.",";
    }
    $valoresx = substr($valoresx,0,-1);
    ?>

    data: [<?=$valoresx?>]
    }
    /*, {
        name: 'Berlin',
        data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
    }, {
        name: 'London',
        data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
    }
    */]
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


</script-->

<!--script type="text/javascript" src="http://www.highcharts.com/highslide/highslide-full.min.js"></script>
<script type="text/javascript" src="http://www.highcharts.com/highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="http://www.highcharts.com/highslide/highslide.css" /-->

<?
if($politicos[0]['casaId'] == "1" or $politicos[0]['casaId'] == "2")
  {
  ?>

<Script>
    $(function () {
        // Register a parser for the American date format used by Google
        Highcharts.Data.prototype.dateFormats['d/m/Y'] = {
            regex: '^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2})$',
            parser: function (match) {
                return Date.UTC(+('20' + match[3]), match[1] - 1, +match[2]);
            }
        };

        $.get('index.php?route=politico/politico/mediaVerbasPolitico&politicoId=<?=$politicos[0]['id']?>&casaId=<?=$politicos[0]['casaId']?>', function (csv) {

            $('#containerx').highcharts({

                data: {
                    csv: csv
                },

                title: {
                    text: ''
                },

                subtitle: {
                    text: ''
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
                        x: 3,
                        y: 16,
                        formatter: function() {
                            return 'R$ '+Highcharts.numberFormat(this.value, 0);
                        }
                    },
                    showFirstLabel: false
                }],

                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    y: -20,
                    x:0,
                    floating: true,
                    borderWidth: 0
                },

                tooltip: {
                    shared: true,
                    crosshairs: true,
                    valuePrefix: 'R$ ',
                    yDecimals: 2
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
                                        maincontentText: Highcharts.dateFormat('%b de %Y', this.x) +':<br/> '+
                                                Math.round(this.y) +' visits',
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
                series: [
                    {
                        name: 'Valor gasto',
                        visible: true,

                    },
                    {
                        name: 'Média',
                        visible: true
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
                    downloadSVG: 'Download imagem SVG',
                    // resetZoom: "Reset",
                    // resetZoomTitle: "Reset,
                     thousandsSep: ".",
                     decimalPoint: ','
                }
            }
    );
</Script>
<?
}
?>
<script>

    //jQuery(document).ready(function($) {
  //      $('#tab-container').easytabs({'updateHash':false});
//    });

</script>
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

	 if(isset($_SESSION['votos']['like']['politico']) and in_Array($politicos[0]['id'],$_SESSION['votos']['like']['politico']))
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
	 
	 if(isset($_SESSION['votos']['deslike']['politico']) and in_Array($politicos[0]['id'],$_SESSION['votos']['deslike']['politico']))
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


<div class="politico">
  <div class="wall">
 
      <?

      //print_r($politicos[0]);

					if(!is_null($politicos[0]['badgeBens']) and $politicos[0]['badgeBens'] != "0" and $politicos[0]['badgeBens'] < 50 and $politicos[0]['badgeBens'] != "")
					print "<div class='destaque01 destaque02'><a href='politico/politico/rank?rank=bens' tittle='Ranking Declaração de Bens' class='rank'></a><span class='percentual'>".$politicos[0]['badgeBens']."ª</span><span class='text3'><span class='text2'>Maior</span><br>declaração de bens.</span></div>";
						  	
					if($politicos[0]['badgeProcessos'] < 50 and $politicos[0]['badgeProcessos'] != "0" and $politicos[0]['badgeProcessos'] != "")
					print "<div class='destaque01 destaque02'><a href='politico/politico/rank?rank=processos' tittle='Ranking de uso de verbas' class='rank'></a><span class='percentual'>50</span><span class='text1'>Está entre os<br>com mais processos<br>na justiça</div>";
						
					if($politicos[0]['badgeVerbas'] < 50 and $politicos[0]['badgeVerbas'] != "0" and $politicos[0]['badgeVerbas'] != "")
					print "<div class='destaque01 destaque02'><a href='politico/politico/rank?rank=verbas' tittle='Ranking de uso de verbas' class='rank'></a><span class='percentual'>50</span><span class='text1'>Está entre os <br>com mais uso<br>de verbas!</span></div>";

  if(count($corrupcao) > 0)
  print "<div class='destaque01 destaque02'><a href='politico/politico/rank?rank=corrupcao' tittle='Ranking Declaração de Bens' class='rank'></a><span class='percentual'>!</span><span class='text3'>Envolvimento em casos de <span class='text2'>corrupção</span><br></span></div>";

  ?>
     
    <div class="destaque01"><span class="percentual"><?=$transparencia[0]['rank']?>º</span> <span style=" float:left; padding-top:12px;"><?=$politicos[0]['uf_sigla']?> é o 
      lugar no<br /><a href="politico/politico/rank?rank=transparencia">ranking de transparência</a></span>
    </div>  
    
    <!--h1 class="name"><?=$politicos[0]['apelido']?> - <?=$politicos[0]['partidoNome']?></h1><BR-->
    <?
					if(count($casa_badges)> 0)
						{
							print "EXIJA mais transparência da <a href=politico/politico?casaId=".$politicos[0]['casaId'].">".$politicos[0]['casaNome']."</a>.<BR> Atualmente os seguintes dados não estão disponíveis de forma satisfatória.<BR>";
							foreach($casa_badges as $key=>$value)
							{
								print $casa_badges[$key]['descricao']."<BR>"; 
							}
						}
						else
						{
						?>
    <!--a href=politico/politico?casaId=<?=$politicos[0]['casaId']?>><?=$politicos[0]['casaNome']?></a-->
    <?
						}
						?>
    
    <!-- badges --> 
    <!--div class="share-etc">


                        <a href="javascript:votar(<?=$politicos[0]['id']?>,'<?=$pref?>like','politico')" id="like<?=$politicos[0]['id']?>" class="<?=$classLike?>">Curtiu?</a> <?=$politicos[0]['like']?>
                        <a href="javascript:votar(<?=$politicos[0]['id']?>,'<?=$prefDes?>deslike','politico')" id="deslike<?=$politicos[0]['id']?>" class="<?=$classDeslike?>">Não curtiu?</a> <?=$politicos[0]['deslike']?>

                        <div class="comments">123</div>
						<div class="trend">123</div>

					</div--> 
    <!-- badges --> 
    
    <!-- share --> 
    <!--div class="share">

						
					</div--> 
    
    <!-- share --> 
    
    <!-- bio --> 
    <!--div class="bio">
					<!--a href="#" class="wikipedia">Veja mais na Wikip�dia</a--> 
    <!--?				
                            print '<ul><li class="avaliacao">';                        
                            print '</li></ul>';
                        ?>
                    </div--> 
    <!-- bio -->

  <div class="lista_conteudo_politico"> 

  <!-- - - - - - - - - - - - - -  CASOS CORRUPÇÃO - - - - - - - - - - - - -->
  <h2 class="title_corrupcao">
      <?
							if((count($corrupcao) > 0))
      {
      if((count($corrupcao) > 1))
      {
      print count($corrupcao)." casos de corrupção";
      }
      else
      {
      print count($corrupcao)." Caso de corrupção";
      }
      }
      else
      {
      print "Nenhum caso de corrupção";
      }

      ?>
      <div class="veja_mais"><a class="rank_direita" href="politico/politico/rank?rank=corrupcao"></a></div>
  </h2>
  <?
							if((count($corrupcao) > 0))
  {
  ?>
  <?
							foreach($corrupcao as $key=>$value)
  {
  ?>
  <div class="scroll_red">
  <dl>
      <dd><a href=conteudo/corrupcao?corrupcao_id=<?=$corrupcao[$key]['corrupcaoId']?>>
          <?=$corrupcao[$key]['corrupcaoTitulo']?>
          </a></dd>
  </dl>
  </div>
  <?
							}
							}
							else
							{
							?>
  <div class="dado_indisponivel"> <?=$politicos[0]['apelido']?> não se envolveu em nenhum caso de corrupção ou esse dado não está disponível</div>
  <?
							}
							?>
    
    <!-- - - - - - - - - - - - - -  CITACOES NA JUSTIÇA - - - - - - - - - - - - -->
    <h2 class="title_justice">
      <?
                                if((count($processos) > 0))
                                {
                                ?>
      <?=count($processos)?>
      Citações na justiça
      <?
                                }
                                else
                                {
                                    print "Nenhuma sitação na justiça";
                                }
                                ?>
      <div class="veja_mais"><a class="rank_direita" href="politico/politico/rank?rank=processos"></a></div>
    </h2>
    <div class="scroll_bens scroll_red">
      <?
                                        if((count($processos) > 0))
                                                {
                                                ?>
      <?
                                        foreach($processos as $key=>$value)
                                                {
                                                ?>
      <dl>
        <dd><span style="font-size:12px">
          <?=$processos[$key]['descricao']?>
          </span>
          <?
                                            if($processos[$key]['link'] != "")
                                            {
                                            print "<a target='_blank' class='link_processo' href=".$processos[$key]['link'].">Veja mais</a>";
                                                        }
                                                        ?>
        </dd>
      </dl>
      <?
                                        }
                                        }
                                        else
                                        {
                                        ?>
      <div class="dado_indisponivel">Esse político não possui processos ou eles não estão disponíveis</div>
      <?
                                        }
                                        ?>
    </div>
    
    <!-- - - - - - - - - - - - - -  CITACOES NA JUSTIÇA FIM - - - - - - - - - - - - --> 
    
    <!-- - - - - - - - - - - - - -  ULTIMAS NOTICIAS - - - - - - - - - - - - -->
    
       <h2 class="last_news">Ùltimas notícias de <?=$politicos[0]['apelido']?>
      </h2>
      <div class="scroll_bens" id="scroll_materias">
        <?
                                    if(is_array($materias))
                                    foreach($materias as $key=>$value)
                                    {
                                    ?>
        <dl>
          <dd><a href="#" class="title_news"><a href="materias/materias?materia_id=<?=$materias[$key]['id']?>">
            <?=$materias[$key]['titulo']?>
            </a></dd>
          <dd class="origem_materia"><a href="#">
            <?=$materias[$key]['nome']?>
            <span>em
            <?=$materias[$key]['data']?>
            </span></a></dd>
          <dd class="see-more"><a href="materias/materias">+ Notícias</a></dd>
        </dl>
        <?
                                    }
                                    else
                                    {
                                    ?>
        <div class="dado_indisponivel">Nenhuma matéria sobre
          <?=$politicos[0]['apelido']?>
          .</div>
        <?
                                    }
                                    ?>
      </div>
      <!-- - - - - - - - - - - - - -  ULTIMAS NOTICIAS FIM - - - - - - - - - - - - -->


      <!-- - - - - - - - - - - - - -  BENS - - - - - - - - - - - - -->
      <h2 class="title_bens">Os Bens de <?=$politicos[0]['apelido']?>
        <div class="veja_mais"><a class="rank_direita" href="politico/politico/rank?rank=bens"></a></div>
      </h2>
      <?
                            if($totalBens >  0)
                            {
                            ?>
      <div class="info_complementar"><span class="red">R$
        <?=number_format($totalBens,2,",",".")?>
        </span> <span style="font-size:12px">Total de bens </span>
        <div style="float:right"> <?=$politicos[0]['badgeBens']?> ª <span style="font-size:12px">lugar no raking</span></div>
      </div>
      <div class=" valor_bens_title">Valor do bem</div>
      <div class=" dados_bens_title">Descriminação do bem</div>
      <div class="scroll_bens">
        <?

        foreach($bens as $key=>$value)
        {
        ?>
        <dl>
          <div class="valor_bens">R$ <?=number_format($bens[$key]['valor'],2,",",".")?> </div>
          <div class="dados_bens"> <?=$bens[$key]['bem']?>  </div>
        </dl>
        <?
    }

    ?>
          </div>
      <?

    }
    else
    {
    ?>
        <div class="dado_indisponivel">Bens não disponíveis</div>
    <?
    }
    ?>

      <!-- - - - - - - - - - - - - -  BENS FIM - - - - - - - - - - - - --> 
      
      <!-- - - - - - - - - - - - - -  VERBA INDENIZATÓRIA - - - - - - - - - - - - -->


      <h2 class="title_verba">Uso de verbas indenizatórias
        <div class="veja_mais"><a href="politico/politico/rank?rank=verbas">O QUE SÃO VERBAS INDENIZATÓRIAS?</a></div>
      </h2>

  <?
  if($totalVerbas !=0)
  {
  ?>

  <div class="info_complementar"><span class="red">R$ <?=number_format($totalVerbas,2,",",".")?></span> <span style="font-size:12px">Total acumulado dos ultimos anos </span>
      <div style="float:right"><?=$politicos[0]['badgeVerbas']?> ª <span style="font-size:12px">lugar no raking</span></div>
  </div>


  <?
if($politicos[0]['casaId'] == "1" or $politicos[0]['casaId'] == "2")
  {
  ?>

  <div class="graphic"><div id="containerx" style="min-width: 200px; height: 200px; margin: 0 auto"></div></div>

  <!--/div-->
  <div class="item verbas">

  </div>

  <?
  }
  ?>

  <?
  }
  else
  {
  ?>

  <div class="dado_indisponivel">Dados indisponível no momento. </div>

  <?
  }

  ?>



  <?
                                if(isset($verbas))
                                {
                                    ?>
                                    <?
                                    $totalVerbas = 0;

                                    foreach($verbas as $key=>$value)
                                    {
                                        $totalVerbas = $verbas[$key]['verba']+$totalVerbas;
                                    }
                                    ?>
                                    <?

                                    if($politicos[0]['casaId'] != "1" and $politicos[0]['casaId'] != "2")
                                        foreach($verbas as $key=>$value)
                                        {
                                            if(trim($verbas[$key]['verba']) != "R$ 0,00")
                                            {
                                                ?>
                                                <dl>
                                                <dd><a href="#"><?=$verbas[$key]['descricao']?></a></dd>
                                                <dd><a href="#">R$ <?=number_format($verbas[$key]['verba'],2,",",".")?></a></dd>
                                                </dl>
                                                <?
                                            }
                                        }
                                ?>
                                <?
                                }
                                ?>



    <!-- - - - - - - - - - - - - -  VERBA INDENIZATÓRIA FIM - - - - - - - - - - - - -->

    <!-- - - - - - - - - - - - - -  COMO ELE VOTOU - - - - - - - - - - - - -->
    <h2>Como ele votou?</h2>
    <?
                                    if((count($votos) > 0)){
                                    ?>
    <?
                                    foreach($votos as $key=>$value)
                                    {
                                    ?>
    <dl>
      <dd class="como_votou">
        <?
                                            if($votos[$key]['esperado'] != $votos[$key]['voto'])
                                            {
                                            ?>
        <span class='voto_diferente'>Votou diferente do esperado</span> na votação
        <?=$votos[$key]['codigo']?>
        <?
                                            }
                                            else
                                            {
                                            ?>
        <span class='voto_acordo'>Votou de acordo com o esperado na</span>
        <?=$votos[$key]['codigo']?>
        <?
                                            }
                                            ?>
        <?=$votos[$key]['descricao']?>
        <?
                                            if($votos[$key]['link'] != "")
                                            {
                                            print "<div class='link_processo'><a href=".$votos[$key]['link'].">+ sobre essa votação</a></div>";
                                            }
                                            ?>
      </dd>
    </dl>
    <?
                                        }
                                        }
                                        else
                                        {
                                        ?>
    <div class="dado_indisponivel">Nenhum registro de votos</div>
    <?
                                        }
                                        ?>
    <h2>A Voz do Povo</h2>

  </div>
    
    

    <?
					//  print_R($_SERVER);
					//  include("G:/projeto/VertrigoServ224/www/revolucaobrasileira/site/wall/profile.php");
					  ?>
    <div class="box_comments">
      <?=wall($politicos[0]['id'],1)?>
    </div>
  </div>
  
  <!-- wall -->
  
  <div class="picture" style="height:auto"><span class="fundo_branco">
    <h4 class="name">
      <?=$politicos[0]['apelido']?>
      <span>
      <?=$politicos[0]['partidoNome']?>
      <?=$politicos[0]['uf_sigla']?>
      </span></h4>
    <div class="photo">
      <?
                        $i = 0;
                        foreach($fotos as $key=>$value)
                        {
                        $i = $i+1;

                        if($i>1)
                        $style="none";
                        else
                        $style="block";

                        ?>
      <a href="<?=$fotos[$key]['filename']?>" rel="prettyPhoto[gallery2]"> <img entity_id="<?=$fotos[$key]['ordem']?>" class="image-selector" alt="" src="<?=$fotos[$key]['thumb']?>" style="display: <?=$style?>"/></a>
      <?
                        }
                        ?>
    </div>
    <ul class="details_pic">
    <li><a href="account/material?id=<?=$politicos[0]['id']?>"><img src="catalog/view/theme/revolucao/image/enviar_material.jpg" /></a></li>
      <li> <span class="black">Cargo:</span> <a href=politico/politico?casaId=<?=$politicos[0]['casaId']?>>
        <?=$politicos[0]['casaNome']?>
        </a> </li>
      <li class="icon_chat">
        <?php	
                              if($politicos[0]['politicoEmail'] != "")
                                print " ".$politicos[0]['politicoEmail'];                                                
                            ?>
      </li>
      <?php  
                              foreach($bancada as $key=>$value)
                                print "<li><span class='black'>Bancada:</span> <a href='politico/bancada?idGrupo=".$bancada[$key]['idGrupo']."'>".$bancada[$key]['grupo']."</a></li>";
                             ?>
      <li><span class="font_destaque">Assiduidade</span><a href="rank?rank=assiduidade"><BR>
        <?
                            if(count($assiduidade) >= 1)
                                {
                                ?>
        <!-- <?=$assiduidade[0]['ausencias']?> faltas
                                <?=$assiduidade[0]['rank']?>º colocado -->
        <?
                            }
                            else
                            {
                            ?>
        Sem dados
        <?
                            }
                            ?>
        </a>
        <?
                                    if(is_array($assiduidade))
                                    foreach($assiduidade as $key=>$value)
                                    {
                                    ?>
        <span class="ausencias">
        <?=$assiduidade[$key]['ausencias']?>
        </span>Ausencias<br />
        (
        <?=$assiduidade[$key]['justificadas']?>
        justificadas,
        <?=$assiduidade[$key]['injustificadas']?>
        injustificada) <br />
        <span class="black">Ano:</span>
        <?=$assiduidade[$key]['ano']?>
        <span class="black">Sessoes:</span>
        <?=$assiduidade[$key]['sessoes']?>
        <?
                                    }
                                    else
                                    {
                                    ?>
        Não existem dados.
        <?
                                    }
                                    ?>
      </li>
      <li>
        <?php
                            print "<span class='font_destaque'>Perfil</span><BR>".$politicos[0]['politicoOutrosDados'];
                            ?>
      </li>
      
        <?php
                            if($politicos[0]['politicoCargoAnterior'] != "")
                            {
                                print "<li><span class='font_destaque'>Passado</span><BR>Era ".$politicos[0]['politicoCargoAnterior']."</li>";
                            }
                            
                            if($politicos[0]['politicoCargoRelevante'] != "")
                            {
                                print "<li><span class='font_destaque'>Cargos passados</span><BR>".$politicos[0]['politicoCargoRelevante']."</li>";
                            }
                            ?>


      

      
          <?
          if($politicos[0]['politicoHistorico'] != "")
          {
          print "<li style='border:none'><span class='font_destaque'>Histórico filiações partidárias</span><BR>".$politicos[0]['politicoHistorico']."</li>";
          }
          ?>
    </ul>
    <?
					if(isset($frases[0]['frase']))
					{
					?>
    <em>
    <?=$frases[0]['frase']?>
    <BR>
    <?=$frases[0]['explicacao']?>
    <?
					}
					?>
    <? 
					if(isset($frases[0]['corrupcaoId']) and $frases[0]['corrupcaoId'] != "")
					{
					?>
    <BR>
    <?=$saiba_mais_txt?>
    : <a href="conteudo/corrupcao?corrupcao_id=<?=$frases[0]['corrupcaoId']?>">
    <?=$frases[0]['nome']?>
    </a>
    <?
					}
					?>
    </em></span> </div>
  <!-- wall --> 
  
  <!-- URNA -->
  <div class="urna"> Esse político foi eleito usando uma urna insegura <a href="urnas-inseguras">SAIBA MAIS + <img src="catalog/view/theme/revolucao/images/urna.jpg"></a> </div>
  <!-- URNA FIM --> 
  
</div>
<!-- politico -->
<?php echo $footer ?>
</div>
<!-- content -->

</div>
<!-- #main --> 
<BR>
<?php echo $column_right; ?>
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
					data: 'action='+action+'&page='+page+'&userId=<?=$_SESSION['customer_id']?>&id=<?=$politicos[0]['id']?>',
			beforeSend: function() {
			//    $('.success, .warning').remove();
			//      $('#gostei'+id).html('Aguarde...');
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

<script>

    function loadNoticias()
    {

    $.ajax({
        type: 'POST',
        url: 'index.php?route=ajax/ajax/getNoticias',
        dataType: 'JSON',
        data: 'apelido=<?=$politicos[0]['apelido']?>',
        beforeSend: function() {},
        complete: function() {
            //$('#'+name+id).remove();

    //        $('#'+name+id).replaceWith('<a id='+name+id+' class='+classe+on+' href="javascript:votar('+id+',\''+actionback+'\',\''+page+'\')">'+text+'?</a>');
            //    $('#'+action+'num'+id).html(parseInt($('#'+action+'num'+id).text())+1);
            //    $('#'+action+'numa'+id).html(parseInt($('#'+action+'numa'+id).text())+1);
            // $('.wait').remove();
        },
        success: function(data) {

                $('#scroll_materias').html(imprime(data.materias));
                //$('#pagination').html(data.pagination);
            }
        });
    }


    function imprime(result)
    {
        var str;

        str = ''

        for (var i = 0; i < result.length; i++) {


        str += '<dl><dd><a href="#" class="title_news"><a href="materias/materias?materia_id='+result[i].id+'">'+result[i].titulo+'</a></dd><dd class="origem_materia"><a href="#">'+result[i].nome+'<span>em '+result[i].data+'?></span></a></dd><dd class="see-more"><a href="materias/materias">+ Notícias</a></dd></dl>';

        }

        //str += "</ul>";

        return str;
    }

</script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        prettyPhoto: $("a[rel^='prettyPhoto']").prettyPhoto({theme: 'dark_square',slideshow:5000, autoplay_slideshow:false, deeplinking: false });
        loadNoticias();
    });
</script>
