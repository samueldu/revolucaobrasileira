<?php 
class ControllerModuleCart extends Controller { 
	protected function index() {
		$this->language->load('module/cart');
		
		$this->load->model('tool/seo_url');
		
		$this->load->model('tool/image');   
		
    	$this->data['heading_title'] = $this->language->get('heading_title');  
    	
		$this->data['text_subtotal'] = $this->language->get('text_subtotal');
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_remove'] = $this->language->get('text_remove');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_view'] = $this->language->get('text_view');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
		
		$this->data['view'] = HTTP_SERVER . 'index.php?route=checkout/cart';
		$this->data['checkout'] = HTTPS_SERVER . 'index.php?route=checkout/shipping';
		
		$this->data['column_remove'] = $this->language->get('column_remove');
  		$this->data['column_image'] = $this->language->get('column_image');
  		$this->data['column_name'] = $this->language->get('column_name');
  		$this->data['column_model'] = $this->language->get('column_model');
  		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
  		$this->data['column_total'] = $this->language->get('column_total');
		
		$this->data['products'] = array();
		
    	foreach ($this->cart->getProducts() as $result) {
        	$option_data = array();

        	foreach ($result['option'] as $option) {
          		$option_data[] = array(
            		'name'  => $option['name'],
            		'value' => $option['value']
          		);
        	}
        	
        	if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 70, 70);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 70, 70);
			}
			
      		$this->data['products'][] = array(
        		'key' 		 => $result['key'],
        		'name'       => $result['name'],
				'option'     => $option_data,
        		'quantity'   => $result['quantity'],
				'stock'      => $result['stock'],
				'price'      => $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))),
				'href'       => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $result['product_id']),
				'image'      => $image,
      			'sum_price'  => $this->currency->format($this->tax->calculate($result['quantity']*$result['price'], $result['tax_class_id'], $this->config->get('config_tax')))
      		);
    	}
	
		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = TRUE;
		} elseif ($this->customer->isLogged()) {
			$this->data['display_price'] = TRUE;
		} else {
			$this->data['display_price'] = FALSE;
		}
	
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

    	array_multisort($sort_order, SORT_ASC, $total_data);
		
    	$this->data['totals'] = $total_data;
		
		$this->data['ajax'] = $this->config->get('cart_ajax');
		
		$this->id = 'cart';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cart.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/cart.tpl';
		} else {
			$this->template = 'default/template/module/cart.tpl';
		}
		
		$this->render();
	}
		
	public function callback() {
		try{
			$this->language->load('module/cart');  
			$this->load->model('tool/image');  
			$this->load->model('tool/seo_url');       
					
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['payment_method']);
	
			if ($this->request->server['REQUEST_METHOD'] == 'POST') {    
			
			if(!isset($this->request->post['opt_ajax']))
			$this->request->post['opt_ajax'] = false;
			
    				
				if (isset($this->request->post['remove'])) {
		    		$result = explode('_', $this->request->post['remove']);
	          		$this->cart->remove(trim($result[1]));
	      		} else {
					if (isset($this->request->post['option'])) {  
						$option = $this->request->post['option'];
					} else {
						$option = array();	
					}
					
	      			$this->cart->add($this->request->post['product_id'], $this->request->post['quantity'], $option);
				}
				$ajax = $this->request->post['opt_ajax'];
			}
			
			$this->cart->promocao(); 
				
			if ($this->cart->getProducts()) {
				$output = '<div id="cartScroll"><table cellpadding="2" cellspacing="0" style="width: 98%;"  class="tableModule">
												 <tr class="titulo">
												<th align="left"><?php echo $column_image; ?></th>
												<th align="left" width="200"><?php echo $column_name; ?></th>
												<th align="center"><?php echo $column_quantity; ?></th>
												<th align="center"><?php echo $column_remove; ?></th>
												<?php if ($display_price) { ?>
												<th align="center"><?php echo $column_price; ?></th>
												<th align="center"><?php echo $column_total; ?></th>
												<?php } ?>
												</tr>';
				
	    		foreach ($this->cart->getProducts() as $product) { 
	    			
	    		if ($product['image'] && file_exists(DIR_IMAGE . $product['image'])) {
					$image = $this->model_tool_image->resize($product['image'], 70, 70);
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', 70, 70);
				}
	    			
	      			$output .= '<tr>';
	        		$output .= '<td  align="left">
	        		
	        		<a href="' . $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $product['product_id']) . '"> 
	        		<img src='.$image.' style="background:transparent;float:left;margin:0 10px 0 0;"> </a>        		
	        		</td>';
	        		$output .= '<td align="left">
					<a href="' . $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $product['product_id']) . '"  class="nomeProduto">' . $product['name'] . '</a></td>
					<td align="center"> <span style="font-size:11px;margin-left:10px;">Qtd. ' . $product['quantity'] . '</span></td>
					<td align="center"> <span class="cart_remove" id="remove_' . $product['key'] . '" />&nbsp; </span> </td>
					<td align="center"><span class="precoProdutoCinza">'.$this->currency->format($product['price']).' </span> ';
	          		$output .= '<div>';
	          		
		            
					foreach ($product['option'] as $option) {
	            		$output .= ' - <small style="color: #999;">' . $option['name'] . ' ' . $option['value'] . '</small><br />';
		            }
					
					$output .= '</div></td>';
					$output .= '<td align="center"><span class="precoProduto">'.$this->currency->format($product['quantity']*$product['price']).'</span></td>';
					$output .= '</tr>';
	      		}
	      		
				$output .= '</table></div>';
	    		$output .= '<br />';
	    		
	    		$total = 0;
				$taxes = $this->cart->getTaxes();
				 
				$this->load->model('checkout/extension');
				
				$sort_order = array(); 
				
				$view = HTTP_SERVER . 'index.php?route=checkout/cart';
				$checkout = HTTPS_SERVER . 'index.php?route=checkout/shipping';
				
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
	
	    		array_multisort($sort_order, SORT_ASC, $total_data);
	    	    		
	    		$output .= '<table cellpadding="0" cellspacing="0" align="right" class="tabTotal" width="100%">';
	      		foreach ($total_data as $total) { 
	      			$output .= '<tr>';
			        $output .= '<td align="right"><span class="cart_module_total"><b>' . $total['title'] . '</b></span><span class="cart_module_total">' . $total['text'] . '</span></td>';
	      			$output .= '</tr>';
	      		}
	      		$output .= '</table>';
	      		$output .= '<div style="text-align:right;clear:right;vertical-align:baseline"><a href="javascript:dimOff();" id="fechar" class="buttonTes"><span>Continuar Comprando</span>  <a href="' . $checkout . '"  class="buttonFina"><span>' . $this->language->get('text_checkout') . '</span></a></div>';
			} else {
				$output = '<div style="text-align: center;">' . $this->language->get('text_empty') . '</div>';
			}    

			if(!isset($ajax) or $ajax == false){
	        	$output .= "<script>window.location = '".HTTPS_SERVER."index.php?route=checkout/cart';</script>";
			}  
			
			$this->response->setOutput($output, $this->config->get('config_compression'));
		}catch (Exception $e){
			print_r($e);
		}  
	} 	
    
    public function callbackOld() {
        
        $output = "<script>window.location = '".HTTPS_SERVER."index.php?route=checkout/cart';</script>";
        
        $this->response->setOutput($output, $this->config->get('config_compression'));  
    }     
}
?>
