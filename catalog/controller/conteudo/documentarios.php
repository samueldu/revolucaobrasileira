<?php   
class ControllerConteudoDocumentarios extends Controller {
	public function index() { 
	
		$ano = '2010';
		$anoVerbas = '2011';
		
		//$module_data = array();
		
		$this->load->model('checkout/extension');
		
		$this->language->load('conteudo/documentarios');     
		
		$results = $this->model_checkout_extension->getExtensions('module');

		$this->data['modules'] = array();
		
		$this->document->title = $this->language->get('politico');    
		
		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=common/home',
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		); 
		
		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=conteudo/documentarios',
			'text'      => "Documentários",
			'separator' => FALSE
		); 
	
		$this->load->model('conteudo/documentarios');

        $this->data['categorias'] = $this->model_conteudo_documentarios->getDocCat();

		if(isset($this->request->get['documentario_id']))
        {
		    $results = $this->model_conteudo_documentarios->getDoc($this->request->get['documentario_id'],null);

            $relacionados = $this->model_conteudo_documentarios->getDocRel($this->request->get['documentario_id'],$results[key($results)]['categoria_id']);

            $this->data['politicos'] = array();

            foreach($relacionados as $key=>$value)
            {
                $relacionados[$key]['descricao'] = $this->resumo($relacionados[$key]['descricao'],125);

            }

            $this->data['relacionados'] = $relacionados;



            $this->template = $this->config->get('config_template') . '/template/conteudo/documentarios.tpl';
        }
        elseif(isset($this->request->get['tag']))
        {
            $results = $this->model_conteudo_documentarios->getDocByTag($this->request->get['tag']);
            $this->template = $this->config->get('config_template') . '/template/conteudo/listagem-documentarios.tpl';
        }
		elseif($this->request->get['documentario_categoria'])
        {
		    $results = $this->model_conteudo_documentarios->getDoc(null,$this->request->get['documentario_categoria']);
            $this->template = $this->config->get('config_template') . '/template/conteudo/listagem-documentarios.tpl';
        }
        else
        {
            $results = $this->model_conteudo_documentarios->getDoc($this->request->get['documentario_id'],null);
            $this->template = $this->config->get('config_template') . '/template/conteudo/listagem-documentarios.tpl';
        }

        foreach($results as $key=>$value)
        {
            $results[$key]['descricao'] = $this->resumo($results[$key]['descricao'],125);

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

    public function resumo($texto,$qnt){
        $resumo=substr($texto,'0',$qnt);
        $last=strrpos($resumo," ");
        $resumo=substr($resumo,0,$last);
        return $resumo."...";
    }

}    