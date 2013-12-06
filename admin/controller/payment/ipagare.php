<?php 
class ControllerPaymentiPagare extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/ipagare');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('ipagare', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_authorization'] = $this->language->get('text_authorization');
		$this->data['text_sale'] = $this->language->get('text_sale');
		
		
		$this->data['entry_estabelecimento'] = $this->language->get('entry_estabelecimento');
		$this->data['entry_chave'] = $this->language->get('entry_chave');
		$this->data['entry_teste'] = $this->language->get('entry_teste');
		
		
		$this->data['explain_estabelecimento'] = $this->language->get('explain_estabelecimento');
		$this->data['explain_chave'] = $this->language->get('explain_chave');
				
		$this->data['entry_order_status_aprovado'] = $this->language->get('entry_order_status_aprovado');	
		$this->data['entry_order_status_reprovado'] = $this->language->get('entry_order_status_reprovado');	
		$this->data['entry_order_status_cancelado'] = $this->language->get('entry_order_status_cancelado');	
		$this->data['entry_order_status_completo'] = $this->language->get('entry_order_status_completo');	
		$this->data['entry_order_status_aguardando'] = $this->language->get('entry_order_status_aguardando');	
		$this->data['entry_order_status_capturado'] = $this->language->get('entry_order_status_capturado');	
		$this->data['entry_order_status_analise'] = $this->language->get('entry_order_status_analise');	
		
		
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

		
 		if (isset($this->error['estabelecimento'])) {
			$this->data['error_estabelecimento'] = $this->error['estabelecimento'];
		} else {
			$this->data['error_estabelecimento'] = '';
		}
		
		if (isset($this->error['chave'])) {
			$this->data['error_chave'] = $this->error['chave'];
		} else {
			$this->data['error_chave'] = '';
		}
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		
		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=payment/ipagare&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/ipagare&token=' . $this->session->data['token'];
		
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];

		if (isset($this->request->post['ipagare_estabelecimento'])) {
			$this->data['ipagare_estabelecimento'] = $this->request->post['ipagare_estabelecimento'];
		} else {
			$this->data['ipagare_estabelecimento'] = $this->config->get('ipagare_estabelecimento');
		}
		
		if (isset($this->request->post['ipagare_chave'])) {
			$this->data['ipagare_chave'] = $this->request->post['ipagare_chave'];
		} else {
			$this->data['ipagare_chave'] = $this->config->get('ipagare_chave');
		}
		
		
		if (isset($this->request->post['ipagare_teste'])) {
			$this->data['ipagare_teste'] = $this->request->post['ipagare_teste'];
		} else {
			$this->data['ipagare_teste'] = $this->config->get('ipagare_teste');
		}		
	
		if (isset($this->request->post['ipagare_entry_order_status_aprovado'])) {
			$this->data['ipagare_entry_order_status_aprovado'] = $this->request->post['ipagare_entry_order_status_aprovado'];
		} else {
			$this->data['ipagare_entry_order_status_aprovado'] = $this->config->get('ipagare_entry_order_status_aprovado'); 
		} 
		
		if (isset($this->request->post['ipagare_entry_order_status_capturado'])) {
			$this->data['ipagare_entry_order_status_capturado'] = $this->request->post['ipagare_entry_order_status_capturado'];
		} else {
			$this->data['ipagare_entry_order_status_capturado'] = $this->config->get('ipagare_entry_order_status_capturado'); 
		} 

		if (isset($this->request->post['ipagare_entry_order_status_reprovado'])) {
			$this->data['ipagare_entry_order_status_reprovado'] = $this->request->post['ipagare_entry_order_status_reprovado'];
		} else {
			$this->data['ipagare_entry_order_status_reprovado'] = $this->config->get('ipagare_entry_order_status_reprovado'); 
		} 
		
		if (isset($this->request->post['ipagare_entry_order_status_cancelado'])) {
			$this->data['ipagare_entry_order_status_cancelado'] = $this->request->post['ipagare_entry_order_status_cancelado'];
		} else {
			$this->data['ipagare_entry_order_status_cancelado'] = $this->config->get('ipagare_entry_order_status_cancelado'); 
		} 

		if (isset($this->request->post['ipagare_entry_order_status_completo'])) {
			$this->data['ipagare_entry_order_status_completo'] = $this->request->post['ipagare_entry_order_status_completo'];
		} else {
			$this->data['ipagare_entry_order_status_completo'] = $this->config->get('ipagare_entry_order_status_completo'); 
		} 

		if (isset($this->request->post['ipagare_entry_order_status_aguardando'])) {
			$this->data['ipagare_entry_order_status_aguardando'] = $this->request->post['ipagare_entry_order_status_aguardando'];
		} else {
			$this->data['ipagare_entry_order_status_aguardando'] = $this->config->get('ipagare_entry_order_status_aguardando'); 
		} 

		if (isset($this->request->post['ipagare_entry_order_status_analise'])) {
			$this->data['ipagare_entry_order_status_analise'] = $this->request->post['ipagare_entry_order_status_analise'];
		} else {
			$this->data['ipagare_entry_order_status_analise'] = $this->config->get('ipagare_entry_order_status_analise'); 
		} 

		if (isset($this->request->post['ipagare_entry_order_status_analise'])) {
			$this->data['ipagare_entry_order_status_analise'] = $this->request->post['ipagare_entry_order_status_analise'];
		} else {
			$this->data['ipagare_entry_order_status_analise'] = $this->config->get('ipagare_entry_order_status_analise'); 
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['ipagare_geo_zone_id'])) {
			$this->data['ipagare_geo_zone_id'] = $this->request->post['ipagare_geo_zone_id'];
		} else {
			$this->data['ipagare_geo_zone_id'] = $this->config->get('ipagare_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['ipagare_status'])) {
			$this->data['ipagare_status'] = $this->request->post['ipagare_status'];
		} else {
			$this->data['ipagare_status'] = $this->config->get('ipagare_status');
		}

		if (isset($this->request->post['ipagare_debug'])) {
			$this->data['ipagare_debug'] = $this->request->post['ipagare_debug'];
		} else {
			$this->data['ipagare_debug'] = $this->config->get('ipagare_debug');
		}
		
		if (isset($this->request->post['ipagare_sort_order'])) {
			$this->data['ipagare_sort_order'] = $this->request->post['ipagare_sort_order'];
		} else {
			$this->data['ipagare_sort_order'] = $this->config->get('ipagare_sort_order');
		}
		
		$this->template = 'payment/ipagare.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/ipagare')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['ipagare_estabelecimento']) {
			$this->error['estabelecimento'] = $this->language->get('error_estabelecimento');
		}
		
		if (!$this->request->post['ipagare_chave']) {
			$this->error['chave'] = $this->language->get('error_chave');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>