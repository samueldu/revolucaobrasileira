<?php
// Heading
$_['heading_title']      = htmlentities('iPagare WebService');

// Text 
$_['text_payment']       = htmlentities('Pagamento');
$_['text_success']       = htmlentities('Successo: Voc� modificou seus dados do iPagare!');
$_['text_ipagare']       = '<img src=\''.HTTPS_SERVER.'view/image/ipagare-logo-transp.png\'>';
$_['text_sale']          = htmlentities('Venda');

// Entry
$_['entry_estabelecimento'] = htmlentities('C�digo do Estabelecimento:');
$_['entry_chave']        	= htmlentities('C�digo de Seguran�a:');
$_['entry_teste']        	= htmlentities('Ambiente de Teste:');
$_['entry_status'] 			= htmlentities('Status:');
$_['entry_debug'] 			= htmlentities('Logar Erros:');
$_['entry_geo_zone']     	= htmlentities('Zonas Geo');

$_['entry_order_status_aguardando']	= htmlentities('Status para Pedido Aguardando:');
$_['entry_order_status_aprovado']  	= htmlentities('Status para Pedido Autorizado:');
$_['entry_order_status_capturado']  = htmlentities('Status para Pedido Capturado:');
$_['entry_order_status_cancelado']  = htmlentities('Status para Pedido Expirado:');


$_['entry_order_status_reprovado']  = htmlentities('Status para Pedido Reprovado:');
$_['entry_order_status_completo']  	= htmlentities('Status para Pedido Completo:');
$_['entry_order_status_analise']    = htmlentities('Status para Pedido Em An�lise:');

$_['entry_sort_order']   		= htmlentities('Ordem:');

// Explain
$_['explain_estabelecimento'] = htmlentities('C�digo do estabelecimento recebido no e-mail de notifica��o de entrada em produ��o (ver se��o "C�digos para integra��o" do e-mail).');
$_['explain_chave'] = htmlentities('C�digo de seguran�a recebido no e-mail de notifica��o de entrada em produ��o (ver se��o "C�digos para integra��o" do e-mail).');

// Error
$_['error_permission']   		= htmlentities('Aviso: Voc&atilde; n&atilde;o tem permiss�o para modificar os dados do iPagare!');
$_['error_estabelecimento']     = htmlentities('� necess�rio informar o C�digo do Estabelecimento!'); 
$_['error_chave']        		= htmlentities('� necess�rio informar a Chave da Conta!'); 
?>