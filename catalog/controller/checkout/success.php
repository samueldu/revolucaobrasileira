<?php 
class ControllerCheckoutSuccess extends Controller { 
	public function index() {                       
		if (isset($this->session->data['order_id'])) {

			$this->load->model('checkout/order');
			
		    $this->session->data['orderDetails'] = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		    $this->session->data['orderProducts'] = $this->model_checkout_order->getOrderProducts($this->session->data['order_id']);
			$this->cart->clear();
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);

			unset($this->session->data['coupon']); 

			$id = $this->session->data['order_id'];   
			unset($this->session->data['order_id']);  
			             
			
			/* analise de risco */
			if($this->config->get('config_risk_status') == '1' and !isset($this->session->data['retorno']['erro']))
			{		
			
			$this->load->model('checkout/risk'); 
				
				if($this->config->get('config_risk_partner') == "TgClearSale")
				{

					$xmlEnvio = $this->model_checkout_risk->enviaClearSaleTg($id);	
					
					$entityCode        = $this->config->get("config_clear_sale_entity");
					$urlSendOrders    = 'http://homologacao.clearsale.com.br/integracaov2/service.asmx/SendOrders';
					$parametros        = 'entityCode='.$this->config->get('config_clear_sale_entity').'&xml='.$xmlEnvio;

					//print $xmlEnvio;

					$ch = curl_init();
					curl_setopt ($ch, CURLOPT_URL, $urlSendOrders);
					curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt ($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
					curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt ($ch, CURLOPT_POSTFIELDS, $parametros);
					curl_setopt ($ch, CURLOPT_POST, 1);
					$retornoClearSale = curl_exec($ch);

					print_r($retornoClearSale);
					
					preg_match("!&lt;Score&gt;(.+)&lt;/Score&gt;!", $retornoClearSale, $score);
                    preg_match("!&lt;Status&gt;(.+)&lt;/Status&gt;!", $retornoClearSale, $status);

					curl_close($ch);

					if($score[1]) {
                    $retornoCS = $this->model_checkout_risk->gravaScore($id,$score[1],$status[1]);
					}
				}  
		}	
			
		unset($this->session->data['retorno']); 
		
		$this->session->data['finalizado'] = "ok";

		$this->redirect(HTTPS_SERVER . 'account/invoice?order_id='.$id); 
		
		$this->language->load('checkout/success');
		
		$this->document->title = $this->language->get('heading_title');
		
		$this->document->breadcrumbs = array(); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	); 

		
      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=checkout/cart',
        	'text'      => $this->language->get('text_basket'),
        	'separator' => $this->language->get('text_separator')
      	);
		
		if ($this->customer->isLogged()) {
			$this->document->breadcrumbs[] = array(
				'href'      => HTTP_SERVER . 'index.php?route=checkout/shipping',
				'text'      => $this->language->get('text_shipping'),
				'separator' => $this->language->get('text_separator')
			);
	
			$this->document->breadcrumbs[] = array(
				'href'      => HTTP_SERVER . 'index.php?route=checkout/payment',
				'text'      => $this->language->get('text_payment'),
				'separator' => $this->language->get('text_separator')
			);
	
			$this->document->breadcrumbs[] = array(
				'href'      => HTTP_SERVER . 'index.php?route=checkout/confirm',
				'text'      => $this->language->get('text_confirm'),
				'separator' => $this->language->get('text_separator')
			);
		} else {
			$this->document->breadcrumbs[] = array(
				'href'      => HTTP_SERVER . 'index.php?route=checkout/guest',
				'text'      => $this->language->get('text_guest'),
				'separator' => $this->language->get('text_separator')
			);
	
			$this->document->breadcrumbs[] = array(
				'href'      => HTTP_SERVER . 'index.php?route=checkout/guest/confirm',
				'text'      => $this->language->get('text_confirm'),
				'separator' => $this->language->get('text_separator')
			);			
		}
		
      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=checkout/success',
        	'text'      => $this->language->get('text_success'),
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_message'] = sprintf($this->language->get('text_message'), HTTPS_SERVER . 'index.php?route=account/account', HTTPS_SERVER . 'index.php?route=account/history', HTTP_SERVER . 'index.php?route=information/contact');
    	
    	if(isset($this->session->data['retorno']['erro']))
    	{
    		$this->data['text_message'] .= "Seu pagamento n&atilde;o foi processado com sucesso.<BR>";
    		$this->data['text_message'] .= "Descri&ccedil;&atilde;o:".$this->session->data['retorno']['erro']['descricao']." (c&oacute;digo ".$this->session->data['retorno']['erro']['codigo'].")<BR>";
 		}
		else
		{
			$this->data['text_message'] .= "Seu pagamento foi processado com sucesso";   
			
 		}
    		
    	$this->data['button_continue'] = $this->language->get('button_continue');

    	$this->data['continue'] = HTTP_SERVER . 'index.php?route=common/home';
    	
    	/*
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}
		
		*/
        		
		$this->children = array(
			'common/column_right',
			'common/footer',
			'common/column_left',
			'common/header'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  		}
  		else
  		{
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);

			unset($this->session->data['coupon']); 
 
			unset($this->session->data['order_id']);  
			$this->redirect(HTTP_SERVER);
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression')); 
  		}
	}
}
?>