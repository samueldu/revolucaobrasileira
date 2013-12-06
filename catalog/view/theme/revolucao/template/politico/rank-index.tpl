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
            <p><a href=politico/politico/rank?rank=verbas>Verbas indenizatórias</a><BR>
                <a href=politico/politico/rank?rank=bens>Bens declarados</a>       <BR>
                <a href=politico/politico/rank?rank=assiduidade>Assiduidade</a>        <BR>
                <a href=politico/politico/rank?rank=corrupcao>Envolvimento em casos de corrupção</a><BR>
                <a href=politico/politico/rank?rank=processos>Processos</a></p>                <BR>
        </div>

    </div><!-- innercontent -->

</div><!-- escandalos -->

<?php echo $column_right; ?>

<?php echo $footer ?>