<?php 
class ControllerAccountInvoice extends Controller {
	public function index() { 
    	if (!$this->customer->isLogged()) {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}	
			
			$this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=account/invoice&order_id=' . $order_id;
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
    	}
	  
    	$this->language->load('account/invoice');

    	$this->document->title = $this->language->get('heading_title');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
      	
		$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTPS_SERVER . 'index.php?route=account/account',
        	'text'      => $this->language->get('text_account'),
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTPS_SERVER . 'index.php?route=account/history',
        	'text'      => $this->language->get('text_history'),
        	'separator' => $this->language->get('text_separator')
      	);
      	
		$this->document->breadcrumbs[] = array(
        	'href'      => HTTPS_SERVER . 'index.php?route=account/invoice&order_id=' . $order_id,
        	'text'      => $this->language->get('text_invoice'),
        	'separator' => $this->language->get('text_separator')
      	);
		
		$this->load->model('account/order');
			
		$order_info = $this->model_account_order->getOrder($order_id);
		
		if ($order_info) {
      		$this->data['heading_title'] = $this->language->get('heading_title');
			
			$this->data['text_invoice_id'] = $this->language->get('text_invoice_id');
    		$this->data['text_order_id'] = $this->language->get('text_order_id');
			$this->data['text_email'] = $this->language->get('text_email');
			$this->data['text_telephone'] = $this->language->get('text_telephone');
			$this->data['text_fax'] = $this->language->get('text_fax');
      		$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');
      		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
      		$this->data['text_payment_address'] = $this->language->get('text_payment_address');
      		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
      		$this->data['text_order_history'] = $this->language->get('text_order_history');
      		$this->data['text_product'] = $this->language->get('text_product');
      		$this->data['text_model'] = $this->language->get('text_model');
      		$this->data['text_quantity'] = $this->language->get('text_quantity');
      		$this->data['text_price'] = $this->language->get('text_price');
      		$this->data['text_total'] = $this->language->get('text_total');
			$this->data['text_comment'] = $this->language->get('text_comment');
			$this->data['text_invoice_long'] = $this->language->get('text_invoice_long');   
			$this->data['text_status'] = $this->language->get('text_status'); 
			
			if(isset($this->session->data['orderDetails']) && isset($this->session->data['orderProducts'])){
				$this->data['orderDetails'] = $this->session->data['orderDetails'];
				$this->data['orderProducts'] = $this->session->data['orderProducts'];
				unset($this->session->data['orderDetails']);
				unset($this->session->data['orderProducts']);
			}else{
				$this->data['orderDetails'] = null;
				$this->data['orderProducts'] = null;
			}
			

      		$this->data['column_date_added'] = $this->language->get('column_date_added');
      		$this->data['column_status'] = $this->language->get('column_status');
      		$this->data['column_comment'] = $this->language->get('column_comment');
			
      		$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['order_id'] = $this->request->get['order_id'];
			
			if ($order_info['invoice_id']) {
				$this->data['invoice_id'] = $order_info['invoice_prefix'] . $order_info['invoice_id'];
			} else {
				$this->data['invoice_id'] = '';
			}
			
			$this->data['email'] = $order_info['email'];
			$this->data['telephone'] = $order_info['telephone'];
			$this->data['fax'] = $order_info['fax'];

			if ($order_info['shipping_address_format']) {
      			$format = $order_info['shipping_address_format'];
    		} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
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
	  			'firstname' => $order_info['shipping_firstname'],
	  			'lastname'  => $order_info['shipping_lastname'],
	  			'company'   => $order_info['shipping_company'],
      			'address_1' => $order_info['shipping_address_1'],
      			'address_2' => $order_info['shipping_address_2'],
			    'address_3' => $order_info['shipping_address_3'],
				'bairro' => $order_info['shipping_bairro'],
      			'city'      => $order_info['shipping_city'],
      			'postcode'  => $order_info['shipping_postcode'],
      			'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
      			'country'   => $order_info['shipping_country']  
			);

			$this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$this->data['shipping_method'] = $order_info['shipping_method'];

			if ($order_info['payment_address_format']) {
      			$format = $order_info['payment_address_format'];
    		} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
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
	  			'firstname' => $order_info['payment_firstname'],
	  			'lastname'  => $order_info['payment_lastname'],
	  			'company'   => $order_info['payment_company'],
      			'address_1' => $order_info['payment_address_1'],
      			'address_2' => $order_info['payment_address_2'],
				'address_3' => $order_info['payment_address_3'],
				'bairro'    => $order_info['payment_bairro'],
      			'city'      => $order_info['payment_city'],
      			'postcode'  => $order_info['payment_postcode'],
      			'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
      			'country'   => $order_info['payment_country']  
			);
			
			$this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

      		$this->data['payment_method'] = $order_info['payment_method'];
      		
      		if($this->data['payment_method'] == "Ipagare" or $this->data['payment_method'] == "Ipagare web")
      		{
      			    $resultx['payment_method'] = $this->model_account_order->getIpagare($order_info['order_id']);
        			
        			if(@count($resultx['payment_method']) > 0)
        			$this->data['payment_method'] = $resultx['payment_method'][0]['meioF']." ".$resultx['payment_method'][0]['formaF'];
      		}
			
			$this->data['products'] = array();
			
			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

      		foreach ($products as $product) {
				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

        		$option_data = array();

        		foreach ($options as $option) {
          			$option_data[] = array(
            			'name'  => $option['name'],
            			'value' => $option['value'],
          			);
        		}

        		$this->data['products'][] = array(
          			'name'     => $product['name'],
          			'model'    => $product['model'],
          			'option'   => $option_data,
          			'quantity' => $product['quantity'],
          			'price'    => $this->currency->format($product['price'], $order_info['currency'], $order_info['value']),
					'total'    => $this->currency->format($product['total'], $order_info['currency'], $order_info['value'])
        		);
      		}

      		$this->data['totals'] = $this->model_account_order->getOrderTotals($this->request->get['order_id']);
			
			$this->data['comment'] = $order_info['comment'];
      		
			$this->data['historys'] = array();

			$results = $this->model_account_order->getOrderHistories($this->request->get['order_id']);
			
			$num = count($results);
			
			$numX = 0;
                                   
      		foreach ($results as $result) {
      			
      			$numX = $numX + 1;    
      			
      			if($numX == $num)
      			$this->data['status_atual'] = $result['status']; 
      			
        		$this->data['historys'][] = array(
          			'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
          			'status'     => $result['status'],
          			'comment'    => nl2br($result['comment'])  
        		);
      		}
      		
      		$this->data['google_analytics_ua_code'] = $this->config->get('google_analytics_ua_code'); 
      		$this->data['config_name'] = $this->config->get('config_name'); 

      		$this->data['continue'] = HTTPS_SERVER . 'index.php?route=account/history';

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/invoice.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/account/invoice.tpl';
			} else {
				$this->template = 'default/template/account/invoice.tpl';
			}
			
			$this->children = array(
				'common/column_right',
				'common/footer',
				'common/column_left',
				'common/header'
			);		
			
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));		
    	} else {
      		$this->data['heading_title'] = $this->language->get('heading_title');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = HTTP_SERVER . 'index.php?route=account/history';
      			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_right',
				'common/footer',
				'common/column_left',
				'common/header'
			);		
			
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));				
    	}
  	}
}
?>