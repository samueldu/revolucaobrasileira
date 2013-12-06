<?php
class ControllerShippingEsedex extends Controller {
	private $error = array(); 
	public function index() {   
		$this->load->language('shipping/esedex');
		$this->document->title = $this->language->get('heading_title');
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('esedex', $this->request->post);		
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/shipping&token=' . $this->session->data['token']);
		}
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_sim'] = $this->language->get('text_sim');
		$this->data['text_nao'] = $this->language->get('text_nao');
		$this->data['entry_cost'] = $this->language->get('entry_cost');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['entry_postcode']= $this->language->get('entry_postcode');
		$this->data['entry_mao_propria']= $this->language->get('entry_mao_propria');
		$this->data['entry_aviso_recebimento']= $this->language->get('entry_aviso_recebimento');
		$this->data['entry_declarar_valor']= $this->language->get('entry_declarar_valor');
		$this->data['entry_adicional']= $this->language->get('entry_adicional');
				
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if (isset($this->error['postcode'])) {
			$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
		}
  		$this->document->breadcrumbs = array();
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/shipping&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_shipping'),
      		'separator' => ' :: '
   		);
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=shipping/esedex&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=shipping/esedex&token=' . $this->session->data['token'];
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/shipping&token=' . $this->session->data['token'];
		if (isset($this->request->post['esedex_status'])) {
			$this->data['esedex_status'] = $this->request->post['esedex_status'];
		} else {
			$this->data['esedex_status'] = $this->config->get('esedex_status');
		}
		if (isset($this->request->post['esedex_tax_class_id'])) {
			$this->data['esedex_tax_class_id'] = $this->request->post['esedex_tax_class_id'];
		} else {
			$this->data['esedex_tax_class_id'] = $this->config->get('esedex_tax_class_id');
		}
		if (isset($this->request->post['esedex_geo_zone_id'])) {
			$this->data['esedex_geo_zone_id'] = $this->request->post['esedex_geo_zone_id'];
		} else {
			$this->data['esedex_geo_zone_id'] = $this->config->get('esedex_geo_zone_id');
		}
		if (isset($this->request->post['esedex_postcode'])) {
			$this->data['esedex_postcode'] = $this->request->post['esedex_postcode'];
		} else {
			$this->data['esedex_postcode'] = $this->config->get('esedex_postcode');
		}
		
		if (isset($this->request->post['esedex_mao_propria'])) {
			$this->data['esedex_mao_propria'] = $this->request->post['esedex_mao_propria'];
		} else {
			$this->data['esedex_mao_propria'] = $this->config->get('esedex_mao_propria');
		}
		if (isset($this->request->post['esedex_aviso_recebimento'])) {
			$this->data['esedex_aviso_recebimento'] = $this->request->post['esedex_aviso_recebimento'];
		} else {
			$this->data['esedex_aviso_recebimento'] = $this->config->get('esedex_aviso_recebimento');
		}
		if (isset($this->request->post['esedex_declarar_valor'])) {
			$this->data['esedex_declarar_valor'] = $this->request->post['esedex_declarar_valor'];
		} else {
			$this->data['esedex_declarar_valor'] = $this->config->get('esedex_declarar_valor');
		}
		if (isset($this->request->post['esedex_adicional'])) {
			$this->data['esedex_adicional'] = $this->request->post['esedex_adicional'];
		} else {
			$this->data['esedex_adicional'] = $this->config->get('esedex_adicional');
		}		
		
		if (isset($this->request->post['esedex_sort_order'])) {
			$this->data['esedex_sort_order'] = $this->request->post['esedex_sort_order'];
		} else {
			$this->data['esedex_sort_order'] = $this->config->get('esedex_sort_order');
		}
		$this->load->model('localisation/tax_class');
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		$this->load->model('localisation/geo_zone');
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		$this->template = 'shipping/esedex.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/esedex')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!preg_match ("/^([0-9]{2})\.?([0-9]{3})-?([0-9]{3})$/", $this->request->post['esedex_postcode'])) {
			$this->error['postcode'] = $this->language->get('error_postcode');
		}
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>