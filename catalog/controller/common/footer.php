<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {
		$this->language->load('common/footer');
		
		$this->data['text_powered_by'] = sprintf($this->language->get('text_powered_by'), $this->config->get('config_name'), date('Y', time()));
		
		$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		$this->data['text_contact'] = $this->language->get('text_contact');

		
    	$this->data['sitemap'] = HTTP_SERVER . 'index.php?route=information/sitemap';
		$this->data['contact'] = HTTP_SERVER . 'index.php?route=information/contact';
		
		$this->data['template'] = TEMPLATE;
		
		$this->id = 'information';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/information.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/information.tpl';
		} else {
			$this->template = 'default/template/module/information.tpl';
		}
		
		$this->load->model('catalog/information');
		$this->load->model('tool/seo_url');
		
		$this->data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			
			$href = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=information/information&information_id=' . $result['information_id']);
			
			if(TEMPLATE == "armazem" and substr_count($href,"colecao-verao-2012"))
			{
				
			}
			else
			{
			
      		$this->data['informations'][] = array(
        		'title' => $result['title'],
	    		'href'  => $href);
			}
    	}
    	
    	$module_data = array();
    	
    	$this->load->model('checkout/extension');
		
		$results = $this->model_checkout_extension->getExtensions('module');

		foreach ($results as $result) {
			if ($this->config->get($result['key'] . '_status') && ($this->config->get($result['key'] . '_position') == 'footer')) {
				$module_data[] = array(
					'code'       => $result['key'],
					'sort_order' => $this->config->get($result['key'] . '_sort_order')
				);
				
				$this->children[] = 'module/' . $result['key'];		
			}
		}

		$sort_order = array(); 
	  
		foreach ($module_data as $key => $value) {
      		$sort_order[$key] = $value['sort_order'];
    	}

    	array_multisort($sort_order, SORT_ASC, $module_data);	

		$this->data['modules'] = $module_data;
		
		$this->id = 'footer';
		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}
		
		$this->render();
	}
}
?>