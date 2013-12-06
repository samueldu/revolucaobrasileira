<?php 
class ControllerIntegrationIntegrationStock extends Controller {
	private $error = array();
			
	public function index() {
		$this->load->language('integration/integration_stock');
		$this->document->title = $this->language->get('heading_title');
		$this->load->model('integration/integration_stock');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$return = $this->model_integration_integration_stock->getData($this->request->post['client'],$this->request->post['note']);
			echo "<pre>";
			var_dump($return);
			echo "</pre>";
			exit;
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_update'] = $this->language->get('button_update');
		$this->data['entry_client'] = $this->language->get('entry_client');
		$this->data['entry_note'] = $this->language->get('entry_note');
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=integration/integration_stock&token='.$this->session->data['token'];

		$this->template = 'integration/integration_stock.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
}
?>