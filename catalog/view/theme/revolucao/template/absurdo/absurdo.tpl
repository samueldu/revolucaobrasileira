<?php echo $header; ?>

<?php echo $column_left; ?>

<table border=1>
<Tr><Td colspan=2>
</td></tr>
<?
foreach($politicos as $key=>$value)
{

	print "<tr><td>link</td><Td><a href=absurdo/absurdo?absurdo_id=".$politicos[$key]['id'].">link</a></</td></tr>"; 

	foreach($politicos[$key] as $chave=>$valor)
	{
	print "<tr><td>$chave</td><Td>$valor</td></tr>";
	}
}
?>
</table>

<?php echo $column_right; ?>

<?php echo $footer ?>