<?php   
class ControllerConteudoIniciativa extends Controller {
	public function index() { 
	
		$ano = '2010';
		$anoVerbas = '2011';
		
		//$module_data = array();
		
		$this->load->model('checkout/extension');
		
		$this->language->load('iniciativa/iniciativa');     
		
		$results = $this->model_checkout_extension->getExtensions('module');

		//$this->data['modules'] = array();
		
		$this->document->title = $this->language->get('politico');    
		
		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=common/home',
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		); 
	
		$this->load->model('conteudo/iniciativa');  
		
		if(isset($this->request->get['iniciativaId']))
        {
            $this->data['videos'] = $this->model_conteudo_iniciativa->getVideos($this->request->get['iniciativaId']);

            require_once(DIR_SYSTEM.'library/autoEmbed/AutoEmbed.class.php');

            $AE = new AutoEmbed();

            foreach($this->data['videos'] as $key=>$value)
            {

                if (!$AE->parseUrl($this->data['videos'][$key]['url'])) {
                    print "No embeddable video found (or supported";
                }
                else
                {

                    if($this->data['videos'][$key]['ordem'] == 1)
                    $AE->setParam('autoplay',true);

                    $this->data['videos'][$key]['embed'] = $AE->getEmbedCode();
                }
            }

		    $results = $this->model_conteudo_iniciativa->getAbsurdo($this->request->get['iniciativaId']);

            $this->template = $this->config->get('config_template') . '/template/conteudo/iniciativa.tpl';
        }
		else
        {
		    $results = $this->model_conteudo_iniciativa->getAbsurdos();
            $this->template = $this->config->get('config_template') . '/template/conteudo/listagem-iniciativa.tpl';
        }
		
		
		$this->data['politicos'] = array();
		$this->data['politicos'] = $results;		
		
		

			$this->children = array(
			'common/column_right',
			'common/column_left',
			'common/footer',
			'common/header'
		);     
		
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
			
			
			
	}
}    