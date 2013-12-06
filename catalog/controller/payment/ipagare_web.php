<?php
class ControllerPaymentiPagareWeb extends Controller {
		
	protected function index() {
		
		if($this->config->get('ipagare_web_debug'))
			trigger_error("--iPagare Invocado--", E_USER_NOTICE);
		
    	$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		if($this->config->get('ipagare_web_teste') == 1)
		$this->data['teste'] = 1;
		else
		$this->data['teste'] = 0;
		
		$this->data['action'] = 'https://ww2.ipagare.com.br/service/process.do';
  						
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
  	    $this->data['estabelecimento'] = $this->config->get('ipagare_web_estabelecimento');
		$this->data['valor_total'] = str_replace(".", "", $this->currency->format($order_info['total'], $order_info['currency'], $order_info['value'], FALSE));
		$this->data['chave'] =  md5($this->data['estabelecimento'].md5($this->config->get('ipagare_web_chave'))."1".$this->data['valor_total']);
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

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/ipagare_web.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/ipagare_web.tpl';
		} else {
			$this->template = 'default/template/payment/ipagare_web.tpl';
		}	
		
		$this->render();	
	}
	
	public function enviaPagamento()
	{
		
		$url = 'https://ww2.ipagare.com.br/service/process.do';  
		
		$this->load->model('checkout/order');  
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']); 
		
		if($this->config->get('ipagare_web_teste') == 1)
		{
		$dados['teste'] = 1;
		}
		
		if($order_info['cpfCnpj'] < 15)
		$tipo_cliente = "1";
		else
		$tipo_cliente = "2";
		
		$order_info_products = $this->model_checkout_order->getOrderProducts($this->session->data['order_id']);
		
		$dados['numero_itens'] = count($order_info_products);
		
		$count = 0;
		
		foreach($order_info_products as $key=>$value)
		{
			$keyDado = $key+1;
			$dados['codigo_item_'.$keyDado] = $order_info_products[$key]['model'];
			$dados['descricao_item_'.$keyDado] = $order_info_products[$key]['name'];
			$dados['quantidade_item_'.$keyDado] = $order_info_products[$key]['quantity']."00";
			$dados['valor_item_'.$keyDado] = str_replace(".", "", $this->currency->format($order_info_products[$key]['price'], $order_info['currency'], $order_info['value'], FALSE));
		}
		
		$order_info['cpfCnpj'] = str_replace(array(".","-"),"",$order_info['cpfCnpj']);
		$order_info['shipping_postcode'] = str_replace(array(".","-"),"",$order_info['shipping_postcode']); 
		
		$dados['tipo_cliente'] = $tipo_cliente;
		$dados['nome_cliente'] = $order_info['firstname']." ".$order_info['lastname'];   
		$dados['email_cliente'] = $order_info['email'];   
		$dados['cpf_cnpj_cliente'] = $order_info['cpfCnpj'];  
		
		$dados['codigo_pedido'] = $this->session->data['order_id'];    
			
		$dados['logradouro_cobranca'] = $order_info['shipping_address_1'];   
        $dados['numero_cobranca'] = $order_info['shipping_address_2']; 
        $dados['complemento_cobranca'] = $order_info['shipping_address_3']; 
        $dados['bairro_cobranca'] = $order_info['shipping_bairro']; 
        $dados['cep_cobranca'] = $order_info['shipping_postcode']; 
        $dados['cidade_cobranca'] = $order_info['shipping_city'];       
        
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
		
		if($this->session->data['payment_parcel'] <= 9)
		$forma = "A0".$this->session->data['payment_parcel'];
		else
		$forma = "A".$this->session->data['payment_parcel'];  
						
        $dados['uf_cobranca'] = $uf; 
        $dados['pais_cobranca'] = "Brasil"; 
   		
   		$dados['logradouro_entrega'] = $dados['logradouro_cobranca'];
		$dados['numero_entrega'] = $dados['numero_cobranca'];    
		$dados['complemento_entrega'] = $dados['complemento_cobranca'];    
		$dados['bairro_entrega'] = $dados['bairro_cobranca'];    
		$dados['cep_entrega'] = $dados['cep_cobranca'];    
		$dados['cidade_entrega'] = $dados['cidade_cobranca'];    
		$dados['uf_entrega'] = $dados['uf_cobranca'];    
		$dados['pais_entrega'] = $dados['pais_cobranca'];   
		
		$order_info['telephone'] = str_replace(array("(",")","-"," "),"",$order_info['telephone']); 
		$order_info['fax'] = str_replace(array("(",")","-"," "),"",$order_info['fax']); 
		
		$dados['ddd_telefone_1'] = substr($order_info['telephone'],0,2);
		$dados['numero_telefone_1'] = substr($order_info['telephone'],2); 
      	$dados['ddd_telefone_2'] = substr($order_info['fax'],0,2);
		$dados['numero_telefone_2'] = substr($order_info['fax'],2); 
		
		$dados['estabelecimento'] = $this->config->get('ipagare_web_estabelecimento'); 
		$dados['acao'] = "2";
		$dados['valor_total'] = str_replace(".", "", $this->currency->format($order_info['total'], $order_info['currency'], $order_info['value'], FALSE)); 
		$dados['versao'] = "2";
		$dados['chave'] =  md5($dados['estabelecimento'].md5($this->config->get('ipagare_web_chave'))."2".$dados['valor_total']."2");
		$dados['codigo_pagamento'] = $this->session->data['payment_id'];
		$dados['forma_pagamento'] = $forma;
		$dados['numero_cartao'] = str_replace("-","",$this->session->data['payment_numberCard']);
		$dados['mes_validade_cartao'] = $this->session->data['payment_monthCard'];
		$dados['ano_validade_cartao'] = $this->session->data['payment_yearCard'];
		$dados['codigo_seguranca_cartao'] = $this->session->data['payment_securityCode'];
		$dados['desconto_avista_opcao_n'] = "0";
		
		$parametros = "";
			
		foreach ($dados as $chave => $valor) {
			$parametros .= $chave.'='.$valor.'&';
		}

   		$parametros = substr($parametros,0,-1);
		
		$resultadoHTML = $this->EnviarPost($url,$parametros);    
		
		$xmlObj    = new XmlToArray($resultadoHTML);

		$this->session->data['retorno'] = $xmlObj->createArray();
		
		if(isset($this->session->data['retorno']['erro']))
		{
		
			if($this->session->data['retorno']['erro']['codigo'] != "201")
			{
			
			$texto = "Falha no processamento do pagamento \r\n";
			$texto .= "Codigo: ".$this->session->data['retorno']['erro']['codigo']."\r\n";
			$texto .= "Descricao: ".$this->session->data['retorno']['erro']['descricao']."\r\n";
			if(isset($this->session->data['retorno']['erro']['tentativa-pagamento']))
			{
				$texto .= "UID: ".$this->session->data['retorno']['erro']['tentativa-pagamento'][0]['uid-pedido']."\r\n";
				$texto .= "Codigo Financeira: ".$this->session->data['retorno']['erro']['tentativa-pagamento'][0]['codigo-financeira']."\r\n";    
				$texto .= "Mensagem Financeira ".$this->session->data['retorno']['erro']['tentativa-pagamento'][0]['mensagem-financeira']."\r\n";      			
			}
			
			if(isset($this->session->data['retorno']['erro']['parametros']))
			{
				$texto .= "Descrição erro: ".$this->session->data['retorno']['erro']['parametros'][0]['parametro']."\r\n";    			
			}

			$this->model_checkout_order->update($this->session->data['order_id'], $this->config->get('ipagare_web_entry_order_status_reprovado'), $texto); 
			}
			
			print "ERRO"; 
		}
		elseif(!isset($this->session->data['retorno']['erro']))
		{
			$texto = "Pagamento Recebido com Sucesso \r\n";
			
			if(isset($this->session->data['retorno']['pedido']['uid']))			
			$texto .= "UID: ".$this->session->data['retorno']['pedido']['uid']."\r\n";
						
			if(isset($this->session->data['retorno']['pedido']['total']))
			$texto .= "Total Pago: ".$this->session->data['retorno']['pedido']['total']."\r\n";
			
			if(isset($this->session->data['retorno']['pedido']['status']))
			$texto .= "Status: ".$this->session->data['retorno']['pedido']['status']." (as ".$this->session->data['retorno']['pedido']['data-status']." ".$this->session->data['retorno']['pedido']['hora-status'].")\r\n";   
			
			if(isset($this->session->data['retorno']['pedido']['pagamento'][0]['codigo']))
			$texto .= "Meio de pagamento: ".$this->session->data['retorno']['pedido']['pagamento'][0]['codigo'];
			
			if(isset($this->session->data['retorno']['pedido']['pagamento'][0]['forma']))
			$texto .= "Forma de pagamento: ".$this->session->data['retorno']['pedido']['pagamento'][0]['forma'];  
			
			if(isset($this->session->data['retorno']['pedido']['pagamento'][0]['data']))
			$texto .= "Data de pagamento: ".$this->session->data['retorno']['pedido']['pagamento'][0]['data']. " ".$this->session->data['retorno']['pedido']['pagamento'][0]['hora'];  
			
			if(isset($this->session->data['retorno']['pedido']['pagamento'][0]['total']))
			$texto .= "Total: ".$this->session->data['retorno']['pedido']['pagamento'][0]['total'];
			
			if(isset($this->session->data['retorno']['pedido']['pagamento'][0]['capturado']))
			$texto .= "Capturado: ".$this->session->data['retorno']['pedido']['pagamento'][0]['capturado']; 			
			
			if(isset($this->session->data['retorno']['pedido']['pagamento'][0]['parametros'][0]['numero-autorizacao']))
			$texto .= "Autorização: ".$this->session->data['retorno']['pedido']['pagamento'][0]['parametros'][0]['numero-autorizacao'];
			
			if(isset($this->session->data['retorno']['pedido']['pagamento'][0]['parametros'][0]['numero-cv']))
			$texto .= "Numero CV: ".$this->session->data['retorno']['pedido']['pagamento'][0]['parametros'][0]['numero-cv'];  
			
			if(isset($this->session->data['retorno']['pedido']['pagamento'][0]['parametros'][0]['codigo-retorno']))
			$texto .= "Codigo retorno: ".$this->session->data['retorno']['pedido']['pagamento'][0]['parametros'][0]['codigo-retorno'];  
			
			$this->model_checkout_order->update($this->session->data['order_id'], $this->config->get('ipagare_web_entry_order_status_aprovado'), "Pagamento Recebido com Sucesso."); 
			print "OK";           
		}
	}
	
	public function confirm(){
		
		unset($this->session->data['retorno']);
		
		if(!isset($this->session->data['payment_parcel']))
		$this->session->data['payment_parcel'] = 1;
		
		if($this->session->data['payment_parcel'] <= 9)
		$forma = "A0".$this->session->data['payment_parcel'];
		else
		$forma = "A".$this->session->data['payment_parcel'];  
		
		if(!$this->cart->hasStock())
		{
			print "NO";
		}
		else 
		{	
			$this->load->model('checkout/order');
			$this->model_checkout_order->ipagare($this->session->data['order_id'], $this->session->data['formaPagamento'], $forma,0,0);     
			$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('ipagare_web_entry_order_status_aguardando'), "");
			print "OK";
		}
	}

	public function EnviarPost($url, $postdata = '')

    {

        $ch = curl_init();

        curl_setopt ($ch, CURLOPT_URL, $url);

        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt ($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        curl_setopt ($ch, CURLOPT_TIMEOUT, 60);

        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 

        curl_setopt ($ch, CURLOPT_POST, true);

        $return = curl_exec($ch);

        curl_close($ch);

        return $return;

    }
}

		class XmlToArray
		{	
		var $xml='';     
		   
		    function XmlToArray($xml)
		    {
		       $this->xml = $xml;   
		    }
		   
		    function _struct_to_array($values, &$i)
		    {
		        $child = array();
		        if (isset($values[$i]['value'])) array_push($child, $values[$i]['value']);
		       
		        while ($i++ < count($values)) {
		            switch ($values[$i]['type']) {
		                case 'cdata':
		                array_push($child, $values[$i]['value']);
		                break;
		               
		                case 'complete':
		                    $name = $values[$i]['tag'];
		                    if(!empty($name)){
		                    $child[$name]= ($values[$i]['value'])?($values[$i]['value']):'';
		                    if(isset($values[$i]['attributes'])) {                   
		                        $child[$name] = $values[$i]['attributes'];
		                    }
		                }   
		              break;
		               
		                case 'open':
		                    $name = $values[$i]['tag'];
		                    $size = isset($child[$name]) ? sizeof($child[$name]) : 0;
		                    $child[$name][$size] = $this->_struct_to_array($values, $i);
		                break;
		               
		                case 'close':
		                return $child;
		                break;
		            }
		        }
		        return $child;
			}

		    function createArray()
		    {
		        $xml    = $this->xml;
		        $values = array();
		        $index  = array();
		        $array  = array();
		        $parser = xml_parser_create();
		        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		        xml_parse_into_struct($parser, $xml, $values, $index);
		        xml_parser_free($parser);
		        $i = 0;
		        $name = $values[$i]['tag'];
		        $array[$name] = isset($values[$i]['attributes']) ? $values[$i]['attributes'] : '';
		        $array[$name] = $this->_struct_to_array($values, $i);
		        return $array;
			}
		   
		   
		}
?>