<?php   
class ControllerMateriasMaterias extends Controller {
	public function index() { 
	
		$ano = '2010';
		$anoVerbas = '2011';
		
		//$module_data = array();
		
		$this->load->model('checkout/extension');
		
		$this->language->load('materias/materias');
		
		$this->load->model('tool/seo_url');        
		
		$results = $this->model_checkout_extension->getExtensions('module');

		//$this->data['modules'] = array();
		
		$this->document->title = $this->language->get('politico');    
		
		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=common/home',
			'text'      => $this->language->get('text_home'),
			'separator' => false
		); 
		
		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=materias/materias',
			'text'      => "Materias",
			'separator' => false
		); 
	
		$this->load->model('materias/materias');  
		
		$this->data['veja_mais'] = $this->language->get('veja_mais');   
		$this->data['tamanho_da_fonte'] = $this->language->get('tamanho_da_fonte');  
		
		if (isset($this->request->get['page'])) {
		$page = $this->request->get['page'];
		} else { 
		$page = 1;
		}    

		$sort = "";
		$order = "";
		
		$url = '';

		if (isset($this->request->get['sort'])) {
		$url .= '&sort=' . $this->request->get['sort'];
		}    

		if (isset($this->request->get['order'])) {
		$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['manufacturer_id'])) {
		$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
		}

		if (isset($this->request->get['option_id'])) {
		$url .= '&option_id=' . $this->request->get['option_id'];
		}
		
		/* materia id*/
		if(isset($this->request->get['materia_id']))
		{	
		
			$results = $this->model_materias_materias->getMateria($this->request->get['materia_id']); 

            /* pega nomes proprios */
			$names = $this->getNames($results[0]['texto']);

            //print_r($names);
					
			$frases[$this->request->get['materia_id']]['texto'] = $results[0]['texto'];
			$frases[$this->request->get['materia_id']]['nomes'] = $names['nomes'];
			$frases[$this->request->get['materia_id']]['siglas'] = $names['siglas'];
			$frases[$this->request->get['materia_id']] = $this->model_materias_materias->insertTags($frases[$this->request->get['materia_id']]);

			$results[0]['texto'] = $this->replaceText($frases,$frases[$this->request->get['materia_id']]['texto']);
				 
			//$veja_tambem = $this->model_materias_materias->getMateriasHome($this->request->get['materia_id']);

            $veja_tambem = $this->model_materias_materias->getMateriaByJornalId($results[0]['jornalId'],null,null,null,5);
			
			$essa_semana = $this->model_materias_materias->getMateriasEssaSemana($this->request->get['materia_id']);    
					
			$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=materias/materias&jornal_id='.$results[0]['jornalId'],
			'text'      => $results[0]['nome'],
			'separator' => false
			); 
			
			$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=materias/materias&materia_id='.$this->request->get['materia_id'],
			'text'      => $results[0]['titulo'],
			'separator' => FALSE
			);
			   
			$marks = '';  
			
			$marks = $this->model_materias_materias->getMateriaMark($this->request->get['materia_id']); 
			
			$this->data['veja_tambem'] = array();
			$this->data['veja_tambem'] = $veja_tambem;  
			
			$this->data['essa_semana'] = array();
			$this->data['essa_semana'] = $essa_semana;  
			
			$this->data['politicos'] = array();
			$this->data['politicos'] = $results;    
			$this->data['marks'] = $marks;        

			$this->template = $this->config->get('config_template') . '/template/materias/materias.tpl';  
			
		}
		/* jornal id*/
		elseif(isset($this->request->get['jornal_id']))
		{ 
		
			$product_total = $this->model_materias_materias->getTotalMateriaByJornalId($this->request->get['jornal_id'], $sort, $order, ($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'));
			
			$results = $this->model_materias_materias->getMateriaByJornalId($this->request->get['jornal_id'], $sort, $order, ($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'));
			
			$this->data['politicos'] = array();
			
			$this->data['politicos'] = $results;  
			
			$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=materias/materias',
			'text'      => $results[0]['nome'],
			'separator' => FALSE
			); 
			
			$this->template = $this->config->get('config_template') . '/template/materias/listagem.tpl';  

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_catalog_limit');
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=materias/materias&jornal_id=' . $this->request->get['jornal_id'] . $url . '&page={page}');

			$this->data['pagination'] = $pagination->render();
		}
		else
		{
			/* index */   
			$results = $this->model_materias_materias->getMateriasHome('',15);


			$this->data['politicos'] = array();
			$this->data['politicos'] = $results;

            /* index */
            $results = $this->model_materias_materias->getMateriasHomeEstado('',3);

            $this->data['estado'] = array();
            $this->data['estado'] = $results;

            $this->template = $this->config->get('config_template') . '/template/materias/index.tpl';
		}


		$this->children = array(
			'common/column_right',
			'common/column_left',
			'common/footer',
			'common/header'
		);     
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
	}
	
			
	public function getNames($texto)
	{

        $regSiglas = "/([A-ZÀ-Ü-]+[-zA-ZÀ-])/";

        preg_match_all($regSiglas,utf8_decode($texto),$siglas);

        foreach($siglas[0] as $key=>$value)
        {
            $siglasAux[$key]['nome'] = utf8_encode($value);
        }

        $retorno['siglas'] = $siglasAux;
	
	$nomesAux = "";
		$reg = "/^[A-Z-��-�]'?[- a-zA-Z]([ a-zA-Z])*/";
		//$reg = "/\b[a-zA-Z�-��-�]'?[- a-zA-Z]([ a-zA-Z�-��-�]+)\b/";
		
		//$reg = "/\b[A-Z]([a-z]+|\.)(?:\s+[A-Z]([a-z]+|\.))*(?:\s+[a-z][a-z\-]+){0,2}\s+[A-Z]([a-z]+|\.)\b/";
	//    $reg = "/([A-Z]+[a-zA-Z]*)(\s|\-)?([A-Z]+[a-zA-Z]*)?(\s|\-)?([A-Z]+[a-zA-Z]*)?/";
	//     essa funciona $reg = "/([A-Z�-�]+[a-zA-Z�-��-�]*)(\s|\-)?([A-Z�-�]+[a-zA-Z�-��-�]*)?(\s|\-)?([A-Z]+[a-zA-Z]*)?/"; 
	//([A-Z�-�]+[a-zA-Z�-��-�]*)(\s|\-)([A-Z�-�]+[a-zA-Z�-��-�]*)([A-Z]+[a-zA-Z]*)? 
		$reg = "/([A-Z�-�]+[a-zA-Z�-��-�]*)(\s|\-)?([A-Z�-�]+[a-zA-Z�-��-�]*){0,2}\s+[A-Z]([a-z]+|\.)([A-Z]+[a-zA-Z]*)?/"; 
		$reg = "/([A-Z�-�]+[a-zA-Z�-��-�]*)(\s|\-|de)?([A-Z�-�]+[a-zA-Z�-��-�]*)([A-Z]+[a-zA-Z]*)?/";
		$regNomes = "/([A-Z�-�]+[a-zA-Z�-��-�]*)( de | da |\s|)([A-Z�-�]+[a-zA-Z�-��-�]*)([A-Z]+[a-zA-Z]*)?( de | da |\s|)?([A-Z�-�]+[a-zA-Z�-��-�]*)?/";
        $regNomes = "/([A-ZÀ-Ü]+[a-zA-ZÀ-Üà-ü]*)( de | da |\s|)([A-ZÀ-Ü]+[a-zA-ZÀ-Üà-ü]*)([A-Z]+[a-zA-Z]*)?( de | da |\s|)?([A-ZÀ-Ü]+[a-zA-ZÀ-Üà-ü]*)?/";
		
		preg_match_all(utf8_decode($regNomes),utf8_decode($texto),$nomes);

		$nomesAux = array();
		
		foreach($nomes[0] as $key=>$value)
		{

		    if(strlen(trim($value)) >2)
            {
                if(strtoupper(utf8_encode($value)) != utf8_encode(trim($value)))
                $nomesAux[$key]['nome'] = utf8_encode(trim($value));
            }
		}

		$retorno['nomes'] = ($nomesAux);

		return $retorno;
	}	

	public function replaceText($frases,$texto)
	{
	
		foreach($frases as $keyx=>$valuex)
		{
			$texto = $frases[$keyx]['texto'];
		}

		foreach($frases[$keyx]['nomes'] as $key=>$value)
		{
		
		unset($url);
		
			if(isset($frases[$keyx]['nomes'][$key]['politicoId']))
			{
				$url = "politico/politico?politicoid=".$frases[$keyx]['nomes'][$key]['politicoId'];
			}
			elseif(isset($frases[$keyx]['nomes'][$key]['poderesId']))
			{
				$url = "politico/poderes?poderesId=".$frases[$keyx]['nomes'][$key]['poderesId'];
			}
			elseif(isset($frases[$keyx]['nomes'][$key]['governadoresId']))
			{
				$url = "politico/governadores?governadoresId=".$frases[$keyx]['nomes'][$key]['governadoresId'];
			}
			
			if(isset($url))
			{				
				$url_mod = preg_quote($frases[$keyx]['nomes'][$key]['nome'], '/');
				$texto = preg_replace("/".$url_mod."/", "<a href=\"$url\"><b>".$frases[$keyx]['nomes'][$key]['nome']."</b></a>", $texto);
			}
		}


		foreach($frases[$keyx]['siglas'] as $key=>$value)
		{

            $url = "#";

            if(isset($frases[$keyx]['siglas'][$key]['partidoId']))
            {
                $url = "politico/politico?partidoId=".$frases[$keyx]['siglas'][$key]['partidoId'];
            }
            elseif(isset($frases[$keyx]['nomes'][$key]['poderesId']))
            {
                $url = "politico/poderes?poderesId=".$frases[$keyx]['nomes'][$key]['poderesId'];
            }
            elseif(isset($frases[$keyx]['nomes'][$key]['governadoresId']))
            {
                $url = "politico/governadores?governadoresId=".$frases[$keyx]['nomes'][$key]['governadoresId'];
            }

			$url_mod = preg_quote($frases[$keyx]['siglas'][$key]['nome'], '/');

            if(isset($frases[$keyx]['siglas'][$key]['desc']))
			$texto = preg_replace("/".$url_mod."/", "<a href=\"$url\" title=\"".$frases[$keyx]['siglas'][$key]['desc']."\"><b>".$frases[$keyx]['siglas'][$key]['nome']."</b></a>", $texto);
		}

	
	return $texto;
	
	}
	
}    