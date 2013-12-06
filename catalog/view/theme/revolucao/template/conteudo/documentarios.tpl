<?php echo $header; ?>

<?php echo $column_left; ?>

<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>

<div class="escandalos">

    <div class="inner-content">

        <h1>Documentários</h1>

        <div class="envolvidos">

            <div class="users" style="width: 220px;">
                <ul>
                    <?
                    $i = 0;

                    foreach($categorias as $key=>$value)
                    {
                    $i = $i+1;
                    ?>

                    <li>
                        <strong>   <a href="conteudo/documentarios&documentario_categoria=<?=$categorias[$key]['id']?>"><?=$categorias[$key]['nome']?></a><BR> </strong>

                    </li>
                    <?
				}
                ?>
                </ul>
            </div>

            <div class="users-content" style="width: auto; height: auto; text-align: center;">

                <?=$politicos[key($politicos)]['videos'][1]['embed']?>

            </div><!-- users content -->

            <div class="casos-semelhantes" style="width: 75%;">

                <?
                foreach($politicos[key($politicos)]['videos'] as $key=>$value)
                {

                if($key != 1)
                {

                ?>

                <div class="caso" style="width: auto;">
                    <h5 style="font-size: 18px;"><?=$value['nome']?></a></h5>
                    <span><?=$value['embed']?>...</a></span>
                </div>
                <?
                }
                }
                ?>

            </div>

            <div class="casos-semelhantes" style="width: 75%;">

                <?
                foreach($relacionados as $key=>$value)
                {
                ?>

                <div class="caso" style="width: 300px;">
                    <h5 style="font-size: 18px;"><a href="conteudo/documentarios&documentario_id=<?=$relacionados[$key]['id']?>"><?=$relacionados[$key]['documentario_nome']?></a></h5>
                    <a href="conteudo/documentarios&documentario_id=<?=$relacionados[$key]['id']?>"><img src="<?=$relacionados[$key]['videos'][1]['thumb']?>" width="200" border="0"></a>
                    <span><a href="conteudo/documentarios&documentario_id=<?=$relacionados[$key]['id']?>"><?=$relacionados[$key]['descricao']?>...</a></span>
                </div>
                <?
                        }
                        ?>

            </div>
        </div>
    </div>

    <?php echo $column_right; ?>

    <?php echo $footer ?>