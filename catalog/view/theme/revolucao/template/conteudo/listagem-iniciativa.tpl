<?php echo $header; ?>

<?php echo $column_left; ?>

<table>
    <tr>
        <td><h2>Thumbs down!</h2></td>
    </tr>
    <?
                foreach($politicos as $key=>$value)
    {
    print "<tr><td><A href=conteudo/iniciativa?iniciativaId=".$politicos[$key]['iniciativaId'].">".$politicos[$key]['nome']."</a></td></tr>";
    }
    ?>
</table>

<table border=0>
<Tr><Td colspan=2>
</td></tr>

</table>

<?php echo $column_right; ?>

<?php echo $footer ?>