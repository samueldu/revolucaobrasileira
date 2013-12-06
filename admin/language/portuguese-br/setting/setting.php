<?php
// Heading
$_['heading_title']           = 'Configurações';

// Text
$_['text_success']            = 'Configurações atualizadas com sucesso!';
$_['text_image_manager']      = 'Editar imagem';
$_['text_default']            = 'Padrão';
$_['text_edit_store']         = 'Editar loja:';
$_['text_mail']               = 'Mail';
$_['text_smtp']               = 'SMTP';

// Entry
$_['entry_name']              = 'Nome da loja:';
$_['entry_url']               = 'URL da loja:<br /><span class="help">URL completo para a sua loja. Certifique-se de adicionar \'/\' no final. Exemplo: http://www.sualoja.com/</span>';
$_['entry_owner']             = 'Proprietário da loja:';
$_['entry_address']           = 'Endereço:';
$_['entry_email']             = 'E-mail:';
$_['entry_alert_emails']      = 'Alerta de e-mails adicionais:<br /><span class="help">Qualquer e-mail adicional em que você deseje receber mensagens de alerta, além do e-mail principal da loja. (separados por vírgula)</span>';
$_['entry_telephone']         = 'Telefone:';
$_['entry_fax']               = 'Fax:';
$_['entry_title']             = 'Título:';
$_['entry_meta_description']  = 'Meta descrição:';
$_['entry_meta_keywords']  = 'Meta keywords:';     
$_['entry_description']       = 'Descrição da loja:';
$_['entry_template']          = 'Tema:';
$_['entry_country']           = 'País:';
$_['entry_zone']              = 'Estado:';
$_['entry_language']          = 'Idioma da loja:';
$_['entry_admin_language']    = 'Idioma da administração:';
$_['entry_currency']          = 'Moeda:';
$_['entry_currency_auto']     = 'Auto-atualizar moeda:<br /><span class="help">Configurar sua loja para atualizar moedas diariamente.</span>';
$_['entry_weight_class']      = 'Unidade de peso:';
$_['entry_length_class']      = 'Unidade de medida:';
$_['entry_tax']               = 'Mostrar preços com impostos:';
$_['entry_order_stock']		  = 'Mostrar produtos com estoque por primeiro:';
$_['entry_invoice']           = 'Nº incial da fatura:<br /><span class="help">Escolha qual será o número que as faturas irão começar.</span>';
$_['entry_invoice_prefix']    = 'Prefixo da fatura:<br /><span class="help">Escolha qual será o prefixo. Exemplo: FAT/001</span>';
$_['entry_customer_group']    = 'Grupo de clientes:<br /><span class="help">Grupo de clientes default.</span>';
$_['entry_customer_price']    = 'Autenticar para mostrar preços:<br /><span class="help">Apenas mostrar os preços quando o cliente estiver autenticado.</span>';
$_['entry_customer_approval'] = 'Moderação de clientes:<br /><span class="help">Permitir que novos clientes acessem somente após aprovação de sua conta.</span>';
$_['entry_guest_checkout']    = 'Comprar como visitante:<br /><span class="help">Permitir que os clientes comprem sem possuir cadastro. Isso não estará disponível quando um produto para download está no carrinho de compras.</span>';
$_['entry_account']           = 'Termos de cadastro:<br /><span class="help">Exige concordância com os termos para que o usuário possa cadastrar-se .</span>';
$_['entry_checkout']          = 'Termos de compra:<br /><span class="help">Exige concordância com os termos para que uma compra possa ser finalizada.</span>';
$_['entry_order_status']      = 'Situação dos pedidos:<br /><span class="help">Definir a situação padrão do pedido quando uma compra é processada.</span>';
$_['entry_stock_display']     = 'Exibir estoque:<br /><span class="help">Exibir a quantidade em estoque na página do produto.</span>';
$_['entry_stock_checkout']    = 'Venda sem estoque:<br /><span class="help">Permitir aos clientes comprar mesmo quando fora de estoque.</span>';
$_['entry_stock_status']      = 'Situação do estoque:';
$_['entry_logo']              = 'Logotipo da loja:';
$_['entry_icon']              = 'Favicon:<br /><span class="help">Figura da barra de endereços. Deve ser uma imagem .png de 16x16 pixels.</span>';
$_['entry_image_thumb']       = 'Tamanho das miniaturas do produto:';
$_['entry_image_popup']       = 'Tamanho das imagens de ampliação:';
$_['entry_image_category']    = 'Tamanho das imagens das categorias:';
$_['entry_image_product']     = 'Tamanho das imagens na lista de produtos:';
$_['entry_image_additional']  = 'Tamanho das imagens adicionais de produtos:';
$_['entry_image_related']     = 'Tamanho das imagens dos produtos relacionados:';
$_['entry_image_cart']        = 'Tamanho das miniatura no carrinho:';
$_['entry_alert_mail']        = 'E-mail de alerta:<br /><span class="help">Enviar um e-mail para o proprietário da loja quando uma nova compra é realizada.</span>';
$_['entry_download']          = 'Permitir downloads:';
$_['entry_download_status']   = 'Situação dos downloads:<br /><span class="help">Definir a situação do pedido dos clientes antes de serem autorizados a realizar download.</span>';
$_['entry_mail_protocol']     = 'Protocolo de e-mail:<span class="help">Escolha "Mail" (recomendado) a menos que seu servidor de hospedagem tenha desabilitado a função "mail" do PHP.';
$_['entry_mail_parameter']    = 'Parâmetros de e-mail:<span class="help">Parâmetros adicionais para o protocolo "Mail" devem ser configurados aqui.';
$_['entry_smtp_host']         = 'Servidor SMTP:';
$_['entry_smtp_username']     = 'Usuário SMTP:';
$_['entry_smtp_password']     = 'Senha SMTP:';
$_['entry_smtp_port']         = 'Porta SMTP:';
$_['entry_smtp_timeout']      = 'Tempo de conexão SMTP:';
$_['entry_ssl']               = 'Usar SSL:<br /><span class="help">É necessário verificar com o servidor se o certificado SSL está instalado.</span>';
$_['entry_encryption']        = 'Chave de criptografia:<br /><span class="help">Chave secreta utilizada para encriptação dos dados durante as transações dos pedidos.</span>';
$_['entry_seo_url']           = 'Usar URL amigável:<br /><span class="help">O módulo "mod-rewrite" do Apache deve estar instalado e o arquivo ".htaccess.txt" deve ser renomeado para ".htaccess".</span>';
$_['entry_compression']       = 'Nível de compressão:<br /><span class="help">Compressão GZIP das páginas para maior eficiência. Nível de compressão deve estar entre 0 e 9.</span>';
$_['entry_error_display']     = 'Exibir mensagens de erro:';
$_['entry_error_log']         = 'Registrar erros em log:';
$_['entry_error_filename']    = 'Nome do arquivo de log:';
$_['entry_shipping_session']  = 'Usar sessão para o frete:<br /><span class="help">Salva cálculos de frete em sessão do browser. Cálculos somente serão refeitos se carrinho ou endereço for atualizado.</span>';
$_['entry_catalog_limit']     = 'Nº de itens por página (loja):';
$_['entry_admin_limit']       = 'Nº de itens por página (admin):';
$_['entry_cart_weight']       = 'Exibir peso no carrinho:';
$_['entry_review']            = 'Permitir opiniões:<br /><span class="help">Habilitar opiniões dos clientes sobre os produtos.</span>';
$_['entry_maintenance']       = 'Modo de manutenção:<br /><span class="help">Fecha o acesso à loja para realização de manutenção. A loja continuará visível ao usuário logado como administrador.</span>';
$_['entry_token_ignore']      = 'Ignorar tokens em:<br /><span class="help">Esta versão possui um sistema de token de segurança administrativa. Módulos que ainda não foram atualizados para uso de tokens podem ser marcados para ignorá-los.</span>';
$_['entry_stock_warning']     = 'Aviso de estoque no mínimo:';
$_['entry_risk']       = 'Usar gestor de risco:';    

