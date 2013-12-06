<?php
class ControllerPaymentiPagare extends Controller {
    protected function index() {
        
        if($this->config->get('ipagare_debug'))
            trigger_error("--iPagare Invocado--", E_USER_NOTICE);
        
        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $this->data['button_back'] = $this->language->get('button_back');

        if($this->config->get('ipagare_teste') == 1)
        $this->data['teste'] = 1;
        else
        $this->data['teste'] = 0;
        
        if(isset($this->session->data['formaPagamento']))
        {
            $this->data['codigo_pagamento'] = $this->session->data['formaPagamento'];
        } 
        
        if(!isset($this->session->data['payment_parcel']))
        $this->session->data['payment_parcel'] = 1;
        
        if($this->session->data['payment_parcel'] <= 9)
        $this->data['forma_pagamento'] = "A0".$this->session->data['payment_parcel'];
        else
        $this->data['forma_pagamento'] = "A".$this->session->data['payment_parcel'];  
        
        $this->data['action'] = 'https://ww2.ipagare.com.br/service/process.do';
                          
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']); 
        
        if($order_info['cpfCnpj'] < 15)
        $tipo_cliente = "1";
        else
        $tipo_cliente = "2";
        
        $order_info['cpfCnpj'] = str_replace(array(".","-"),"",$order_info['cpfCnpj']);
        $order_info['shipping_postcode'] = str_replace(array(".","-"),"",$order_info['shipping_postcode']); 
        
        $this->data['tipo_cliente'] = $tipo_cliente;
        $this->data['nome_cliente'] = $order_info['firstname']." ".$order_info['lastname'];   
        $this->data['email_cliente'] = $order_info['email'];   
        $this->data['cpf_cnpj_cliente'] = $order_info['cpfCnpj'];   
            
        $this->data['logradouro_cobranca'] = $order_info['shipping_address_1'];   
        $this->data['numero_cobranca'] = $order_info['shipping_address_2']; 
        $this->data['complemento_cobranca'] = $order_info['shipping_address_3']; 
        $this->data['bairro_cobranca'] = $order_info['shipping_bairro']; 
        $this->data['cep_cobranca'] = $order_info['shipping_postcode']; 
        $this->data['cidade_cobranca'] = $order_info['shipping_city'];   
        
        $arrayEstados =   array("Acre" => "AC",
                        "Alagoas" => "AL",
                        "Amapá" => "AP",
                        "Amapa" => "AP",    
                        "Amazonas" => "AM",
                        "Bahia " => "BA",
                        "Ceará" => "CE",
                        "Ceara" => "CE", 
                        "Distrito Federal " => "DF",
                        "Espírito Santo" => "ES",
                        "Goiás" => "GO",
                        "Goias" => "GO",   
                        "Maranhão" => "MA",
                        "Maranhao" => "MA",  
                        "Mato Grosso" => "MT",
                        "Mato Grosso do Sul" => "MS",
                        "Minas Gerais" => "MG",
                        "Pará" => "PA",
                        "Para" => "PA",    
                        "Paraíba" => "PB",
                        "Paraiba" => "PB", 
                        "Paraná" => "PR",
                        "Parana" => "PR",
                        "Pernambuco" => "PE",
                        "Piauí" => "PI",
                        "Piaui" => "PI",   
                        "Rio de Janeiro" => "RJ",
                        "Rio Grande do Norte" => "RN",
                        "Rio Grande do Sul" => "RS",
                        "Rondônia" => "RO",
                        "Rondonia" => "RO", 
                        "Roraima" => "RR",
                        "Santa Catarina" => "SC",
                        "São Paulo" => "SP",
                        "Sao Paulo" => "SP",  
                        "Sergipe" => "SE",
                        "Tocantins" => "TO");
                        
        foreach($arrayEstados as $key=>$value)
        {
            if($order_info['shipping_zone'] == $key or utf8_decode($order_info['shipping_zone']) == $key)
            {                           
                $uf = $value; 
            }
        }
                        
        $this->data['uf_cobranca'] = $uf; 
        $this->data['pais_cobranca'] = "Brasil"; 
           
           $this->data['logradouro_entrega'] = $this->data['logradouro_cobranca'];
        $this->data['numero_entrega'] = $this->data['numero_cobranca'];    
        $this->data['complemento_entrega'] = $this->data['complemento_cobranca'];    
        $this->data['bairro_entrega'] = $this->data['bairro_cobranca'];    
        $this->data['cep_entrega'] = $this->data['cep_cobranca'];    
        $this->data['cidade_entrega'] = $this->data['cidade_cobranca'];    
        $this->data['uf_entrega'] = $this->data['uf_cobranca'];    
        $this->data['pais_entrega'] = $this->data['pais_cobranca'];   
        
        $order_info['telephone'] = str_replace(array("(",")","-"," "),"",$order_info['telephone']); 
        $order_info['fax'] = str_replace(array("(",")","-"," "),"",$order_info['fax']); 
        
        $this->data['ddd_telefone_1'] = substr($order_info['telephone'],0,2);
        $this->data['numero_telefone_1'] = substr($order_info['telephone'],2); 
          $this->data['ddd_telefone_2'] = substr($order_info['fax'],0,2);
        $this->data['numero_telefone_2'] = substr($order_info['fax'],2); 
        
          $this->data['estabelecimento'] = $this->config->get('ipagare_estabelecimento');
        $this->data['valor_total'] = str_replace(".", "", $this->currency->format($order_info['total'], $order_info['currency'], $order_info['value'], FALSE));
        $this->data['chave'] =  md5($this->data['estabelecimento'].md5($this->config->get('ipagare_chave'))."1".$this->data['valor_total']);
        $this->data['codigo_pedido'] = $this->session->data['order_id'];
        $this->data['nome_cliente'] = $order_info['firstname'] . ' ' . $order_info['lastname'];
                
        
        if ($this->request->get['route'] != 'checkout/guest_step_3') {
            $this->data['cancel_return'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
        } else {
            $this->data['cancel_return'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
        }
        
        $this->load->library('encryption');
        
        if ($this->request->get['route'] != 'checkout/guest_step_3') {
            $this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/shipping';
        } else {
            $this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
        }
        
        $this->id = 'payment';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/ipagare.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/ipagare.tpl';
        } else {
            $this->template = 'default/template/payment/ipagare.tpl';
        }    
        
        $this->render();    
    }
    
    public function notify(){
        
        if($this->config->get('ipagare_debug'))
        {
        trigger_error("iPagare NOTIFY Invocado com os Valores:", E_USER_NOTICE);
        foreach ($_REQUEST as $key => $value) {
            trigger_error("Key: $key; Value: $value", E_USER_NOTICE);
        }
        trigger_error("iPagare NOTIFY fim:", E_USER_NOTICE);
        }
        
        $message = "";
        
        foreach($_REQUEST as $key=>$value)
        {
            $message .= $key." ".$value;
            $$key = $value;
        }
        
        foreach($_POST as $key=>$value)
        {
            $$key = $value;
            $_REQUEST[$key] = $value;
        }
        
        /*
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');                
        $mail->setTo("samueldu@gmail.com");
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($this->config->get('config_name'));
        $mail->setSubject('teste');
        $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $mail->send();
        */
        
        $this->load->model('checkout/order');
        $comment = "";
        
        if(isset($codigo_pedido))
        {
            
        $idForma = $this->model_checkout_order->getForma($_REQUEST['codigo_pedido']);    
        
        if($idForma == "1" or $idForma == "2" or $idForma == "3" or $idForma == "4" or $idForma == "5" or $idForma == "6" or $idForma == "11" or $idForma == "14" or $idForma == "34" 
    or $idForma == "36" or $idForma == "40" or $idForma == "17" or $idForma == "7" or $idForma == "39" or $idForma == "10" or $idForma == "15" or $idForma == "14" or $idForma == "13" or $idForma == "9")
    {
        $addIpagare = "_";
    }
    else
    {
        $addIpagare ="_web_";
    }

        
        if(isset($_REQUEST['codigo_status']))
        $comment .= "<br/>Codigo Status: ".$_REQUEST['codigo_status'];
        
        if(isset($_REQUEST['codigo_pagamento']))
        $comment .= "<br/>Codigo Pagamento: ".$_REQUEST['codigo_pagamento'];
        
        if(isset($_REQUEST['forma_pagamento']))   
        $comment .= "<br/>Forma Pagamento: ".$_REQUEST['forma_pagamento'];
        
        if(isset($_REQUEST['capturado']))   
        $comment .= "<br/>Capturado: ".$_REQUEST['capturado'];
        
        if(isset($_REQUEST['numero_autorizacao']))  
        $comment .= "<br/>Numero Autorizacao: ".$_REQUEST['numero_autorizacao'];
        
        if(isset($_REQUEST['numero_transacao']))  
        $comment .= "<br/>Numero Transacao: ".$_REQUEST['numero_transacao'];
        
        if(isset($_REQUEST['numero_cv']))  
        $comment .= "<br/>Numero CV: ".$_REQUEST['numero_cv'];
        
        if(!isset($_REQUEST['codigo_status']))
        $_REQUEST['codigo_status'] = 0;
        
        if(isset($_REQUEST['codigo_pagamento']) and isset($_REQUEST['forma_pagamento']))
        {
        
            if(!isset($_REQUEST['capturado']))
            $_REQUEST['capturado'] = 0;
        
            $this->model_checkout_order->ipagare($_REQUEST['codigo_pedido'], $_REQUEST['codigo_pagamento'], $_REQUEST['forma_pagamento'],$_REQUEST['codigo_status'],$_REQUEST['capturado']);
        }
        
        $status = 0;
        
        if ($_REQUEST['codigo_status'] == 1) {$status = $this->config->get('ipagare'.$addIpagare.'entry_order_status_aguardando'); $comment .= "<br>Aguardando Pagamento";} //Aguardando Pagamento
            else
        if ($_REQUEST['codigo_status'] == 2) {$status = $this->config->get('ipagare'.$addIpagare.'entry_order_status_aguardando'); $comment .= "<br>Aguardando Confirmacao do Pagamento";} //Aguardando Confirmacao Pagamento
            else
        if ($_REQUEST['codigo_status'] == 3 and !isset($_REQUEST['capturado'])) {$status = $this->config->get('ipagare'.$addIpagare.'entry_order_status_aprovado'); $comment .= "<BR>Pagamento Autorizado";} //Pagamento Confirmado
            else
        if ($_REQUEST['codigo_status'] == 3 && $_REQUEST['capturado'] == 0) {$status = $this->config->get('ipagare'.$addIpagare.'entry_order_status_aprovado'); $comment .= "<br>Aguardando Captura";} //Pagamento Confirmado
            else
        if ($_REQUEST['codigo_status'] == 3 && $_REQUEST['capturado'] == 1) {$status = $this->config->get('ipagare'.$addIpagare.'entry_order_status_capturado'); $comment .= "<br>Pagamento Capturado"; }
            else
        if ($_REQUEST['codigo_status'] == 4) {$status = $this->config->get('ipagare'.$addIpagare.'entry_order_status_reprovado');  $comment .= "<br>Pagamento Cancelado Reprovado";}//Cancelado
            else
        if ($_REQUEST['codigo_status'] == 5) {$status = $this->config->get('ipagare'.$addIpagare.'entry_order_status_cancelado'); $comment .= "<BR>Pagamento Expirou";} //Pagamento Expirado          
        
        $this->model_checkout_order->update($_REQUEST['codigo_pedido'], $status, $comment, TRUE);
        
        echo "OK";    
        
        }    
    }
    
    public function success(){
        if($this->config->get('ipagare_debug'))
        {
            trigger_error("iPagare SUCCESS Invocado com os Valores:", E_USER_NOTICE);
            foreach ($_REQUEST as $key => $value) {
                trigger_error("Key: $key; Value: $value", E_USER_NOTICE);
            }
            trigger_error("iPagare SUCCESS Fim", E_USER_NOTICE);
        }
//        $this->load->model('checkout/order');
//        $this->model_checkout_order->confirm($_POST['codigo_pedido'], $this->config->get('ipagare_entry_order_status_aprovado'), "Recebido Sucesso Confirmacao iPagare");
        
//        $this->model_checkout_order->update($_POST['codigo_pedido'], $this->config->get('ipagare_entry_order_status_aprovado'), "Recebido Sucesso Confirmacao iPagare");
        
        
        $endereco = HTTPS_SERVER . 'index.php?route=checkout/success';
    
        echo "<html>";
        echo "<head>";
        echo "<script language=\"JavaScript\">window.top.location.href = \"".$endereco."\"</script>";
        echo "</head>";
        echo "<body>";    
        echo "Por favor aguarde, processando compra...";
        echo "</body>";
        echo "</html>";
    }
    
    public function fail(){
        
        $comment = "";
    
        if($this->config->get('ipagare_debug'))
        {
        trigger_error("iPagare FAIL Invocado com os Valores:", E_USER_NOTICE);
        foreach ($_REQUEST as $key => $value) {
            trigger_error("Key: $key; Value: $value", E_USER_NOTICE);
        }
        trigger_error("iPagare FAIL Fim", E_USER_NOTICE);
        }
    
        $this->load->model('checkout/order');
        
        foreach($_REQUEST as $key=>$value)
        {
            $comment .= "<BR>".ucwords(str_replace("_"," ",$key)).":".utf8_encode($value);
            $$key = $value;
        }
        
        foreach($_POST as $key=>$value)
        {
            $$key = $value;
            $_REQUEST[$key] = $value;
        }
                
        $this->model_checkout_order->update($_REQUEST['codigo_pedido'], $this->config->get('ipagare_entry_order_status_reprovado'), $comment, TRUE);
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/ipagare_fail.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/ipagare_fail.tpl';
        } else {
            $this->template = 'default/template/payment/ipagare_fail.tpl';
        }    
        
        $this->render();
        
    }
    
    public function confirm(){
        
        unset($this->session->data['retorno']);   
        
        if(!$this->cart->hasStock())
        {
            print "NO";
        }
        else 
        {        
            if(!isset($this->session->data['payment_parcel']))
            $this->session->data['payment_parcel'] = 1;
            
            if($this->session->data['payment_parcel'] <= 9)
            $this->data['forma_pagamento'] = "A0".$this->session->data['payment_parcel'];
            else
            $this->data['forma_pagamento'] = "A".$this->session->data['payment_parcel'];
                
            $this->load->model('checkout/order');
            $this->model_checkout_order->ipagare($this->session->data['order_id'], $this->session->data['formaPagamento'], $this->data['forma_pagamento'],0,0); 
            $this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('ipagare_entry_order_status_aguardando'), "Iniciando Pagamento");
            print "OK";
        }
    }
}
?>