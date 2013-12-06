<?php 
class ControllerAccountMywishlist extends Controller { 
	public function index() {
		if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=account/account';
	  		//$this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
    	} 
	
		$this->language->load('account/mywishlist');
		$this->load->model('account/mywishlist');
      	$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTPS_SERVER . 'index.php?route=account/mywishlist',
        	'text'      => $this->language->get('text_mywishlist'),
        	'separator' => $this->language->get('text_separator')
      	);
		
		if($this->customer->getId()){
			$this->document->title = $this->language->get('heading_title');
			$this->data['heading_title'] = $this->language->get('heading_title');
		}else{
			$this->document->title = $this->language->get('text_mywishlist');
			$this->data['heading_title'] = $this->language->get('text_mywishlist');
		}
		
		$this->data['success'] = '';
		if(isset($this->request->get['action']) && $this->request->get['action']=='add' && isset($this->request->get['id'])){
			if (!$this->customer->isLogged()) {
				$this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=product/product&product_id='.$this->request->get['id'];
	  			echo $this->data['success'] = '<div class="warning">'.$this->language->get('text_login_error').'</div>';die();
			}
			else if($this->model_account_mywishlist->addMywishlist($_GET)){
				echo $this->data['success'] = '<div class="success">'.$this->language->get('text_success').'</div>';die();
			}else{
				echo $this->data['success'] = '<div class="warning">'.$this->language->get('text_error').'</div>';die();
			}
		}
		if(isset($this->request->get['action']) && $this->request->get['action']=='del'){
			$this->model_account_mywishlist->deleteMywishlist($this->request->get['id']);
			$this->data['success'] = $this->language->get('text_delete');
		}
		
		$this->data['entry_remove'] = $this->language->get('entry_remove');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_model'] = $this->language->get('entry_model');
		$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['text_notfound'] = $this->language->get('text_notfound');
		$this->data['button_buy'] = $this->language->get('button_buy');
		$this->data['button_send'] = $this->language->get('button_send');
		$this->data['entry_email'] = $this->language->get('entry_email');
		
		$listdata = $this->model_account_mywishlist->getMywishlists();
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$listdata_arr = array();
		
		if(count($listdata)>0){	  
			$o=0;
			foreach($listdata as $k=>$v){
				
				$listdata_arr[$o]['product_id'] = $v['product_id'];
				$product_id = $v['product_id'];
				$product_info = $this->model_catalog_product->getProduct($product_id);
				
				$discount = $this->model_catalog_product->getProductDiscount($product_id);
				$special = '';
				if ($discount) {
					$price = $this->currency->format($this->tax->calculate($discount, $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				
					if ($special) {
						$price = $this->currency->format($this->tax->calculate($special, $product_info['tax_class_id'], $this->config->get('config_tax')));
					}
				}
				if ($product_info['image']) {
					$image = $product_info['image'];
				} else {
					$image = 'no_image.jpg';
				}
				
				$listdata_arr[$o]['image'] = '<a href="'.HTTP_SERVER .'index.php?route=product/product&amp;product_id='.$v['product_id'].'"><img alt="'.$product_info['name'].'" title="'.$product_info['name'].'" src="'.$this->model_tool_image->resize($image, 100, 100).'"></a>';
				$listdata_arr[$o]['price'] = $price;
				$listdata_arr[$o]['id'] = $v['id'];
				$listdata_arr[$o]['name'] = $product_info['name'];
				$listdata_arr[$o]['model'] = $product_info['model'];
				//echo $image;
				$o++;
			 } 
		}else{
		}	  
		
		
		$this->data['listdata'] = $listdata_arr;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/mywishlist.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/mywishlist.tpl';
		} else {
			$this->template = 'default/template/account/mywishlist.tpl';
		}
		
		$this->children = array(
			'common/column_right',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));		
  	}
	
	function sendemail(){
		$this->language->load('account/mywishlist');
		
		if($this->request->post['email']!=''){
			$subject = $this->language->get('text_subject');
			$message = $this->language->get('text_message');
			
			$link = HTTPS_SERVER . 'index.php?route=account/mywishlist&memid='.$this->customer->getId();
			$message = str_replace('{link}',$link,$message);
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');				
			$mail->setTo($this->request->post['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject($subject);
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
			echo $this->language->get('text_email_success');
		}else{
			echo $this->language->get('text_email_error');
		}
	}
	
}
?>