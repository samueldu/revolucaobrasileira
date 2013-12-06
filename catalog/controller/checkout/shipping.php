<?php 
class ControllerCheckoutShipping extends Controller {
	private $error = array();
 	
  	public function index() {
        
        $this->language->load('checkout/shipping');   
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            
			$shipping = explode('.', $this->request->post['shipping_method']);      
            
            $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
            
            //print $this->session->data['shipping_method'];
            
            //exit;

            $dataCoupon = $this->validateCoupon();
            if (isset($this->request->post['coupon']) && is_array($dataCoupon)) {
                              
            $this->session->data['coupon'] = $this->request->post['coupon'];

			$valorCupom = explode(".", $dataCoupon["discount"]);
			if($valorCupom[1] > 0)
				$valorCupom = $valorCupom[0].",".substr($valorCupom[1],0,2);
			else if($dataCoupon["type"] == "F")
				$valorCupom = $valorCupom[0].",00";
			else
				$valorCupom = $valorCupom[0];
				
			if($dataCoupon["type"] == "F")
            	$this->session->data['valueCoupon'] = "R$ ".$valorCupom;
            else 
            	$this->session->data['valueCoupon'] = $valorCupom." %";

            $this->session->data['success'] = $this->language->get('text_success');
            
            $this->session->data['cupomValido'] = 1;  
            
            if($this->session->data['success'] == "text_success")
            unset($this->session->data['success']);
  
        }
        else         
        {
           
            if($this->request->post['coupon'] != "")
            {
                $this->error['warning'] = $this->language->get('error_coupon'); 
            }
            else
            {
              // $this->error['warning'] = $this->language->get('error_coupon_empty');  
            }
            unset($this->session->data['coupon']);     
        }
            
			$this->session->data['comment'] = strip_tags($this->request->post['comment']);

	  	//	$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/confirm');
    	}
    	
        if(isset($this->session->data['erro']))
		{
			if($this->session->data['erro'] == "error_shipping")
			{
			unset($this->session->data['erro']);
			$this->error['warning'] = $this->language->get('error_shipping');   
			}
		}
        
        if(isset($this->session->data['warning']))         
        {
            $this->error['warning'] = $this->language->get('error_coupon'); 
            unset($this->session->data['warning']);
        } 
    	
    			
		if (!$this->cart->hasProducts() || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
	  		$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/cart');
    	}
		
		if (!$this->customer->isLogged()) {
			
			if (isset($this->session->data['guest'])) {
				$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/guest_step_1');
			}
			
			$this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=checkout/shipping';

	  		$this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
    	} 
    	
    /* metodo para saber se o produto tem ou n�o frete, bugado */

    /*	if (!$this->cart->hasShipping()) {
			unset($this->session->data['shipping_address_id']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);

			$this->tax->setZone($this->config->get('config_country_id'), $this->config->get('config_zone_id'));

			$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/confirm');
    	}
    */

		if (!isset($this->session->data['shipping_address_id'])) {
			$this->session->data['shipping_address_id'] = $this->customer->getAddressId();
		}
	
    	if (!$this->session->data['shipping_address_id']) {
	  		$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/address/shipping');
		}

		$this->load->model('account/address');
		
