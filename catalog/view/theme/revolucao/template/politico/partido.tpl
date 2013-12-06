<?php echo $header; ?>

<?php echo $column_left; ?>

<Table>
    <tr><td><?=$partido[0]['partidoNome']?></td></tr>
<?
foreach($politicos as $key=>$value)
{  
	print "<tr><td><a href=\"politico/politico?politicoid=".$politicos[$key]['id']."\">".$politicos[$key]['nome']."</a></td></tr>";
} 
?>

</table>

<?php echo $column_right; ?>

<?php echo $footer ?>