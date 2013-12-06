<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link href='http://fonts.googleapis.com/css?family=Headland+One' rel='stylesheet' type='text/css'>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="catalog/view/javascript/tinybox2/tinybox.js"></script>
    <link rel="stylesheet" href="catalog/view/javascript/tinybox2/style.css">

    <script>
        function openBox(urlEnviada)
        {
            TINY.box.show({url:urlEnviada,boxid:'frameless',animate: false, mask:true, maskid:"bluemask", fixed:true,maskopacity:0});
        }
    </script>
    <title>Background image cycler | Simon Battersby</title>
    <style type="text/css">
        body{color:white;font-family:Arial,Helmet,sans-serif;background-color:#f1f1f1;}
        #outer_wrap{width:85%;margin:50px 0 0 100px;}
        #wrap{width:507px;vposition:relative;z-index:1;padding:0}
        #wrap_background{position:absolute;top:70px;left:70px;width:590px;height:300px;background-color:#000010;z-index:-1;opacity:0.6;filter: alpha(opacity = 60);border-radius:10px;-moz-border-radius:10px}
        h1{margin:0 0 30px}
        a{color:white}
        #background_cycler{padding:0;margin:0;width:100%;position:absolute;top:0;left:0;z-index:-1;}
        #background_cycler img{position:absolute;left:0;top:0;width:100%;z-index:1;background-color:white}
        #background_cycler img.active{z-index:3}
		#wrap p{
          font-family:'Headland One', serif;
          font-size:14px;
          line-height:1.8em;
          text-align:left;
}
    </style>
<link href="<?=URL_TEMPLATE?>static/css/tiago.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="background_cycler" >
    <cript type="text/javascript">
        $('#background_cycler').hide();//comment
    </script>
    <img class="active" src="catalog/view/theme/revolucao/image/blumenau.jpg" alt="Revolucao brasileira"   />
    <img src="catalog/view/theme/revolucao/image/paulista_20_06.jpg" alt="Paulista 20 de junho Revolucao brasileira"   />
    <img src="catalog/view/theme/revolucao/image/congresso-nacional.jpg" alt="Congresso Nacional"   /   >
    <img src="catalog/view/theme/revolucao/image/rio-de-janeiro.jpg" alt="Riod e Janeiro"   />
</div>
<script type="text/javascript">
    function cycleImages(){
        var $active = $('#background_cycler .active');
        var $next = ($('#background_cycler .active').next().length > 0) ? $('#background_cycler .active').next() : $('#background_cycler img:first');
        $next.css('z-index',2);//move the next image up the pile
        $active.fadeOut(1500,function(){//fade out the top image
	  $active.css('z-index',1).show().removeClass('active');//reset the z-index and unhide the image
      $next.css('z-index',3).addClass('active');//make the next image the top one
      });
    }

    $(window).load(function(){
        $('#background_cycler').fadeIn(1500);
        // run every 7s
        setInterval('cycleImages()', 5000);
    })
</script>
<div id="outer_wrap">
    <div id="wrap">
        <div id="wrap_background"></div>
        <h1 style="text-indent:-1000">Revolução Brasileira</h1>
        <p> <?=$frase['frase']?></p>
        <p style="color:#999">- <?=$frase['autor']?></p>
    </div>
        <div class="button_front"><a  href="javascript:openBox('<?=BASE_URL?>/account/login');" style="cursor:pointer" ><span>Conectar</span></a></div></div>

    <!--div>    <a href="https://www.facebook.com/dialog/oauth?client_id=128902130642687&redirect_uri=<?=urlencode(BASE_URL)?>account%2Ffbconnect&state=004cfa38e694c2db06e52faecb2ddd74&scope=email%2Cuser_birthday%2Cuser_location%2Cuser_hometown">
        <img src="catalog/view/theme/revolucao/image/botao-entrar-facebook.png">
    </a>
</div-->
</body></html>