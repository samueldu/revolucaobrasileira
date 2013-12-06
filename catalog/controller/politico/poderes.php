<?php   
class ControllerPoliticoPoderes extends Controller {
	public function index() { 
	
		$ano = '2010';
		$anoVerbas = '2011';
		
		//$module_data = array();
		
		$this->load->model('checkout/extension');
		
		$this->language->load('politico/poderes');  
		
		$this->data['noticias_txt'] = $this->language->get('noticias');
		$this->data['processos_txt'] = $this->language->get('processos');       
		$this->data['verbas_txt'] = $this->language->get('verbas');  
		$this->data['bens_txt'] = $this->language->get('bens');  
		$this->data['casos_corrupcao_txt'] = $this->language->get('casos_corrupcao'); 
		$this->data['veja_mais_txt'] = $this->language->get('veja_mais');   
		$this->data['saiba_mais_txt'] = $this->language->get('saiba_mais');   
		
		$results = $this->model_checkout_extension->getExtensions('module');

		//$this->data['modules'] = array();
		
		$this->document->title = $this->language->get('poderes');    
		
		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=common/home',
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		); 
		
				$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=politico/poderes',
			'text'      => $this->language->get('poderes'),
			'separator' => FALSE
		); 
	
		$this->load->model('politico/poderes');
		$this->load->model('politico/politico');    
		
		if(isset($this->request->get['poderesId']))
		{   
			$results = $this->model_politico_poderes->getPoder($this->request->get['poderesId']);
			
			$this->data['politicos'] = array();
			$this->data['politicos'] = $results;	
			
			$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=politico/poderes&casaId='.$this->data['politicos'][0]['poder'],
			'text'      => $this->data['politicos'][0]['poder'],
			'separator' => FALSE);    
			
			
			$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=politico/politico&partidoId='.$this->data['politicos'][0]['ministerio'],
			'text'      => $this->data['politicos'][0]['ministerio'],
			'separator' => FALSE);
			
			
			$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=politico/politico&politicoid='.$this->data['politicos'][0]['id'],
			'text'      => $this->data['politicos'][0]['nome'],
			'separator' => FALSE);    
			
			$results = $this->model_politico_politico->getPoliticoMaterias($this->data['politicos'][0]['apelido'],$anoVerbas);  
			$this->data['materias'] = $results;
			
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/poderes.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/politico/poderes.tpl';
			} else {
				$this->template = 'default/template/politico/poderes.tpl';
			}
		}
		elseif(isset($this->request->get['partidoId']) or isset($this->request->get['casaId']))
		{
		
			if(!isset($this->request->get['partidoId']))
			$this->request->get['partidoId'] = null;
			
			$results = $this->model_politico_politico->getPoliticoPartido($this->request->get['partidoId'],$this->request->get['casaId']);   

			$resultsx = $this->model_politico_politico->getCasaDados($this->request->get['casaId']); 
			
			$dados = array(utf8_encode("Orçamento"),"Financiamentos",utf8_encode("Doações"),utf8_encode("Autodoações"),utf8_encode("Patrimônio"),"Total de verbas"); 
			
			foreach($resultsx as $key=>$value)
			{   
				if($this->substr_count_array($resultsx[$key]['descricao'],$dados) > 0){
				$resultsx[$key]['valor'] = "R$ ".number_format($this->str2num($resultsx[$key]['valor']),0,",",".");
				}
			}    

			if(!is_null($this->request->get['partidoId']))
			{
			
				$this->document->breadcrumbs[] = array(
				'href'      => HTTP_SERVER . 'index.php?route=politico/politico&partidoId='.$results[0]['partidoId'],
				'text'      => $results[0]['partidoNome'],
				'separator' => FALSE);  
			}
			
			if(!is_null($this->request->get['casaId']))
			{
				$this->document->breadcrumbs[] = array(
				'href'      => HTTP_SERVER . 'index.php?route=politico/politico&casaId='.$resultsx[0]['casaId'],
				'text'      => $resultsx[0]['casaNome'],
				'separator' => FALSE);  
			}
		
			$resultsxx = $this->model_politico_politico->getPoliticos($this->request->get['partidoId'],$this->request->get['casaId']);
			$this->data['politicos'] = array();
			$this->data['politicos'] = $resultsxx;  
			$this->data['casaId'] = $this->request->get['casaId'];
			
			
			$this->data['casa_description'] = $resultsx;     
			
			$this->data['materias'] = "";
			//$this->model_politico_politico->getPoliticoMaterias($results[0]['partidoNome'],null);  
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/casa.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/politico/casa.tpl';
			} else {
				$this->template = 'default/template/politico/casa.tpl';
			}
		}
		else
		{
		
			$this->data['partidos'] = $this->model_politico_politico->getPartidos();   
			
			$this->data['casas'] = $this->model_politico_politico->getCasas();  

			$this->load->model('localisation/zone');  
			$this->data['estados'] = $this->model_localisation_zone->getEstados();
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/listagem.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/politico/listagem.tpl';
			} else {
				$this->template = 'default/template/politico/listagem.tpl';
			}
		
		}
		
				$this->children = array(
			'common/column_right',
			'common/column_left',
			'common/footer',
			'common/header'
		); 
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
		
	}
	
	public function substr_count_array( $haystack, $needle ) {
	 $count = 0;
	 foreach ($needle as $substring) {
		  $count += substr_count($haystack, $substring);
	 }
	 return $count;
}

	public function str2num($str){ 
	  if(strpos($str, '.') < strpos($str,',')){ 
				$str = str_replace('.','',$str); 
				$str = strtr($str,',','.');            
			} 
			else{ 
				$str = str_replace(',','',$str);            
			} 
			return (float)$str; 
	} 
	
}    