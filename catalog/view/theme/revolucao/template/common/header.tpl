<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) echo '<?xml version="1.0" encoding="UTF-8"?>'. "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html" dir="<?php echo $direction; ?>"
      lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
    <META NAME="AUTHOR" CONTENT="Tex Texin">
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="PRIVATE">
    <META HTTP-EQUIV="CONTENT-LANGUAGE"
          CONTENT="pt-BR">
    <META NAME="ROBOTS" CONTENT="ALL">
    <META HTTP-EQUIV="EXPIRES" CONTENT="<?=gmdate("D, d M Y H:i:s", time() + 3600*8000)." GMT"?>">
    <title><?php echo $title; ?></title>
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<base href="<?php echo $base; ?>" />
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo str_replace('&', '&amp;', $link['href']); ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>

<meta x-frame-options="SAMEORIGIN">
			

    <script type="text/javascript" src="<?=URL_TEMPLATE?>static/js/jquery.js"></script>
    <script type="text/javascript" src="<?=URL_TEMPLATE?>static/js/jquery.masonry.js"></script>
    <!--script type="text/javascript" src="<?=URL_TEMPLATE?>static/js/jquery.easytabs.js"></script-->
    <script type="text/javascript" src="<?=URL_TEMPLATE?>static/js/functions.js"></script>

    <link href="<?=URL_TEMPLATE?>static/css/essentials.css" rel="stylesheet" type="text/css" />


    <script type="text/javascript" src="<?=$base.DIR_JS?>tinybox2/tinybox.js"></script>
<link rel="stylesheet" href="<?=$base.DIR_JS?>tinybox2/style.css">
<link href="<?=URL_TEMPLATE?>static/css/tiago.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?=$base.DIR_JS?>bsn.AutoSuggest_2.0/js/bsn.AutoSuggest_c_2.0.js"></script>

<link rel="stylesheet" href="<?=$base.DIR_JS?>bsn.AutoSuggest_2.0/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />

<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>


<?php echo $google_analytics; ?>

<?
if(isset($customer_name))
{
?>
<link type="text/css" href="<?=BASE_URL?>cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">
<script type="text/javascript" src="<?=BASE_URL?>cometchat/cometchatjs.php" charset="utf-8"></script>
<?
}
?>
<!--link href='http://fonts.googleapis.com/css?family=News+Cycle' rel='stylesheet' type='text/css'-->
</head>             
<body onload="resizeFrame('childframe')">

<?
//print_r($_SESSION);
//print_r($_COOKIE);
?>

<script>
function resizeFrame(g) {
    if(document.getElementById(g))
    {

       // alert(g);

        var f = document.getElementById(g);
        f.style.height = f.contentWindow.document.body.scrollHeight + 10 + "px";
        f.style.width = f.contentWindow.document.body.scrollWidth + 10 + "px";
    }
    else
    {
        //alert('resize not allowed'+g);
    }
}

function openBox(urlEnviada)
{
    TINY.box.show({url:urlEnviada,boxid:'frameless',animate: false, mask:true, maskid:"bluemask", fixed:true,maskopacity:0});
}

function navegaBox(urlEnviada)
{
    TINY.box.fill(urlEnviada,1,0,1);
}

</script>

<!--script type="text/javascript">
    // Firefox worked fine. Internet Explorer shows scrollbar because of frameborder
    function resizeFrame(f) {
        f.style.height = f.contentWindow.document.body.scrollHeight+100 + "px" ;
    }
