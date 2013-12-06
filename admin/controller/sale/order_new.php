<?php
class ControllerSaleOrderNew extends Controller {
	private $error = array();

  	public function index() {
		$this->load->language('sale/order_new');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$order_id = $this->addNewOrder();
			$this->session->data['success'] = $this->language->get('text_insert');

	  		$this->redirect(HTTPS_SERVER . 'index.php?route=sale/order/update&token=' . $this->session->data['token'] . '&order_id=' . $order_id);
		}
		
		$this->document->title = $this->language->get('heading_title');

		$this->load->model('sale/order_new');

		$this->session->data['order_new_products'] = array();
    	$this->getForm();
  	}

  	private function addNewOrder() {
  		$this->load->model('sale/order_new');
		$this->load->model('sale/customer');
		$this->load->model('setting/store');
		$this->load->model('setting/extension');
		$this->load->model('catalog/category');
  		$this->load->model('localisation/currency');
  		
		$data = array();
		$currency_info = $this->model_localisation_currency->getCurrency($this->request->post['currency_id']);
		$this->session->data['order_new_currency_info'] = $currency_info;
		
  		
  		$data['store_id'] 				= $this->config->get('config_store_id');
		$data['store_name'] 			= $this->config->get('config_name');
		$data['store_url'] 				= $this->config->get('config_url');
  		
		
		$data['customer_id'] 				= $this->request->post['customer_id'];
		
		$customer = $this->model_sale_customer->getCustomer((int)$this->request->post['customer_id']);
		
		$data['customer_group_id'] 			= $customer['customer_group_id'];
		$data['firstname'] 					= $customer['firstname'];
		$data['lastname'] 					= $customer['lastname'];
		$data['email'] 						= $this->request->post['email'];
		$data['telephone'] 					= $this->request->post['telephone'];
		$data['fax'] 						= $this->request->post['fax'];
		$data['order_status_id'] 			= $this->request->post['order_status_id'];
		
  		$data['shipping_firstname'] 		= $this->request->post['shipping_firstname'];
		$data['shipping_lastname'] 			= $this->request->post['shipping_lastname'];	
		$data['shipping_company'] 			= $this->request->post['shipping_company'];	
		$data['shipping_address_1'] 		= $this->request->post['shipping_address_1'];
		$data['shipping_address_2'] 		= $this->request->post['shipping_address_2'];
		$data['shipping_city'] 				= $this->request->post['shipping_city'];
		$data['shipping_postcode'] 			= $this->request->post['shipping_postcode'];
		$data['shipping_zone'] 				= $this->request->post['shipping_zone'];
		$data['shipping_zone_id'] 			= $this->request->post['shipping_zone_id'];
		$data['shipping_country'] 			= $this->request->post['shipping_country'];
		$data['shipping_country_id'] 		= $this->request->post['shipping_country_id'];
		$data['shipping_address_format'] 	= '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		$data['shipping_method'] 			= $this->request->post['shipping_method_title'];
		
		$data['payment_firstname'] 			= $this->request->post['payment_firstname'];
		$data['payment_lastname'] 			= $this->request->post['payment_lastname'];	
		$data['payment_company'] 			= $this->request->post['payment_company'];	
		$data['payment_address_1'] 			= $this->request->post['payment_address_1'];
		$data['payment_address_2'] 			= $this->request->post['payment_address_2'];
		$data['payment_city'] 				= $this->request->post['payment_city'];
		$data['payment_postcode'] 			= $this->request->post['payment_postcode'];
		$data['payment_zone'] 				= $this->request->post['payment_zone'];
		$data['payment_zone_id'] 			= $this->request->post['payment_zone_id'];
		$data['payment_country'] 			= $this->request->post['payment_country'];
		$data['payment_country_id'] 		= $this->request->post['payment_country_id'];
		$data['payment_address_format'] 	= '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		$data['payment_method'] 			= $this->request->post['payment_method_title'];
		
		$product_data = $this->getOrderProducts(0);
		
		if(!empty($product_data))
		{
			foreach($product_data as $key => $product)
			{
				$total = $product['new_grand_total'];
			}
		}
		$data['products']					= $product_data;
		
		$total = 0;
		$totals = array();
		if(!empty($this->request->post['order_key']))
		{
			foreach($this->request->post['order_key'] as $key => $total_order)
			{
				$total_order_info = explode('|',$total_order);
				if((float)$this->request->post['total_orders'][$key] > 0
					|| ($total_order_info[0] == 'sub_total' || $total_order_info[0] == 'total'))
				{
					$totals[] = array(
						  'title'		=>	$this->request->post['total_order_name'][$key]
						, 'text'		=>	$this->currency->format($this->request->post['total_orders'][$key], $currency_info['code'], $currency_info['value'], True)
						, 'value'		=>	(float)$this->request->post['total_orders'][$key]
						, 'sort_order'	=>	($key+1)
					);
				}
				if($total_order_info[0] == 'total')
				{
					$total = (float)$this->request->post['total_orders'][$key];
				}
				
			}
		}
		$data['total']						= $total;
		$data['totals']						= $totals;
		
		$data['comment']					= $this->request->post['comment'];
		$data['language_id']				= $this->request->post['language_id'];
		$data['currency_id']				= $currency_info['currency_id'];
		$data['currency']					= $currency_info['title'];
		$data['value']						= $currency_info['value'];
		
		$data['coupon_id'] 					= 0;
		
		$data['ip'] 						= $this->request->server['REMOTE_ADDR'];
		
		
		$data['config_stock_checkout'] 		= $this->config->get('config_stock_checkout');
		
		return $this->model_sale_order_new->createNewOrder($data);
		
  	}
  	public function getForm() {
		$this->load->model('sale/order_new');
		$this->load->model('sale/customer');
		$this->load->model('setting/store');
		$this->load->model('setting/extension');
		$this->load->model('catalog/category');
		
		$order_id = 0;

		$this->load->language('sale/order_new');

		$this->document->title = $this->language->get('heading_title');

		$this->data['heading_title'] 		= $this->language->get('heading_title');

		$this->data['text_wait'] 			= $this->language->get('text_wait');

		$this->data['column_product'] 		= $this->language->get('column_product');
		$this->data['column_model'] 		= $this->language->get('column_model');
		$this->data['column_quantity'] 		= $this->language->get('column_quantity');
		$this->data['column_price'] 		= $this->language->get('column_price');
		$this->data['column_total'] 		= $this->language->get('column_total');
		$this->data['column_download'] 		= $this->language->get('column_download');
		$this->data['column_filename'] 	 	= $this->language->get('column_filename');
		$this->data['column_remaining'] 	= $this->language->get('column_remaining');
		$this->data['column_date_added'] 	= $this->language->get('column_date_added');
		$this->data['column_status'] 		= $this->language->get('column_status');
		$this->data['column_notify'] 		= $this->language->get('column_notify');
		$this->data['column_comment'] 		= $this->language->get('column_comment');
		$this->data['column_add_product'] 	= $this->language->get('column_add_product');

		$this->data['entry_order_id'] 		= $this->language->get('entry_order_id');
		$this->data['entry_invoice_id'] 	= $this->language->get('entry_invoice_id');
		$this->data['entry_customer'] 		= $this->language->get('entry_customer');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_firstname'] 		= $this->language->get('entry_firstname');
		$this->data['entry_lastname'] 		= $this->language->get('entry_lastname');
		$this->data['entry_email'] 			= $this->language->get('entry_email');
		$this->data['entry_telephone'] 		= $this->language->get('entry_telephone');
		$this->data['entry_fax'] 			= $this->language->get('entry_fax');
		$this->data['entry_store_name'] 	= $this->language->get('entry_store_name');
		$this->data['entry_store_url'] 		= $this->language->get('entry_store_url');
		$this->data['entry_date_added'] 	= $this->language->get('entry_date_added');
		$this->data['entry_comment'] 		= $this->language->get('entry_comment');
		$this->data['entry_shipping_method'] = $this->language->get('entry_shipping_method');
		$this->data['entry_payment_method'] = $this->language->get('entry_payment_method');
		$this->data['entry_total'] 			= $this->language->get('entry_total');
		$this->data['entry_order_status'] 	= $this->language->get('entry_order_status');
		$this->data['entry_company'] 		= $this->language->get('entry_company');
		$this->data['entry_address_1'] 		= $this->language->get('entry_address_1');
		$this->data['entry_address_2'] 		= $this->language->get('entry_address_2');
		$this->data['entry_city']		 	= $this->language->get('entry_city');
		$this->data['entry_postcode'] 		= $this->language->get('entry_postcode');
		$this->data['entry_zone'] 			= $this->language->get('entry_zone');
		$this->data['entry_zone_code'] 		= $this->language->get('entry_zone_code');
		$this->data['entry_country'] 		= $this->language->get('entry_country');
		$this->data['entry_status']	 		= $this->language->get('entry_status');
		$this->data['entry_append'] 		= $this->language->get('entry_append');
		$this->data['entry_notify'] 		= $this->language->get('entry_notify');
        $this->data['entry_category'] 		= $this->language->get('entry_category');
		$this->data['entry_product'] 		= $this->language->get('entry_product');
		$this->data['entry_option'] 		= $this->language->get('entry_option');
		$this->data['entry_quantity'] 		= $this->language->get('entry_quantity');
		$this->data['entry_tax'] 			= $this->language->get('entry_tax');
		$this->data['entry_price'] 			= $this->language->get('entry_price');
		
		$this->data['text_none'] 					= $this->language->get('text_none');
		$this->data['text_subtract_quantity'] 		= $this->language->get('text_subtract_quantity');
		$this->data['text_stock_checkout_true'] 	= $this->language->get('text_stock_checkout_true');
		$this->data['text_stock_checkout_false'] 	= $this->language->get('text_stock_checkout_false');

		$this->data['button_new_customer']	 	= $this->language->get('button_new_customer');
		$this->data['button_save']	 			= $this->language->get('button_save');
		$this->data['button_cancel']	 		= $this->language->get('button_cancel');

		$this->data['tab_order'] 			= $this->language->get('tab_order');
		$this->data['tab_product'] 			= $this->language->get('tab_product');
		$this->data['tab_history'] 			= $this->language->get('tab_history');
		$this->data['tab_payment'] 			= $this->language->get('tab_payment');
		$this->data['tab_shipping'] 		= $this->language->get('tab_shipping');
		$this->data['action'] 				= HTTPS_SERVER . 'index.php?route=sale/order_new&token=' . $this->session->data['token'];
		$this->data['token'] 				= $this->session->data['token'];

		//###################################################################################
		// START:: Shipping Methods
		//###################################################################################
		$shipping_extensions	= $this->model_setting_extension->getInstalled('shipping');
  		$files = glob(DIR_APPLICATION . 'controller/shipping/*.php');
		
  		$shipping_methods 		= array();
  		$shipping_sort_order	= array();
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				
				$this->load->language('shipping/' . $extension);
	
				if (in_array($extension, $shipping_extensions)
					&& $this->config->get($extension . '_status')
				) {
					$shipping_methods[] = array(
						'title'       	=> $this->language->get('heading_title')
					);
					$shipping_sort_order[] = $this->config->get($extension . '_sort_order');
				} 										
			}
		}
		
		if(!empty($shipping_methods))
		{
			array_multisort($shipping_sort_order, SORT_ASC, $shipping_methods);
		}
		$this->data['shipping_methods']		= $shipping_methods;
		//###################################################################################
		// FINISH:: Shipping Methods
		//###################################################################################
		
		//###################################################################################
		// START:: Payment Methods
		//###################################################################################
		$payment_extensions	= $this->model_setting_extension->getInstalled('payment');
  		$files = glob(DIR_APPLICATION . 'controller/payment/*.php');
		
  		$payment_methods 		= array();
  		$payment_sort_order		= array();
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				$this->load->language('payment/' . $extension);
	
				if (in_array($extension, $payment_extensions)
					&& $this->config->get($extension . '_status')
				) {
					$payment_methods[] = array(
						  'title'      	 	=> $this->language->get('heading_title')
					);
					$payment_sort_order[] = $this->config->get($extension . '_sort_order');
				} 										
			}
		}
		if(!empty($payment_methods))
		{
			array_multisort($payment_sort_order, SORT_ASC, $payment_methods);
		}
		$this->data['payment_methods']		= $payment_methods;
		//###################################################################################
		// FINISH:: Payment Methods
		//###################################################################################
		//###################################################################################
		// START:: Order Totals
		//###################################################################################
		$total_orders_extensions = $this->model_setting_extension->getInstalled('total');
		$files = glob(DIR_APPLICATION . 'controller/total/*.php');
		
		$total_orders			= array();
		$total_orders_sort_order= array();
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				$this->load->language('total/' . $extension);
				
				if (in_array($extension, $total_orders_extensions)
					&& $this->config->get($extension . '_status')
				) {
					switch($extension)
					{
						case 'coupon':
							$prefix 		= '-';
							$text_status 	= 1;
							break;
						case 'sub_total':
							$prefix 		= '+';
							$text_status 	= 0;
							break;
						case 'total':
							$prefix 		= '+';
							$text_status 	= 0;
							break;
						default:
							$prefix 		= '+';
							$text_status 	= 1;
							break;
					}
					$total_orders[] = array(
						    'key'       	=> $extension
						  , 'title'       	=> $this->language->get('heading_title')
						  , 'prefix'		=> $prefix
						  , 'text_status'	=> $text_status
					);
					$total_orders_sort_order[] = $this->config->get($extension . '_sort_order'); 
				}
			}
		}
  		if(!empty($total_orders))
		{
			array_multisort($total_orders_sort_order, SORT_ASC, $total_orders);
		}
		$this->data['total_orders']			= $total_orders;
		//###################################################################################
		// FINISH:: Order Totals
		//###################################################################################
		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		$this->data['products'] = array();
		$data = array(
			'sort'	=>	'name'
		);
		$this->data['customers']			= $this->model_sale_customer->getCustomers($data);
		$this->data['stores']				= $this->model_setting_store->getStores();
		$this->load->model('localisation/order_status');
    	$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		$this->load->language('sale/order_new');		// load language again to prevent duplication language
		$this->data['language_id'] 			= $this->config->get('config_language_id');

		$this->data['config_stock_checkout']	= $this->config->get('config_stock_checkout');
		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		);

		$this->document->breadcrumbs[] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=sale/order_new&token=' . $this->session->data['token'],
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);

		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=sale/order_new&token=' . $this->session->data['token'];
		
		$this->data['new_customer'] = HTTPS_SERVER . 'index.php?route=sale/customer/insert&token=' . $this->session->data['token'];

		$this->template = 'sale/order_form_new.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	}

	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/order_new')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	    	
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
	
	public function addProduct() {
		$this->load->model('localisation/currency');	
		$this->load->language('sale/order_new');
		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) 
		{
      		$json['error'] = $this->language->get('error_permission');
    	} 
    	else 
    	{
			if (isset($this->request->post['currency_id'])) 
			{
				$currency_id = (int)$this->request->post['currency_id'];
			} 
			else 
			{
				$currency_id = 1;
			}
			
			$currency_info = $this->model_localisation_currency->getCurrency($currency_id);
			
			$this->session->data['order_new_currency_info'] = $currency_info;
			
			$product_info = array(
				  'product_id'		=>	$this->request->post['product_id']
				, 'option'			=>	$this->request->post['option']
				, 'tax'				=>	$this->request->post['tax']
				, 'quantity'		=>	$this->request->post['quantity']
				, 'price'			=>	$this->request->post['price']
			);
			
			$this->session->data['order_new_products'][] = $product_info;
			
			$product_data = $this->getOrderProducts(1);
			
			if(!empty($product_data))
			{
				$json['product_data'] 		= $product_data;
				$json['success']			= $this->language->get('text_success_product');
			}
	    	else
			{
				$json['error']			= 'no results';
			}
    	}
    	
		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
	
	public function removeProduct() {
		if(isset($this->request->get['product_key']))
		{
			$product_key = (int)$this->request->get['product_key'];
			if(!empty($this->session->data['order_new_products']))
			{
				foreach($this->session->data['order_new_products'] as $key => $product)
				{
					if($key == $product_key)
					{
						unset($this->session->data['order_new_products'][$key]);
					}		
				}
				$product_data = $this->getOrderProducts(1);
				
				if(!empty($product_data))
				{
					$json['product_data'] 		= $product_data;
					$json['success']			= $this->language->get('text_sucess');
				}
		    	else
				{
					$json['error']			= 'no results';
				}
			}
			else
			{
				$json['error']	= 'no product';
			}
		}
		else
		{
			$json['error'] = 'no product id';
		}
		
		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
	
	private function getOrderProducts($return_type) {
		$this->load->model('sale/order_new');
		$this->load->model('catalog/product');
		
		$grand_total  	= 0;
		$taxes 			= 0;
		$currency_info = $this->session->data['order_new_currency_info'];
		$products_data = array();
		if(!empty($this->session->data['order_new_products']))
		{
			foreach($this->session->data['order_new_products'] as $key => $product)
			{
				//##########################################################################
				// Retrieve individual product information
				//##########################################################################
				
				$product_id = (int)$product['product_id'];
				$options = explode('|', trim($product['option'], '|'));
				$option_data = array();
	
				$option_price = 0;
	
				foreach ($options as $product_option_value_id) {
	
					$option_value_query = $this->db->query("
						SELECT 
							* 
						FROM " . DB_PREFIX . "product_option_value pov 
							LEFT JOIN " . DB_PREFIX . "product_option_value_description povd 
								ON (pov.product_option_value_id = povd.product_option_value_id) 
						WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' 
								AND pov.product_id = '" . (int)$product_id . "' 
								AND povd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
						ORDER BY pov.sort_order
					");
	
					if ($option_value_query->num_rows) {
						$option_query = $this->db->query("
							SELECT 
								pod.name 
							FROM " . DB_PREFIX . "product_option po 
								LEFT JOIN " . DB_PREFIX . "product_option_description pod 
									ON (po.product_option_id = pod.product_option_id) 
							WHERE po.product_option_id = '" . (int)$option_value_query->row['product_option_id'] . "' 
									AND po.product_id = '" . (int)$product_id . "' 
									AND pod.language_id = '" . (int)$this->config->get('config_language_id') . "' 
							ORDER BY po.sort_order
						");
	
	        			if ($option_value_query->row['prefix'] == '+') {
	          				$option_price = $option_price + $option_value_query->row['price'];
	        			} elseif ($option_value_query->row['prefix'] == '-') {
	          				$option_price = $option_price - $option_value_query->row['price'];
	        			}
	
	        			$option_data[] = array(
	          				'product_option_value_id' => $product_option_value_id,
	          				'name'                    => $option_query->row['name'],
	          				'value'                   => $option_value_query->row['name'],
	          				'prefix'                  => $option_value_query->row['prefix'],
	          				'price'                   => $option_value_query->row['price']
	        			);
					}
	      		}
				$quantity = (int)$product['quantity'];
				
				$tax = (float)$product['tax'];
				
				$result = $this->model_catalog_product->getProduct($product_id);
				
				if ($result) {
	
					//$price = ((float)$result['price'] + (float)$option_price);
					$price = ((float)$product['price'] + (float)$option_price);
	
			        $subtotal = $price * $quantity;
	
					if ($tax) {
						$total = (($tax/100) * $subtotal) + $subtotal;
					} else {
						$total = $subtotal;
					}
					
					$product_data = array(
						'key'					=> $key,
						'product_id'			=> $result['product_id'],
						'name'					=> $result['name'],
						'model'					=> $result['model'],
						'sku'					=> $result['sku'],
						'stock'					=> $result['quantity'],
						'minimum'				=> $result['minimum'],
						'tax_class_id'			=> $result['tax_class_id'],
						'price'					=> $price,
						'formatted_price'		=> $this->currency->format($price, $currency_info['code'], $currency_info['value'], True),
						'quantity'				=> $quantity,
						'tax'					=> $tax,
						'total'					=> $total,
						'download'				=> array(),
						'order_total'			=> $this->currency->format($grand_total + $total, $currency_info['code'], $currency_info['value'], False),
						'formatted_order_total'	=> $this->currency->format($grand_total + $total, $currency_info['code'], $currency_info['value'], True),
						'formatted_total'		=> $this->currency->format($total, $currency_info['code'], $currency_info['value'], True),
						'new_grand_total'		=> $this->currency->format($grand_total + $total, $currency_info['code'], $currency_info['value'], False),
						'formatted_grand_total'	=> $this->currency->format($grand_total + $total, $currency_info['code'], $currency_info['value'], True),
						'options'				=> $option_data,
						'href'					=> HTTPS_SERVER . 'index.php?route=catalog/product/update&token=' . $this->session->data['token'] . '&product_id=' . $result['product_id']
					);

					$products_data[] = $product_data;
					$grand_total += $total;
					$taxes 		 += $tax;
				}
			}
		}
		if($return_type == 1)
		{
			return $product_data;	
		}
		else
		{
			return $products_data;
		}
		
	}
	
	public function getCustomer() {
		$this->load->model('sale/customer');
		$this->load->model('sale/order_new');
		$this->load->language('sale/order_new');
		
		$json = array();
		
		$customer = array();
		if(isset($this->request->get['customer_id']))
		{
			$customer = $this->model_sale_customer->getCustomer((int)$this->request->get['customer_id']);
			$customer['address'] = $this->model_sale_order_new->getAddress($customer['address_id']);
			if($customer['address'] == false)
			{
				$cusomter['address'] = array();	
			}
			$json['customer'] = $customer;
			$json['success'] = $this->language->get('text_success_customer');
		}
		else
		{
			$json['error'] = $this->error['message'];	
		}
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
	public function getStore(){
		$this->load->model('setting/store');
		$this->load->model('sale/order_new');
		
		if (isset($this->request->get['store_id'])) 
		{
			$store_id = $this->request->get['store_id'];
		} 
		else 
		{
			$store_id = 0;
		}
		
		$json = array();
		$store_info = array();
		if($store_id != 0)
		{
			$store_info = $this->model_setting_store->getStore($this->request->get['store_id']);
			if(!empty($store_info))
			{
				if($store_info['currency'] != "")
				{
					$currency_info = $this->model_sale_order_new->getCurrencyByCode($store_info['currency']);
					if(!empty($currency_info))
					{
						$store_info['currency_id'] = $currency_info['currency_id'];
					}
				}
				if($store_info['language'] != "")
				{
					$language_info = $this->model_sale_order_new->getLanguageByCode($store_info['language']);
					if(!empty($language_info))
					{
						$store_info['language_id'] = $language_info['language_id'];
					}
				}
				
				$json['success'] = $this->language->get('text_success_customer');				
			}
			else
			{
				$json['error'] = $this->error['message'];
			}
		}
		else
		{
			$json['success'] = $this->language->get('text_success_customer');
			$currency_info = $this->model_sale_order_new->getCurrencyByCode($this->config->get('config_currency'));
			$store_info['currency_id'] = $currency_info['currency_id'];
		}
		$json['store'] = $store_info;
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
		
	}

	public function category() {
		$this->load->model('catalog/product');
		$this->load->model('localisation/currency');

		if (isset($this->request->get['category_id'])) 
		{
			$category_id = $this->request->get['category_id'];
		} 
		else 
		{
			$category_id = 0;
		}

		$product_data = array();

		$currency_info = $this->model_localisation_currency->getCurrency($this->request->get['currency_id']);

		$results = $this->model_catalog_product->getProductsByCategoryId($category_id);

		foreach ($results as $result) 
		{
			$product_data[] = array(
				'product_id' 		=> $result['product_id'],
				'name'       		=> $result['name'],
				'model'      		=> $result['model'],
				'price_no_format'	=> $result['price'],
				'price'      		=> $this->currency->format($result['price'], $currency_info['code'], False, True)
			);
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($product_data));
	}
	

	public function product() {
		$this->load->model('catalog/product');
		$this->load->model('localisation/currency');

		if (isset($this->request->get['product_id'])) 
		{
			$product_id = $this->request->get['product_id'];
		} 
		else 
		{
			$product_id = 0;
		}

		$option_data = array();

		$currency_info = $this->model_localisation_currency->getCurrency($this->request->get['currency_id']);

		$results = $this->model_catalog_product->getProductOptions($product_id);

		$option_value_data = array();

		foreach ($results as $result) 
		{
			foreach ($result['product_option_value'] as $option_value) {
				$option_value_data[] = array(
					'product_option_value_id'	=> $option_value['product_option_value_id'],
					'language' 					=> $option_value['language'],
					'price'						=> $this->currency->format($option_value['price'], $currency_info['code'], False, True),
					'prefix' 					=> $option_value['prefix']
				);
			}

			$option_data[] = array(
				'product_option_id'	 	=> $result['product_option_id'],
				'language'       		=> $result['language'],
				'product_option_value'  => $option_value_data,
			);
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($option_data));
	}
	public function zone() {
		$output = '<select name="' . $this->request->get['type'] . '_id">';

		$this->load->model('localisation/country');
		$this->load->model('localisation/zone');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		$results = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);

		$selected_name = '';

		foreach ($results as $result) 
		{
			$output .= '<option value="' . $result['zone_id'] . '"';

			if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) 
			{
				$output .= ' selected="selected"';
				$selected_name = $result['name'];
			}

			$output .= '>' . $result['name'] . '</option>';
		}

		if (!$results) 
		{
			$output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
		}

		$output .= '</select>';
		$output .= '<input type="hidden" id="' .  $this->request->get['type'] . '_name" name="' . $this->request->get['type'] . '" value="' . $selected_name . '" />';
		$output .= '<input type="hidden" id="' .  $this->request->get['type_name'] . '_name" name="' . $this->request->get['type_name'] . '" value="' . $country_info['name'] . '" />';

		$this->response->setOutput($output, $this->config->get('config_compression'));
	}
}
?>