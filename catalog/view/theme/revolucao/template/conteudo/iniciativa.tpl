<?php echo $header; ?>

<?php echo $column_left; ?>

<table>
    <tr>
        <td><h2><?= $politicos[0]['nome']?></h2></td>
    </tr>
        <tr><td><?=$politicos[0]['descricao']?></td></tr>
</table>

<table>

    <?
    foreach($videos as $key=>$value)
    {
    ?>
    <tr><td><?=$videos[$key]['nome']?><BR>
        <?=$videos[$key]['embed']?></td></tr>
    <?
    }
    ?>
</table>

<?php echo $column_right; ?>

<?php echo $footer ?>