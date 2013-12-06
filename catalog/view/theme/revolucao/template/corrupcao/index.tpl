<?php echo $header; ?>

<?php echo $column_left; ?>

<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>

<script type="text/javascript" src="<?=DIR_JS?>accordion/jquery.easing.1.3.js"></script>

<script type="text/javascript" src="<?=DIR_JS?>accordion/script.js"></script>

<script>
    function showHide(shID) {
        if (document.getElementById(shID)) {
            if (document.getElementById(shID+'-show').style.display != 'none') {
                document.getElementById(shID+'-show').style.display = 'none';
                document.getElementById(shID).style.display = 'block';
            }
            else {
                document.getElementById(shID+'-show').style.display = 'inline';
                document.getElementById(shID).style.display = 'none';
            }
        }
    }
</script>

<style>
    hr {
        border: 0;
        height: 5px;
        background: #333;
        background: -webkit-gradient(linear, left top, right top, color-stop(0%,hsla(0,0%,0%,0)), color-stop(50%,hsla(0,0%,0%,.75)), color-stop(100%,hsla(0,0%,0%,0)));
        background: -webkit-linear-gradient(left, hsla(0,0%,0%,0) 0%, hsla(0,0%,0%,.75) 50%, hsla(0,0%,0%,0) 100%);
        background:    -moz-linear-gradient(left, hsla(0,0%,0%,0) 0%, hsla(0,0%,0%,.75) 50%, hsla(0,0%,0%,0) 100%);
        background:     -ms-linear-gradient(left, hsla(0,0%,0%,0) 0%, hsla(0,0%,0%,.75) 50%, hsla(0,0%,0%,0) 100%);
        background:      -o-linear-gradient(left, hsla(0,0%,0%,0) 0%, hsla(0,0%,0%,.75) 50%, hsla(0,0%,0%,0) 100%);
        background:         linear-gradient(left, hsla(0,0%,0%,0) 0%, hsla(0,0%,0%,.75) 50%, hsla(0,0%,0%,0) 100%);
    }
    .more {
        display: none;
 }
    a.showLink, a.hideLink {
        text-decoration: none;
        color: #36f;
        padding-left: 8px;
        background: transparent url(down.gif) no-repeat left; }
    a.hideLink {
        background: transparent url(up.gif) no-repeat left; }
    a.showLink:hover, a.hideLink:hover {
        border-bottom: 1px dotted #36f; }

    .buttonPerfil {
        -moz-box-shadow:inset 0px 1px 0px 0px #f5978e;
        -webkit-box-shadow:inset 0px 1px 0px 0px #f5978e;
        box-shadow:inset 0px 1px 0px 0px #f5978e;
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #f24537), color-stop(1, #c62d1f) );
        background:-moz-linear-gradient( center top, #f24537 5%, #c62d1f 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f24537', endColorstr='#c62d1f');
        background-color:#f24537;
        -webkit-border-top-left-radius:20px;
        -moz-border-radius-topleft:20px;
        border-top-left-radius:20px;
        -webkit-border-top-right-radius:20px;
        -moz-border-radius-topright:20px;
        border-top-right-radius:20px;
        -webkit-border-bottom-right-radius:20px;
        -moz-border-radius-bottomright:20px;
        border-bottom-right-radius:20px;
        -webkit-border-bottom-left-radius:20px;
        -moz-border-radius-bottomleft:20px;
        border-bottom-left-radius:20px;
        text-indent:0;
        border:1px solid #d02718;
        display:inline-block;
        color:#ffffff;
        font-family:Arial;
        font-size:15px;
        font-weight:bold;
        font-style:normal;
        height:32px;
        line-height:32px;
        width:155px;
        text-decoration:none;
        text-align:center;
        text-shadow:2px 2px 0px #810e05;
        position: absolute;
        top:-110px;
        left:-10px;
    }
    .buttonPerfil:hover {
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #c62d1f), color-stop(1, #f24537) );
        background:-moz-linear-gradient( center top, #c62d1f 5%, #f24537 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#c62d1f', endColorstr='#f24537');
        background-color:#c62d1f;
    }.buttonPerfil:active {


     }
</style>


<div class="escandalos">

    <div class="inner-content">

        <!--em class="date"><?=$politicos[0]['data']?></em-->
<script>
      /*  $('#textoInical').readmore({
            speed: 75,
            maxHeight: 500,
            moreLink: '<a href="#">Leia mais</a>'
        });
        */
        </script>


        <div class="basic-text" id="textoInical">
            <!--h4>R$ 100 bilhões anuais</h4-->
            <span style="font-size: 30px">Desde que você entrou nesse site, <BR>R$ <div id="counter" name="counter">...</div><a href="<?=curPageURL()?>#cit1">¹</a> foram perdidos com a corrupção no Brasil.</span><BR><BR><span style="font-size: 22px">Nós queremos diminuir isso.</span><BR><BR><BR>

            <!--a href="#" id="example-show" class="showLink" onclick="showHide('example');return false;">Saiba mais...</a--></p>
            <!--div id="example" class="more" style="font-size: 20px">
                <p>Esse ranking foi criado usando como base os escândalos mais recentes de nossa história política reportados . É criado dinamicamente utilizando  </p>
                <p>O que o Brasil perde exatamente com a corrupção é incalculável, porém estímasse cifras em torno de 1,38% a 2,3% do PIB, isto é, de <a href="http://www.bbc.co.uk/portuguese/noticias/2012/11/121031_corrupcao_numeros_mdb.shtml" target="_blank"> R$ 50,8 bilhões a R$ 84,5 bilhões por ano</a>
                    O problema é grande, mas vem diminuindo<a href="#cit2">²</a> ou pelo ao menos, se mantendo estável. O Brasil perde com a ineficiência do gasto público e com o desestímulo ao investimento privado <BR>
                    <BR>Por que somos corruptos?<BR><BR>Existem diferentes motivos para a nossa corrupção de cada dia.<BR>
                    O ímpeto que leva o cidadão comum a pesar duas batatas, abrir o saquinho e colocar mais duas
                    No geral ela é acompanhada da sensação de impunidade e de que é um fenômeno ciclico: "Vou tirar um pouquinho aqui hoje para descontar o que tiram de mim ontem e que vão tirar amanhã".<BR>
                    Essa geralmente é a premissa esmagadora que cria a falsa sensação de liberdade para ser corrupto.
                    Flertamos tanto com a corrupção que no geral nem percebemos Um clima generalizado de "ja estava assim quando eu cheguei". Parece claro para todos que a grande causa da corrupção é
                    A nossa representatividade política nada mais é do que uma amostragem social de nosso povo. : o brasileiro muitas vezes é corrupto ou tem grande tolerância a corrupção alheia. Ser silente diante da corrupção alheia é praticamente ser corrupto também. <BR>
                    <br>O estilo de vida que compartilhamos, completamente centrado no capital, é propenso a desvios morais mas se ampliar-mos de forma revolucionária a <a href="politico/politico/rank?rank=transparencia">transparência governamental</a> e trabalhar-mos com vigilância esses números irão diminuir.
                    <BR><BR>O objetivo deses ranking é enumerar os políticos que estão em exercício ou que estavam até recentemente e que ficaram famosos, dentre outros motivos, por se envolverem em grandes escândalos de corrupção.<BR><BR>
                    .</p>
                <p><a href="#" id="example-hide" class="hideLink" onclick="showHide('example');return false;">Fechar.</a></p>
            </div-->
        </div>

            <!--Em 2012, quase 3 mil casos de corrupção e improbidade prescreveram por falta de julgamento.

            As causas desses problemas moral e a tolerância do povo brasileiro são de difícil compreensão podem basear-se num sistema que-->


            <div class="basic-text">

            <ul class="container">

                <?
                    $i = 0;
							foreach($politicosRank[0]['personagens'] as $key=>$value)
                {
                //debug($politicosRank[0]['personagens'][$key]);

                //$politicosRank[0]['personagens']

                $i = $i+1;

                if($i == 1)
                $style="border-top:0px;";
                else
                $style="";

                ?>

                <script>

                    $(function(){

                        $("li[class='button']").hover(function(){
                            //eleva a imagem 10px

                           // $(this).find('#buttonPerfilDiv').css('display', 'block');
                           // $(this).find('#buttonPerfilDiv').animate({ opacity: 1 }, 0);

                            //$(this).find('#buttonPerfilDiv').stop().animate({marginTop:'-10px'},200);
                          //  $(this).find('#buttonPerfilDiv').animate({ opacity: 1 }, "slow");
                            $(this).find('#buttonPerfilDiv').show();

                        },function(){



                            // volta a imagem

                            //$(this).find('#buttonPerfilDiv').stop().animate({marginTop:'0px'},200);
                           // $(this).find('#buttonPerfilDiv').animate({ opacity: 0}, "slow");
                            $(this).find('#buttonPerfilDiv').hide();

                        })

                    });
                </script>

                <li class="menu"> <!-- This LI is positioned inside the main UL -->

                    <ul>


                        <!-- The click-able section title with a unique background: -->
                        <li class="button" style="<?=$style?>">
                            <a href="#" class="green">
                            <div id="fotoContainer" style="height:100px; width:100px; position:relative;">
                                 <img id="image" style="position:absolute; left:0; top:0;" src="<?=$politicosRank[0]['personagens'][$key]['thumb']?>"/> <span class="info_principais"></span>
                                    <p id="text" style="z-index:100; position:absolute; background-color: red; color:white; font-size:24px;     white-space: nowrap;
    overflow: hidden; font-weight:bold; left:80px; top:62px;"><?="&nbsp;".$i."º - ".$politicosRank[0]['personagens'][$key]['apelido']." - ".$politicosRank[0]['personagens'][$key]['partidoNome']."&nbsp;"?></p>
                            </div>

                                <div id="fotoContainer" style="left:115px; top:0px; position:absolute; float: right">
                                <!--span class="info_principais" style="font-size: 16px" >
                                <?=$politicosRank[0]['personagens'][$key]['apelido']?>
                                <div><?=$politicosRank[0]['personagens'][$key]['partidoNome']?> / <?=$politicosRank[0]['personagens'][$key]['estado']?></div>
                                </span-->
                                </div>
                                </a>

                            <div id="buttonPerfilDiv" class='destaque01 destaque03' style="right:15px; top:50px; display: none; float: right;"><a class="buttonPerfil" onclick='location.href ="<?=BASE_URL?>politico/politico?politicoid=<?=$politicosRank[0]['personagens'][$key]['id']?>"'>Ficha completa</a></div>

                            </a>



                        </li>


                        <?
                        if($i == 1)
                        $display = "list-item";
                        else
                        $display = "none";
                        ?>

                        <li class="dropdown" style="display: <?=$display?>;">
                           <div class="dropdown_cargo">
                               <?
                               if($politicosRank[0]['personagens'][$key]['politicoCargoRelevante'] != "")
                               {
                               ?>
                           		<span class="font_destaque">Histórico:</span> <?=$politicosRank[0]['personagens'][$key]['politicoCargoRelevante']?><br />
                               <?
                               }
                               ?>

                               <?
                               if($politicosRank[0]['personagens'][$key]['bancada'] != "")
                               {

                               ?>
                           		<span class="font_destaque">Bancada:</span> <a href="#"><?=$politicosRank[0]['personagens'][$key]['bancada']?></a>
                              <?
                              }
                              ?>
                           </div>
                           <div class="dropdown_passado">
                           
							<span class="font_destaque">Casos de Corrupção</span>
                            
                            <ul class="lista_casos">

                                <?php
                                foreach($politicosRank[0]['personagens'][$key]['casos'] as $chave=>$valor)
                                {
                                ?>
                                <li><a class="button_small_gray" href="conteudo/corrupcao?corrupcao_id=<?=$politicosRank[0]['personagens'][$key]['casos'][$chave]['id']?>"><?=$politicosRank[0]['personagens'][$key]['casos'][$chave]['corrupcaoTitulo']?></a> <?=date("d/m/Y", strtotime($politicosRank[0]['personagens'][$key]['casos'][$chave]['data']))?></li>
                                <?
                                }
                                ?>
							</ul>

                           </div>


                            <?
                            if(!is_null($politicosRank[0]['personagens'][$key]['processos'] ) and $politicosRank[0]['personagens'][$key]['processos']  != "0" and $politicosRank[0]['personagens'][$key]['processos']  < 50 and $politicosRank[0]['personagens'][$key]['processos']  != "")
                            {
                            ?>
			                    <div class='destaque01 destaque02'><a href='politico/politico/rank?rank=processos' tittle='Ranking de uso de verbas' class='rank'></a><span class='percentual'><?=$politicosRank[0]['personagens'][$key]['processos']?>º</span><span class='text1'>Está entre os<br>com mais processos<br>na justiça</div>
                            <?
                            }
                            ?>

                            <?
                            if(!is_null($politicosRank[0]['personagens'][$key]['bens'] ) and $politicosRank[0]['personagens'][$key]['bens']  != "0" and $politicosRank[0]['personagens'][$key]['bens']  < 50 and $politicosRank[0]['personagens'][$key]['bens']  != "")
                            {
                            ?>
			               <div class='destaque01 destaque02'><a href='politico/politico/rank?rank=bens' tittle='Ranking Declaração de Bens' class='rank'></a><span class='percentual'><?=$politicosRank[0]['personagens'][$key]['bens']?>º</span><span class='text3'><span class='text2'>Maior</span><br>declaração de bens.</span></div>
                            <?
                            }
                            ?>


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

        <div class="casos-semelhantes">

            <h3>Você se lembra?</h3>

            <?
                        foreach($casos_semelhantes as $key=>$value)
            {
            ?>

                            <div class="caso">
                                <h5><a href="conteudo/corrupcao?corrupcao_id=<?=$casos_semelhantes[$key]['id']?>"><?=$casos_semelhantes[$key]['titulo']?></a></h5>
                                <strong><?=$casos_semelhantes[$key]['data']?></strong>
                                <span><?=strip_tags($casos_semelhantes[$key]['descricao'])?>...</span>
                            </div>
            <?
                        }
                        ?>

            <div class="caso" style="float: right;">
                <h5> <a href="conteudo/corrupcao/lista">Veja a lista completa >>></a></h5>
                </div>

        </div>



        <div class="frases-marcantes">

            <h3>Frases</h3>

            <?
						foreach($frases as $key=>$value)
            {
            ?>
            <div class="frase">
                <h5><?=$frases[$key]['frase']?></h5>
                <em><?=$frases[$key]['explicacao']?>. <a href="conteudo/corrupcao?corrupcao_id=<?=$frases[$key]['corrupcaoId']?>">Veja mais</a></em>
                <!--div class="badges">
                    <div class="likes"><?=$frases[$key]['like']?></div>
                    <div class="dislikes"><?=$frases[$key]['deslike']?></div>
                </div-->
            </div>
            <?
						}
						?>
        </div>
    <div class="casos-semelhantes"><BR><BR><BR>
        <b style="font-size: 16px"> Referências:</b><BR><BR>
        <ul>
            <li><a name="cit1">1</a>. - <a href="http://www.fiesp.com.br/wp-content/uploads/2012/05/custo-economico-da-corrupcao-final.pdf">http://www.fiesp.com.br/wp-content/uploads/2012/05/custo-economico-da-corrupcao-final.pdf</a></li>
            <li><a name="cit2">2</a>. - <A href="http://transparency.org/cpi2012/results">http://transparency.org/cpi2012/results</A></li>
        </ul>
    </div>

    </div><!-- innercontent -->



</div><!-- escandalos -->

<script>
function counter() {

    //delete window.content.localStorage['seconds'];

    if (typeof localStorage['seconds'] === 'undefined') {
        localStorage['seconds'] = 1;
    }
    else
    {
        localStorage['seconds'] = parseInt(localStorage['seconds'])+1;
    }

    add = 80000000000/(31556926);
    var count = parseInt($('#counter').text());
    var newx = add*localStorage['seconds'];
    var result = format2(newx);
    $('#counter').text(result);
}

function getMoney( str )
{
    return parseInt( str.replace(/[\D]+/g,'') );
}
function formatReal( int )
{

    var tmp = int+'';
    tmp = tmp.replace(/([0-9]{2})$/g, ",$1");

    if( tmp.length > 6 )
    {
        tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    }

    if( tmp.length > 9 ){
        tmp = tmp.replace(/([0-9]{3}).([0-9]{3}),([0-9]{2})$/g,'.$1.$2,$3');
    }

    return tmp;
}

function moeda(valor, casas, separdor_decimal, separador_milhar){

    var valor_total = parseInt(valor * (Math.pow(10,casas)));
    var inteiros =  parseInt(parseInt(valor * (Math.pow(10,casas))) / parseFloat(Math.pow(10,casas)));
    var centavos = parseInt(parseInt(valor * (Math.pow(10,casas))) % parseFloat(Math.pow(10,casas)));


    if(centavos%10 == 0 && centavos+"".length<2 ){
        centavos = centavos+"0";
    }else if(centavos<10){
        centavos = "0"+centavos;
    }

    var milhares = parseInt(inteiros/1000);
    inteiros = inteiros % 1000;

    var retorno = "";

    if(milhares>0){
        retorno = milhares+""+separador_milhar+""+retorno
        if(inteiros == 0){
            inteiros = "000";
        } else if(inteiros < 10){
            inteiros = "00"+inteiros;
        } else if(inteiros < 100){
            inteiros = "0"+inteiros;
        }
    }
    retorno += inteiros+""+separdor_decimal+""+centavos;


    return retorno;

}

function format2(n) {
    var myStr = n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1.");
    myStr = myStr.substring(0,myStr.lastIndexOf(".")) + ',' +myStr.substring(myStr.lastIndexOf(".")+1,myStr.length);
    return myStr;
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