</script-->

	<div id="main">
		<div class="content">

        <div class="top_line01">
        	<div class="centro">
        		<div class="logo"><img src="catalog/view/theme/revolucao/image/logo-revolucao-brasileira.png" alt="Revolução Brasileira" /></div>
            			<!--li><a href="conteudo/absurdo">Absurdos</a></li-->
                <ul class="menu_header">
                <!--li><a href="materias/materias">Notícias</a></li-->
                <li><a href="conteudo/documentarios&documentario_id=1"><?="Documentários"?></a></li>
                <li><a href="conteudo/corrupcao"><?="Corrupção"?></a></li>
                <li><a href="politico/politico"><?="Políticos"?></a></li>
                <li style="border:none"><a href="debate/debate"><?="Debates"?></a></li>

                <!--li><a href="conteudo/documentarios"><?="Mídia"?></a>
                         <ul>
                         <li><a href="conteudo/documentarios"><?="Documentários"?></a></li>
                         <li><a href="materias/materias">Jornais</a></li>
                         <li><a href="conteudo/absurdo"><?="Mídia"?> Livre</a></li>
                         </ul></li>
                     <!--li><a href="politico/politico"><?="Políticos"?></a></li>
                     <li><a href="conteudo/corrupcao"><?="Corrupção"?></a></li>
                     <li><a href="conteudo/iniciativa"><?="Problemas e soluções"?></a></li-->
                </ul>
                <div class="busca_header">
                    <div>
                        <form method="get" action="">
                            <!--small style="float:right">
                                <input type="text" id="testid" value="" style="font-size: 10px; width: 20px;" disabled="disabled" /></small-->
                                <input style="width: 200px" type="text" id="testinput" value="" placeholder="Nome do político" />
                            <input type="submit" class="busca_link" value="" />
                        </form>
                    </div><!--a href="#" class="busca_link"><img src="catalog/view/theme/revolucao/image/buscar.png" alt="Buscar" --></a></div>
                <div class="minha_conta" style="padding-top: 3px">

                <!-- LANGUAGES-->

                <!-- LANGUAGES-->
                <link rel="stylesheet" href="<?=$base.DIR_JS?>menu/css/style.css">
                <script type="text/javascript" src="<?=$base.DIR_JS?>menu/js/modernizr.custom.79639.js"></script>
