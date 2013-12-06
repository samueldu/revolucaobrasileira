<?php
class ControllerSaleNewssubscribers extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('sale/newssubscribers');
 
		$this->document->title = $this->language->get('heading_title');
 		
		$this->load->model('sale/newssubscribers');
		
		$this->getList();
	}

	public function insert() {
		$this->load->language('sale/newssubscribers');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('sale/newssubscribers');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_newssubscribers->addEmail($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=sale/newssubscribers&token=' . $this->session->data['token'] . $url);
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('sale/newssubscribers');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('sale/newssubscribers');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_newssubscribers->editEmail($this->request->get['id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=sale/newssubscribers&token=' . $this->session->data['token'] . $url);
		}

		$this->getForm();
	}
	public function export() {
		
		$this->load->model('sale/newssubscribers');
		
		$contents="Name \t Email \n";
		
		$results = $this->model_sale_newssubscribers->exportEmails();
		
		$filename ="Newsletter_subscribers_".date("Y-m-d").".xls";
		if($results) {
			foreach($results as $results){
				$contents .= implode("\t",$results)."\n";	
			}
		}else{
			$contents = $this->language->get('text_no_results');
		}
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $contents;
		
	}
	public function delete() { 
		$this->load->language('sale/newssubscribers');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('sale/newssubscribers');
		
		if (isset($this->request->post['selected'])) {
      		foreach ($this->request->post['selected'] as $id) {
				$this->model_sale_newssubscribers->deleteEmail($id);	
			}
						
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=sale/newssubscribers&token=' . $this->session->data['token'] . $url);
		}

		$this->getList();
	}

	private function getList() {
	
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=sale/newssubscribers&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=sale/newssubscribers/insert&token=' . $this->session->data['token'];
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=sale/newssubscribers/delete&token=' . $this->session->data['token'];
		$this->data['export'] = HTTPS_SERVER . 'index.php?route=sale/newssubscribers/export&token=' . $this->session->data['token'];	
	
		$this->data['text_export'] = $this->language->get('text_export');
		
		if(isset($this->request->get['page'])) {
	            $page = $this->request->get['page'];
		}else{
		        $page = 1;
		}
	
		$this->data['emails'] = array();
		
		$data = "";
		
		$email_total = $this->model_sale_newssubscribers->getTotalEmails($data);
		
		$results = $this->model_sale_newssubscribers->getEmails($data,($page - 1) * $this->config->get('config_admin_limit'),$this->config->get('config_admin_limit'));

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=sale/newssubscribers/update&token=' . $this->session->data['token'] . '&id=' . $result['id']
			);		
		
			$this->data['emails'][] = array(
				'id' 		=> $result['id'],
				'name' 	=> $result['name'],
				'email' 	=> $result['email_id'],
				'action'    => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = "";
		
		
		$pagination = new Pagination();
		$pagination->total = $email_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=sale/newssubscribers&token=' . $this->session->data['token'] . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();
		

		$this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=sale/newssubscribers&token=' . $this->session->data['token'];
		
		
		$this->template = 'sale/newsletter_subscriberslist.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_code'] = $this->language->get('entry_code');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['error_email_name'])) {
			$this->data['error_email_name'] = $this->error['error_email_name'];
		} else {
			$this->data['error_email_name'] = '';
		}
		
 		if (isset($this->error['error_email_exist'])) {
			$this->data['error_email_exist'] = $this->error['error_email_exist'];
		} else {
			$this->data['error_email_exist'] = '';
		}
		
		

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=sale/newssubscribers&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
			
		if (!isset($this->request->get['id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=sale/newssubscribers/insert&token=' . $this->session->data['token'] ;
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=sale/newssubscribers/update&token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] ;
		}
		
		$this->data['token'] = $this->session->data['token'];
		  
    	$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=sale/newssubscribers&token=' . $this->session->data['token'];

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$email_info = $this->model_sale_newssubscribers->getEmail($this->request->get['id']);
		}

		if (isset($this->request->post['email_name'])) {
			$this->data['email_name'] = $this->request->post['email_name'];
		} elseif (isset($email_info)) {
			$this->data['email_name'] = $email_info['name'];
		} else {
			$this->data['email_name'] = '';
		}
		
		if (isset($this->request->post['email_id'])) {
			$this->data['email_id'] = $this->request->post['email_id'];
		} elseif (isset($email_info)) {
			$this->data['email_id'] = $email_info['email_id'];
		} else {
			$this->data['email_id'] = '';
		}
			
		$this->template = 'sale/newsletter_subscriber_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression')); 
	}

	private function validateForm() {
		
	$this->load->model('sale/newssubscribers');
		
		if (!$this->user->hasPermission('modify', 'sale/newssubscribers')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

	 if(!filter_var($this->request->post['email_id'],FILTER_VALIDATE_EMAIL)){
			$this->error['error_email_name'] = $this->language->get('error_email');
		}
		
	 if($this->model_sale_newssubscribers->checkmail($this->request->post['email_id'])){
			$this->error['error_email_exist'] = $this->language->get('error_email_exist');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}
?>