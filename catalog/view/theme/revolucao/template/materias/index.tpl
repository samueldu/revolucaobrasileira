<?php echo $header; ?>

<?php echo $column_left; ?>

<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css"
      xmlns="http://www.w3.org/1999/html"/>

<div class="escandalos">

    <div class="inner-content">

        <h1>Notícias <?=conector?> <?=estado_nome?></h1>

        <div class="share-holder">

        </div>

        <?
        foreach($estado as $keyx=>$valuex)
        {
        ?>

        <div class="casos-semelhantes">

            <h3><a href="materias/materias?jornal_id=<?=$keyx?>"><?=$estado[$keyx][key($estado[$keyx])]['nome']?></h3>

            <?
                        foreach($estado[$keyx] as $key=>$value)
            {
            ?>

            <div class="caso" style="height: 150px">
                <h5><a href="materias/materias?materia_id=<?=$estado[$keyx][$key]['materia_id']?>"><?=$estado[$keyx][$key]['titulo']?></a></h5>
                <strong><?=date('d/m/Y',strtotime($estado[$keyx][$key]['data']))?></strong>

            </div>
            <?
            }
        }
                        ?>


        </div>


    </div><!-- escandalos -->


    <div class="inner-content">

        <h1>No Brasil</h1>

        <div class="share-holder">

        </div>

        <?
        foreach($politicos as $keyx=>$valuex)
        {
        ?>

        <div class="casos-semelhantes">

        <h3><a href="materias/materias?jornal_id=<?=$keyx?>"><?=$politicos[$keyx][key($politicos[$keyx])]['nome']?></h3>

        <?
                        foreach($politicos[$keyx] as $key=>$value)
        {
        ?>

        <div class="caso" style="height: 150px">
            <h5><a href="materias/materias?materia_id=<?=$politicos[$keyx][$key]['materia_id']?>"><?=$politicos[$keyx][$key]['titulo']?></a></h5>
            <strong><?=date('d/m/Y',strtotime($politicos[$keyx][$key]['data']))?></strong>

        </div>
        <?
            }
        }
                        ?>


    </div>


</div><!-- escandalos -->

<?php echo $column_right; ?>

<?php echo $footer ?>

<?
exit;
?>

<table border=1>
<Tr><Td colspan=2>
HOJE
</td>
</tr>
<? 
foreach($politicos as $key=>$value)
{
	if($politicos[$key]['d'] == date('d'))
	{
		print "<tr><td><a href=materias/materias?materia_id=".$politicos[$key]['materia_id'].">".$politicos[$key]['titulo']."</td><Td></td></tr>";
		unset($politicos[$key]); 
	}
}

 ?>
 <Td colspan=2>
ONTEM
</td>
</tr>
<?

foreach($politicos as $key=>$value)
{
	if($politicos[$key]['d'] == date("d", mktime(0, 0, 0, date("m"),date("d")-1,date("Y"))))
	{
		print "<tr><td><a href=materias/materias?materia_id=".$politicos[$key]['materia_id'].">".$politicos[$key]['titulo']."</td><Td></td></tr>";
		unset($politicos[$key]); 
	}
}
?>
 <Td colspan=2>
Essa semana
</td>
</tr>
<?
foreach($politicos as $key=>$value)
{
		
		print "<tr><td><a href=materias/materias?materia_id=".$politicos[$key]['materia_id'].">".$politicos[$key]['titulo']."</td><Td></td></tr>";
		unset($politicos[$key]);
}
?>
</table>



<?php echo $column_right; ?>

<?php echo $footer ?>