<noscript><link rel="stylesheet" type="text/css" href="<?=$base.DIR_JS?>menu/css/noJS.css" /></noscript>

                    <?
        if ($this->customer->isLogged()) {
                   ?>



                    <section class="mainBox">
                        <div class="wrapper-demo">
                            <div id="dd" class="wrapper-dropdown-5" tabindex="1"><?=$_SESSION['customer_name']?>
                                <ul class="dropdownBox">
                                    <li><a href="<?=$base?>account/wall?id_wall=<?=$_SESSION['customer_id']?>&origem=4&id=<?=$_SESSION['customer_id']?>"><i class="icon-inbox"></i>Meu Feed</a></li>
                                    <li><a href="<?=$base?>account/settings"><i class="icon-pencil"></i>Meus dados</a></li>
                                    <li><a href="<?=$base?>information/information?information_id=1"><i class="icon-wrench"></i>API</a></li>
                                    <li><a href="<?=$base?>account/newsletter"><i class="icon-list"></i>Privacidade</a></li>
                                    <li><a href="<?=$base?>account/logout"><i class="icon-remove"></i>Sair</a></li>
                                    <li><a href="<?=$base?>ajuda"><i class="icon-help"></i>Ajuda</a></li>
                                </ul>
                            </div>
                            ?</div>
                    </section>

                    <!--a href="account/login" class="conta_link"><span>Menu eterno</span><img class="engrenagem" src="catalog/view/theme/revolucao/image/engrenagem.png" alt="Buscar" /></a--></div>
                        <?
        }
        else
        {
        ?>
        <a href="javascript:openBox('<?=BASE_URL?>account/login')" class="login_header">Login</a>
        <img src="catalog/view/theme/revolucao/image/fbconnecthome.png" onclick="document.location.href='https://www.facebook.com/dialog/oauth?client_id=128902130642687&redirect_uri=<?=urlencode(BASE_URL)?>account%2Fnewfb&scope=email%2Cuser_birthday%2Cuser_location%2Cuser_hometown';return false;">
        <img onclick="document.location.href='<?=BASE_URL?>account/twconnect';return false;" src="catalog/view/theme/revolucao/image/twitterconnecthome.png" title="Login com Twitter" alt="Login com Twitter" /></a></div>

                        <?
        }
        ?>



                <?php if ($languages) { ?>
                <!--
                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="language_form">
                    <div class="switcher">
                        <?php foreach ($languages as $language) { ?>
                        <?php if ($language['code'] == $language_code) { ?>
                        <div class="selected"><a><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" /></a></div>
                        <?php } ?>
                        <?php } ?>
                        <div class="option">
                            <?php foreach ($languages as $language) { ?>
                            <a onclick="$('input[name=\'language_code\']').attr('value', '<?php echo $language['code']; ?>'); $('#language_form').submit();"><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" />
                                <?php echo $language['name']; ?>
                            </a>
                            <?php } ?>

                        </div>
                        -->

                    </div>

                    <div>
                        <input type="hidden" name="language_code" value="" />
                        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                    </div>
                </form>
                <?php } ?>

        	</div>
        </div>

        <script type="text/javascript">
            var options = {
                script:"<?=$base?>ajax/ajax/getPoliticos?origem=header&",
                varname:"nome",
                json:true,
                timeout:"2500",
                delay:200,
                offsety:0,
                shownoresults:true,
                noresults:"Nenhum resultado",
                cache:false,
                dataType: "json",
                callback: function (obj) {
                   window.location = "<?$base?>politico/politico?politicoid="+obj.id;
                }
            };
            var as_json = new AutoSuggest('testinput', options);

        </script>

        <div class="top_line02">
        	<div class="centro">
            		<?	
                    if(count($breadcrumbs) > 0)
                    {
                    
                    ?>
                    <div id="breadcrumb" class="<?php if(trim($rota) == 'product/product'){ echo "breadcrumb_product"; }?>" >
                      <?php
                      $i = 0; 
                      foreach ($breadcrumbs as $breadcrumb) { $i++;?>
                      <?php echo $breadcrumb['separator']; ?><a href="<?php echo str_replace('&', '&amp;', $breadcrumb['href']); ?>">
                        <?php if($i == count($breadcrumbs)){?>
                        <?php echo $breadcrumb['text']; ?>
                        <?php }else{ ?>
                        <span><?php echo $breadcrumb['text']; ?></span>
                        <?php } ?>
                        
                      </a>
                      <?php }
                      ?>
            
                    </div>
                    
                    <?php 
                    }  
                    ?>
            </div>

       </div>


<div class="like_face">

    <div class="stereoSocial">
        <div class="socialLink">
            <ul>
                <li>
                    <a href="http://www.twitter.com/Br_Rev" id="socialTw" target="_blank" title="RB on twitter" href="">RB on twitter</a>
                </li>
                <li>
                    <a href="http://www.facebook.com/revolucao.brasileira.br" id="socialFb" target="_blank" title="RB on facebook" href="">RB on facebook</a>
                </li>
                <li>
                    <a href="http://revolucaobrasileirabr.tumblr.com/" id="socialGp" target="_blank" title="RB on tumblr" href="">RB on tumblr</a>
                </li>
            </ul>
        </div>
    </div>

    <!--div class="fb-like" data-href="https://www.revolucaobrasileira.com.br" data-send="true" data-layout="button_count" data-width="200" data-show-faces="true"></div>
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
      {lang: 'pt-BR'}
    </script>
    
    <div class="g-plus" data-action="share" data-annotation="bubble" data-href="http://www.revolucaobrasileira.com.br"></div-->
</div>


    <!--ul class="reset">
        <li><a href="#"><img src="<?=HTTP_IMAGE?>socials/google.png" alt="GOOGLE PLUS" /></a></li>
        <li><a href="#"><img src="<?=HTTP_IMAGE?>socials/twitter.png" alt="FACEBOOK" /></a></li>
        <li><a href="#"><img src="<?=HTTP_IMAGE?>socials/twitter.png" alt="TWITTER" /></a></li>
        <li><a href="#"><img src="<?=HTTP_IMAGE?>socials/twitter.png" alt="E-MAIL" /></a></li>
        <li><a href="#"><img src="<?=HTTP_IMAGE?>socials/twitter.png" alt="TUMBLR" /></a></li>
    </ul-->
    