		$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);		

    	if (!$shipping_address) {
	  		$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/address/shipping');
    	}	
		
		$this->tax->setZone($shipping_address['country_id'], $shipping_address['zone_id']);
		
		$this->load->model('checkout/extension');
		
		if (!isset($this->session->data['shipping_methods']) || !$this->config->get('config_shipping_session')) {
			$quote_data = array();
			
			$results = $this->model_checkout_extension->getExtensions('shipping');
			
			foreach ($results as $result) {
				$this->load->model('shipping/' . $result['key']);
				
				$quote = $this->{'model_shipping_' . $result['key']}->getQuote($shipping_address); 
	
				if ($quote) {
					$quote_data[$result['key']] = array(
						'title'      => $quote['title'],
						'quote'      => $quote['quote'], 
						'sort_order' => $quote['sort_order'],
						'error'      => $quote['error']
					);
				}
			}
	
			$sort_order = array();
		  
			foreach ($quote_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
	
			array_multisort($sort_order, SORT_ASC, $quote_data);
			
			$this->data['shipping_methods'] = $quote_data;			
			
			$this->data['frete_unico'] = 1;
			
			//Q: Autochoose shipping if using only one and it's single rate
			if (count($quote_data) == 1) {
			   $values = array_values($quote_data);
			   if (count($values[0]['quote']) == 1) {
			      $keys = array_keys($values[0]['quote']);
			      $method = $values[0]['quote'][$keys[0]];
			      $this->session->data['shipping_method'] = $method;
			      $this->session->data['comment'] = (isset($this->session->data['comment'])) ? $this->session->data['comment'] : '';
			 //     $this->redirect(HTTPS_SERVER . 'index.php?route=checkout/payment');
			   }
			}
			else
			{
				$this->data['frete_unico'] = 0;
			}//
			
		}
		
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

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=checkout/shipping',
        	'text'      => $this->language->get('text_shipping'),
        	'separator' => $this->language->get('text_separator')
      	);
				
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	$this->data['text_shipping_to'] = $this->language->get('text_shipping_to');
    	$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');
    	$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
    	$this->data['text_shipping_methods'] = $this->language->get('text_shipping_methods');
    	$this->data['text_comments'] = $this->language->get('text_comments');
    	
    	$this->data['text_numberCard'] = $this->language->get('text_numberCard');
    	$this->data['text_nome'] = $this->language->get('text_nome');
    	$this->data['text_securityCode'] = $this->language->get('text_securityCode');
    	$this->data['text_shipping'] = $this->language->get('text_shipping');
    	
    	if(isset($this->session->data['payment_numberCard']))
    	$this->data['payment_numberCard'] = $this->session->data['payment_numberCard'];
    	
     	if(isset($this->session->data['payment_parcel']))
    	$this->data['payment_parcel'] = $this->session->data['payment_parcel'];
    	
     	if(isset($this->session->data['payment_nameCard']))
    	$this->data['payment_nameCard'] = $this->session->data['payment_nameCard'];
    	
     	if(isset($this->session->data['payment_yearCard']))
    	$this->data['payment_yearCard'] = $this->session->data['payment_yearCard'];
    	
     	if(isset($this->session->data['payment_monthCard']))
    	$this->data['payment_monthCard'] = $this->session->data['payment_monthCard'];
    	
     	if(isset($this->session->data['payment_securityCode']))
    	$this->data['payment_securityCode'] = $this->session->data['payment_securityCode'];
    	
   // 	if(isset($this->session->data['payment_id']))
    //	$this->data['payment_id'] = $this->session->data['payment_id'];
    	
    	if(isset($this->request->post['formaPagamento']))
    	$this->data['payment_id'] = $this->request->post['formaPagamento'];
    	
    	if(!isset($this->data['payment_id']))
    	$this->data['payment_id'] = 38;

    	$this->data['coupon_title'] = $this->language->get('coupon_title'); 
    	$this->data['coupon_text'] = $this->language->get('coupon_text'); 
    	
    	$this->data['carrinho_title'] = $this->language->get('carrinho_title'); 
    	$this->data['carrinho_text'] = $this->language->get('carrinho_text');
    	
    	$this->data['text_coupon'] = $this->language->get('text_coupon');
    	if(isset($this->session->data['coupon'])){
    		$this->data['text_coupon'] = $this->language->get('text_coupon_aplicado');
    	}
    			
    	$this->data['button_coupon'] = $this->language->get('button_coupon');
    	
    	$this->data['entry_coupon'] = $this->language->get('entry_coupon');
    
		$this->data['button_change_address'] = $this->language->get('button_change_address');
    	$this->data['button_back'] = $this->language->get('button_back');
    	$this->data['button_continue'] = $this->language->get('button_finalizar');
    	
    	$this->data['text_boleto']  = $this->language->get('text_boleto');
    	
     	$this->data['text_shipping_erro']  = $this->language->get('text_shipping_erro');
      	$this->data['text_agree_erro']  = $this->language->get('error_agree_texto');
   
   		if (isset($this->error['warning'])) {
    		$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['shipping_methods']) && !$this->session->data['shipping_methods']) {
			$this->data['error_warning'] = $this->language->get('error_no_shipping');
		}
        
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
        
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }	
		
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=checkout/shipping';
		
		$this->data['coupon_status'] = $this->config->get('coupon_status');
		
		if ($shipping_address['address_format']) {
      		$format = $shipping_address['address_format'];
    	} else {
			$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		    $format = '<b><font size=3>{company}</font></b> '. "\n".' {firstname} {lastname}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}';
		
		}
		
    	$find = array(
	  		'{firstname}',
	  		'{lastname}',
	  		'{company}',
      		'{address_1}',
      		'{address_2}',
      		'{address_3}',
      		'{bairro}',
     		'{city}',
      		'{postcode}',
      		'{zone}',
			'{zone_code}',
      		'{country}'
		);
	
		$replace = array(
	  		'firstname' => $shipping_address['firstname'],
	  		'lastname'  => $shipping_address['lastname'],
	  		'company'   => $shipping_address['company'],
      		'address_1' => $shipping_address['address_1'],
      		'address_2' => $shipping_address['address_2'],
		    'address_3' => $shipping_address['address_3'],
		    'bairro'    => $shipping_address['bairro'],
      		'city'      => $shipping_address['city'],
      		'postcode'  => $shipping_address['postcode'],
      		'zone'      => $shipping_address['zone'],
			'zone_code' => $shipping_address['zone_code'],
      		'country'   => $shipping_address['country']  
		);
	
		$this->data['address'] = str_replace(array("\r\n", "\r", "\n"), ' - ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
		    	
		$this->data['change_address'] = HTTPS_SERVER . 'index.php?route=checkout/address/shipping'; 

		if (isset($this->session->data['shipping_methods'])) {
			$this->data['shipping_methods'] = $this->session->data['shipping_methods']; 
		} else {
			$this->data['shipping_methods'] = array();
		}
    	
		if (isset($this->session->data['shipping_method']['id'])) {
			$this->data['shipping'] = $this->session->data['shipping_method']['id'];
		} else {
			$this->data['shipping'] = '';
		}
		
		if (isset($this->request->post['comment'])) {
			$this->data['comment'] = $this->request->post['comment'];
		} elseif (isset($this->session->data['comment'])) {
    		$this->data['comment'] = $this->session->data['comment'];
		} else {
			$this->data['comment'] = '';
		}
		
  		if (isset($this->request->post['coupon'])) {
			$this->data['coupon'] = $this->request->post['coupon'];
  			if(isset($this->session->data['valueCoupon'])){
				$this->data['valueCoupon'] = $this->session->data['valueCoupon'];
			}
		} elseif (isset($this->session->data['coupon'])) {
			$this->data['coupon'] = $this->session->data['coupon'];
			if(isset($this->session->data['valueCoupon'])){
				$this->data['valueCoupon'] = $this->session->data['valueCoupon'];
			}
		} else {
			$this->data['coupon'] = '';
			$this->data['valueCoupon'] = '';
		}
		
		/* agree */ 
		
		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));
			
			if ($information_info) {
			$this->data['text_agree'] = sprintf($this->language->get('text_agree'),
 //			 HTTP_SERVER . 'index.php?route=information/information&information_id=' . $this->config->get('config_checkout_id'), 
 $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} 
		else
		{
			$this->data['text_agree'] = '';
		}
		
		if (isset($this->request->post['agree'])) { 
      		$this->data['agree'] = $this->request->post['agree'];
		} else {
			$this->data['agree'] = '';
		}
		
		
		/* monta forma de pagamento */
		
		$this->data['text_payment'] = $this->language->get('text_payment');   
		$this->data['card_number'] = $this->language->get('card_number'); 
 		$this->data['card_title'] = $this->language->get('card_title');  
   		$this->data['card_valid'] = $this->language->get('card_valid');  
   		$this->data['card_security'] = $this->language->get('card_security');  
    	$this->data['card_vista'] = $this->language->get('card_vista');
    	$this->data['card_parcel'] = $this->language->get('card_parcel');
		
		$this->load->model('checkout/shipping');
		  
		$formasPagamento = $this->model_checkout_shipping->ipagare();	
 
		$this->data['formasPagamento'] = $formasPagamento;
		
		/* fim forma de pagamento */
 		
    	$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/cart';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/shipping.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/shipping.tpl';
		} else {
			$this->template = 'default/template/checkout/shipping.tpl';
		}
		
		$this->children = array(
			'common/column_right',
			'common/footer',
			'common/column_left',
			'common/header'
		);
        
        $total_data = array();
        $total = 0;
        $taxes = $this->cart->getTaxes();
         
        $this->load->model('checkout/extension');
        
        $sort_order = array(); 
        
        $results = $this->model_checkout_extension->getExtensions('total');
        
        foreach ($results as $key => $value) {
            $sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
        }
        
        array_multisort($sort_order, SORT_ASC, $results);
        
        foreach ($results as $result) {
            $this->load->model('total/' . $result['key']);

            $this->{'model_total_' . $result['key']}->getTotal($total_data, $total, $taxes);
        }
        
        $sort_order = array(); 
      
        foreach ($total_data as $key => $value) {
              $sort_order[$key] = $value['sort_order'];
        }
        
        $product_data = array();   
        
        $this->load->model('tool/image');    
        
        foreach ($this->cart->getProducts() as $product) {
              $option_data = array();

              foreach ($product['option'] as $option) {
                $option_data[] = array(
                      'product_option_value_id' => $option['product_option_value_id'],               
                      'name'                    => $option['name'],
                      'value'                   => $option['value'],
                      'prefix'                  => $option['prefix']
                );
              }
              
              if ($product['image']) {
					$image = $product['image'];
				} else {
					$image = 'no_image.jpg';
				}
 
              $product_data[] = array(
                'product_id' => $product['product_id'],
                'name'       => $product['name'],
                'model'      => $product['model'],
                'option'     => $option_data,
                'download'   => $product['download'],
                'quantity'   => $product['quantity'],
                'subtract'   => $product['subtract'],
                'price'      => $product['price'],
                'total'      => $product['total'],
                'tax'        => $this->tax->getRate($product['tax_class_id'])
              ); 
        }
        
        $data['products'] = $product_data;
        $data['totals'] = $total_data;
        
        $this->load->model('tool/seo_url');  
        
        $this->data['products'] = array();

        foreach ($this->cart->getProducts() as $product) {
              $option_data = array();

              foreach ($product['option'] as $option) {
                $option_data[] = array(
                      'name'  => $option['name'],
                      'value' => $option['value']
                );
              } 
 
              $this->data['products'][] = array(
                'product_id' => $product['product_id'],
                'name'       => $product['name'],
                'model'      => $product['model'],
                'option'     => $option_data,
                'quantity'   => $product['quantity'],
                'subtract'   => $product['subtract'],
                'tax'        => $this->tax->getRate($product['tax_class_id']),
                'price'      => $this->currency->format($product['price']),
                'total'      => $this->currency->format($product['total']),
                'href'       => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $product['product_id']),
                'image'   	 => $this->model_tool_image->resize($product['image'], 38, 38)        
              ); 
        }
        
        $this->data['column_product'] = $this->language->get('column_product');
        $this->data['column_model'] = $this->language->get('column_model');
        $this->data['column_quantity'] = $this->language->get('column_quantity');
        $this->data['column_price'] = $this->language->get('column_price');
        $this->data['column_total'] = $this->language->get('column_total'); 
        
        $this->data['totals'] = $total_data;   
        
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));		
  	}
  
  	public function validate() {
  		
  		//print $this->request->post;
  		
  		//exit;
  		  		
    	if (!isset($this->request->post['shipping_method'])) {
	  		$this->error['warning'] = $this->language->get('error_shipping');
		} else {
			$shipping = explode('.', $this->request->post['shipping_method']);            
			
			if (!isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {		
				$this->error['warning'] = $this->language->get('error_shipping');
			}
		}
		
		/*
		
		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));
			
			if ($information_info) {
    			if (!isset($this->request->post['agree'])) {
      				$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
    			}
			}
		}
		
		*/
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}
  	
  	private function validateCoupon() {
  	
  		$this->load->model('checkout/coupon');
		
		$this->language->load('checkout/shipping');
		
		$coupon = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);
			
		if(!$coupon)
		{
	  		return FALSE;
		} else {
	  		return $coupon;
		}
  	}
}
?>