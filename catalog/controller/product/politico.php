<?php   
class ControllerProductPolitico extends Controller {
	protected function index() { 
		
		//$module_data = array();
		
		//$this->load->model('checkout/extension');
		
		//$results = $this->model_checkout_extension->getExtensions('module');

		//$this->data['modules'] = array();
		
		
		print $this->config->get('config_template');
		
		
	   
	
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/politico.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/politico.tpl';
		} else {
			$this->template = 'default/template/politico/politico.tpl';
		}
		
				$this->children = array(
			'common/column_right',
			'common/column_left',
			'common/footer',
			'common/header'
		);     
		
		
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
			
			
	}
}    