<!-- menu-bar -->


<script type="text/javascript">

    function DropDown(el) {
        this.dd = el;
        this.initEvents();
    }
    DropDown.prototype = {
        initEvents : function() {
            var obj = this;

            obj.dd.on('click', function(event){
                $(this).toggleClass('active');
                event.stopPropagation();
            });
        }
    }

    $(function() {

        var dd = new DropDown( $('#dd') );

        $(document).click(function() {
            // all dropdowns
            $('.wrapper-dropdown-5').removeClass('active');
        });

    });

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function recuperarSenha()
    {

        if(document.getElementById("email").value.length < 5 || !validateEmail(document.getElementById("email").value))
        {
            alert('Email inválido');
            return false;
        }
        else
        {


            $.ajax({
                type: 'POST',
                url: 'index.php?route=account/forgotten/forgotten',
                data: $('#forgotten').serialize(),
                dataType: 'json',
                success: function(data) {
                    if(data.warning)
                    {
                        alert(data.warning);
                    }

                    if(data.url)
                    {
                        window.location = data.url;
                    }

                    /*
                     $("input[name='address_1']").val(data.logradouro);
                     $("input[name='bairro']").val(data.bairro);
                     $("input[name='city']").val(data.cidade);
                     $("select[name='zone_id'] option").each(function(){
                     if($(this).text() == data.estado){
                     $(this).attr("selected", true);
                     }
                     });
                     $("#btn_cadastrar").css('display','inline-block');
                     $("#btEsp").css("display","none");
                     */
                }
            });
        }

    }

    function makeLogin()
    {

        if(document.getElementById("email").value.length < 5 || !validateEmail(document.getElementById("email").value))
        {
            alert('Email inválido');
            return false;
        }
        else if(document.getElementById("password").value.length < 5)
        {
            alert('Senha inválida');
            return false;
        }
        else
        {


            $.ajax({
                type: 'POST',
                url: 'index.php?route=account/login/login',
                data: $('#login').serialize(),
                dataType: 'json',
                success: function(data) {
                    if(data.warning)
                    {
                        alert(data.warning);
                    }

                    if(data.url)
                    {
                        window.location = data.url;
                    }

                    /*
                     $("input[name='address_1']").val(data.logradouro);
                     $("input[name='bairro']").val(data.bairro);
                     $("input[name='city']").val(data.cidade);
                     $("select[name='zone_id'] option").each(function(){
                     if($(this).text() == data.estado){
                     $(this).attr("selected", true);
                     }
                     });
                     $("#btn_cadastrar").css('display','inline-block');
                     $("#btEsp").css("display","none");
                     */
                }
            });
        }

    }

    function cadastra()
    {

        if(document.getElementById("firstname").value.length < 5)
        {
            alert('Seu nome deve possuir mais letras');
            return false;
        }
        else if(document.getElementById("email").value.length < 5 || !validateEmail(document.getElementById("email").value))
        {
            alert('Email inválido');
            return false;
        }
        else if(document.getElementById("password").value.length < 5 || (document.getElementById("password").value != document.getElementById("confirm").value))
        {
            alert('Senha inválida');
            return false;
        }
        else
        {


        $.ajax({
            type: 'POST',
            url: 'index.php?route=account/create/addUser',
            data: $('#create').serialize(),
            dataType: 'json',
            success: function(data) {
                if(data.warning)
                {
                    alert(data.warning);
                }

                if(data.url)
                {
                    window.location = data.url;
                }

                /*
                $("input[name='address_1']").val(data.logradouro);
                $("input[name='bairro']").val(data.bairro);
                $("input[name='city']").val(data.cidade);
                $("select[name='zone_id'] option").each(function(){
                    if($(this).text() == data.estado){
                        $(this).attr("selected", true);
                    }
                });
                $("#btn_cadastrar").css('display','inline-block');
                $("#btEsp").css("display","none");
                */
            }
        });
           }

    }

</script>
