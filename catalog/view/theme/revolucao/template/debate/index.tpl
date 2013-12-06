<?php echo $header; ?>

<?php echo $column_left; ?>

<?
if(!isset($_SESSION['customer_id']))
$url = "javascript:openBox('http://192.168.1.2/revolucaobrasileira/rb/account/login')";
else
$url = "debate/debate/inserir";
?>
<a href="<?=$url?>">Inicie um debate</a><BR><BR>";

<a href="javascript:mostraDebates('novos','1')">Novos</a> -
<a href="javascript:mostraDebates('populares','1')">Populares</a> -
<a href="javascript:mostraDebates('atualizados','1')">Atualizados</a> -
<a href="javascript:mostraDebates('sim,1')">Mais acordados</a> -
<a href="javascript:mostraDebates('nao,1')">Mais desacordados</a> -
<a href="javascript:mostraDebates('opniao,1')">Falta opnião</a>      <BR><BR>

<div name="pagination" id="pagination"> </div>
<div name="politicos" id="politicos" class="lista_politicos"> </div>

<Script>

    function mostraDebates(sort,page)
    {

        if(page==0)
            page = 1;

        $.ajax({
            type: 'POST',
            url: 'index.php?route=debate/debate/getDebates',
            data: 'nome=teste&page='+page,
            dataType: 'json',
            success: function(data) {
                $('#politicos').html(imprime(data.debates));
                $('#pagination').html(data.pagination);
            }
        });
    }

    function imprime(result)
    {
        var str;

        str = '<ul>'

        for (var i = 0; i < result.length; i++) {
            str += '<li><a href=debate/debate?debate_id='+result[i].p_id+'>'+result[i].post+'</a>';
        }

        str += "</ul>";

        return str;
    }
    </script>

<?php echo $column_right; ?>

<?php echo $footer ?>