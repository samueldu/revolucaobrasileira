<?php echo $header; ?>

<?php echo $column_left; ?>

<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css"
      xmlns="http://www.w3.org/1999/html"/>

<div class="escandalos">

    <div class="pagination paginationTop" style="float: right"><?php echo $pagination; ?></div>

    <div class="inner-content">

        <h1>Notícias</h1>

        <div class="share-holder">

        </div>

        <div class="casos-semelhantes">

            <h3><?=$politicos[key($politicos)]['nome']?></h3>

            <?
            foreach($politicos as $keyx=>$value)
            {
            ?>

            <div class="caso" style="height: 150px">
                <h5><a href="materias/materias?materia_id=<?=$politicos[$keyx]['materia_id']?>"><?=$politicos[$keyx]['titulo']?></a></h5>
                <strong><?=date('d/m/Y',strtotime($politicos[$keyx]['data']))?></strong>

            </div>
            <?
        }
                        ?>


        </div>

    </div><!-- escandalos -->

</div>

    <?php echo $column_right; ?>

    <?php echo $footer ?>