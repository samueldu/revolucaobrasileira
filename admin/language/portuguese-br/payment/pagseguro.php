<?php
// Heading
$_['heading_title']       = 'UOL PagSeguro';
$_['heading_description'] = 'Configuração para pagamentos com o UOL PagSeguro';

// Text
$_['text_payment']       = 'Pagamento';
$_['text_success']        = 'Sucesso: Você modificou as configurações do UOL PagSeguro!';
$_['text_pagseguro']      = '<a onclick="window.open(\'http://www.pagseguro.com.br/\');"><img src="view/image/payment/uolpagseguro.png" alt="PagSegur UOL" title="PagSeguro" style="border: 1px solid #EEEEEE;" /></a>';

// Entry
$_['entry_status']        = 'Status:';
$_['entry_geo_zone']      = 'Zona Geográfica:';
$_['entry_email']         = 'E-Mail:';
$_['entry_order_status'] = 'Status padrão do pedido:';
$_['entry_aguardando'] = 'Status aguardando:';
$_['entry_cancelado'] = 'Status Cancelado:';
$_['entry_aprovado'] = 'Status Aprovado:';
$_['entry_analize'] = 'Status em análise:';
$_['entry_completo'] = 'Status Completo:';
$_['entry_encryption']   = 'Token do UOL PagSeguro:';
$_['entry_test']          = 'Modo de Teste:';
$_['entry_sort_order']    = 'Classificação:';


// Help
$_['help_encryption']    = 'Digite o seu TOKEN do UOL PagSeguro.';

$_['help_aguardando']    = 'Selecione um status para identificar um pedido que aguarda resposta do UOL PagSeguro.';

$_['help_cancelado']    = 'Selecione um status para identificar um pedido que foi cancelado pelo UOL PagSeguro.';

$_['help_aprovado']    = 'Selecione um status para identificar um pedido que foi aprovado pelo UOL PagSeguro e aguarda o pagamento.';
$_['help_analize']    = 'Seleciona um status para identificar um pedido que está em análise pelo UOL PagSeguro.';
$_['help_completo']    = 'Selecione um status para identificar um pedido que está com o pagamento completo';

// Error
$_['error_permission']    = 'Aviso: Você não permissão para alterar as configurações dos pagamentos com o UOL PagSeguro';
$_['error_email']         = 'Por favor, digite o e-mail cadastrado no UOL PagSeguro';

$_['error_encryption']   = 'Por favor, digite o TOKEN fornecido pelo UOL PagSeguro!';
?>