// Integra��es Faceook
$_['entry_face_comm']       = 'Integração comentários:';  
$_['entry_face_comm_app']       = 'APP ID:';   


// Button
$_['button_add_store']        = 'Adicionar uma loja';

// Error
$_['error_permission']        = 'Atenção: Você não possui permissão para modificar as configurações!';
$_['error_name']              = 'Nome da loja deve possuir de 3 a 32 caracteres!';
$_['error_url']               = 'O campo <em>URL da loja</em> é obrigatório!';
$_['error_title']             = 'O título deve possuir de 3 a 32 caracteres!';
$_['error_owner']             = 'Proprietário da loja deve possuir de 3 a 64 caracteres!';
$_['error_address']           = 'Endereço da loja deve possuir de 10 a 256 caracteres!';
$_['error_email']             = 'E-mail aparenta não ser válido!';
$_['error_telephone']         = 'Telefone deve possuir de 3 a 32 caracteres!';
$_['error_image_thumb']       = 'O campo <em>Tamanho das miniaturas do produto</em> é obrigatório!';
$_['error_image_popup']       = 'O campo <em>Tamanho das imagens de ampliação</em> é obrigatório!';
$_['error_image_category']    = 'O campo <em>Tamanho das imagens das categorias</em> é obrigatório!';
$_['error_image_product']     = 'O campo <em>Tamanho das imagens da lista de produtos</em> é obrigatório!';
$_['error_image_additional']  = 'O campo <em>Tamanho das imagens adicionais dos produtos</em> é obrigatório!';
$_['error_image_related']     = 'O campo <em>Tamanho das imagens dos produtos relacionados</em> é obrigatório!';
$_['error_image_cart']        = 'O campo <em>Tamanho das miniaturas no carrinho</em> é obrigatório!';
$_['error_error_filename']    = 'O campo <em>Nome do arquivo de log</em> é obrigatório!';
$_['error_required_data']     = 'Alguns campos não foram preenchidos corretamente. Por favor, verifique os erros!';
$_['error_limit']             = 'O campo <em>Limite</em> é obrigatório!';
?>