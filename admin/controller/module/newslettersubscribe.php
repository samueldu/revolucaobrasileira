<?php
class ControllerModulenewslettersubscribe extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/newslettersubscribe');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('newslettersubscribe', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right');
        $this->data['text_info'] = $this->language->get('text_info');

		$this->data['entry_unsubscribe'] = $this->language->get('entry_unsubscribe');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_options'] = $this->language->get('entry_options');
		$this->data['entry_mail'] = $this->language->get('entry_mail');
		$this->data['entry_thickbox'] = $this->language->get('entry_thickbox');
		$this->data['entry_registered'] = $this->language->get('entry_registered');		
		
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

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
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_module'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=module/newslettersubscribe&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=module/newslettersubscribe&token=' . $this->session->data['token'];
		
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token'];

		
		if (isset($this->request->post['newslettersubscribe_position'])) {
			$this->data['newslettersubscribe_position'] = $this->request->post['newslettersubscribe_position'];
		} else {
			$this->data['newslettersubscribe_position'] = $this->config->get('newslettersubscribe_position');
		}
		
		if (isset($this->request->post['option_unsubscribe'])) {
			$this->data['option_unsubscribe'] = $this->request->post['option_unsubscribe'];
		} else {
			$this->data['option_unsubscribe'] = $this->config->get('option_unsubscribe');
		}
		
		if (isset($this->request->post['newslettersubscribe_registered'])) {
			$this->data['newslettersubscribe_registered'] = $this->request->post['newslettersubscribe_registered'];
		} else {
			$this->data['newslettersubscribe_registered'] = $this->config->get('newslettersubscribe_registered');
		}

		if (isset($this->request->post['newslettersubscribe_status'])) {
			$this->data['newslettersubscribe_status'] = $this->request->post['newslettersubscribe_status'];
		} else {
			$this->data['newslettersubscribe_status'] = $this->config->get('newslettersubscribe_status');
		}
		
		if (isset($this->request->post['newslettersubscribe_sort_order'])) {
			$this->data['newslettersubscribe_sort_order'] = $this->request->post['newslettersubscribe_sort_order'];
		} else {
			$this->data['newslettersubscribe_sort_order'] = $this->config->get('newslettersubscribe_sort_order');
		}
		
		if (isset($this->request->post['newslettersubscribe_mail_status'])) {
			$this->data['newslettersubscribe_mail_status'] = $this->request->post['newslettersubscribe_mail_status'];
		} else {
			$this->data['newslettersubscribe_mail_status'] = $this->config->get('newslettersubscribe_mail_status');
		}
		
		if (isset($this->request->post['newslettersubscribe_thickbox'])) {
			$this->data['newslettersubscribe_thickbox'] = $this->request->post['newslettersubscribe_thickbox'];
		} else {
			$this->data['newslettersubscribe_thickbox'] = $this->config->get('newslettersubscribe_thickbox');
		}
		
		
		if (isset($this->request->post['newslettersubscribe_option_field'])) {
			$this->data['newslettersubscribe_option_field'] = $this->request->post['newslettersubscribe_option_field'];
		} else {
			$this->data['newslettersubscribe_option_field'] = $this->config->get('newslettersubscribe_option_field');
		}
		
		if (isset($this->request->post['newslettersubscribe_option_field1'])) {
			$this->data['newslettersubscribe_option_field1'] = $this->request->post['newslettersubscribe_option_field1'];
		} else {
			$this->data['newslettersubscribe_option_field1'] = $this->config->get('newslettersubscribe_option_field1');
		}
		
		if (isset($this->request->post['newslettersubscribe_option_field2'])) {
			$this->data['newslettersubscribe_option_field2'] = $this->request->post['newslettersubscribe_option_field2'];
		} else {
			$this->data['newslettersubscribe_option_field2'] = $this->config->get('newslettersubscribe_option_field2');
		}
		
		if (isset($this->request->post['newslettersubscribe_option_field3'])) {
			$this->data['newslettersubscribe_option_field3'] = $this->request->post['newslettersubscribe_option_field3'];
		} else {
			$this->data['newslettersubscribe_option_field3'] = $this->config->get('newslettersubscribe_option_field3');
		}
		
		if (isset($this->request->post['newslettersubscribe_option_field4'])) {
			$this->data['newslettersubscribe_option_field4'] = $this->request->post['newslettersubscribe_option_field4'];
		} else {
			$this->data['newslettersubscribe_option_field4'] = $this->config->get('newslettersubscribe_option_field4');
		}
		
		if (isset($this->request->post['newslettersubscribe_option_field5'])) {
			$this->data['newslettersubscribe_option_field5'] = $this->request->post['newslettersubscribe_option_field5'];
		} else {
			$this->data['newslettersubscribe_option_field5'] = $this->config->get('newslettersubscribe_option_field5');
		}
		
		if (isset($this->request->post['newslettersubscribe_option_field6'])) {
			$this->data['newslettersubscribe_option_field6'] = $this->request->post['newslettersubscribe_option_field6'];
		} else {
			$this->data['newslettersubscribe_option_field6'] = $this->config->get('newslettersubscribe_option_field6');
		}
		
		
		$this->template = 'module/newslettersubscribe.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/newslettersubscribe')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>