<?php   
class ControllerApiPoliticians extends Controller {
	public function index() {

		$ano = '2010';
		$anoVerbas = '2011';
        $anoNoticias = '2012';
		
		//$module_data = array();
		
		$this->load->model('checkout/extension');
		
		$this->language->load('politico/politico');  
		
		$this->data['noticias_txt'] = $this->language->get('noticias');
		$this->data['processos_txt'] = $this->language->get('processos');       
		$this->data['verbas_txt'] = $this->language->get('verbas');  
		$this->data['bens_txt'] = $this->language->get('bens');  
		$this->data['casos_corrupcao_txt'] = $this->language->get('casos_corrupcao'); 
		$this->data['veja_mais_txt'] = $this->language->get('veja_mais');   
		$this->data['saiba_mais_txt'] = $this->language->get('saiba_mais');   
		
		$results = $this->model_checkout_extension->getExtensions('module');

		//$this->data['modules'] = array();
		
		$this->document->title = $this->language->get('politico');    
		
		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=common/home',
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		); 
		
				$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=politico/politico',
			'text'      => $this->language->get('politico'),
			'separator' => ">"
		); 
	
		$this->load->model('politico/politico'); 
		
		if(isset($this->request->get['politicoid']))
		{   
			$results = $this->model_politico_politico->getPolitico($this->request->get['politicoid']);

            $this->data['bancada'] = $this->model_politico_politico->getPoliticoBancada($this->request->get['politicoid']);

			$this->data['politicos'] = array();
			$this->data['politicos'] = $results;	
			
			$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=politico/politico&casaId='.$this->data['politicos'][0]['casaId'],
			'text'      => $this->data['politicos'][0]['casaNome'],
			'separator' => FALSE);    
			
			
			$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=politico/politico&partidoId='.$this->data['politicos'][0]['partidoId'],
			'text'      => $this->data['politicos'][0]['partidoNome'],
			'separator' => FALSE);
			
			
			$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=politico/politico&politicoid='.$this->data['politicos'][0]['id'],
			'text'      => $this->data['politicos'][0]['apelido'],
			'separator' => FALSE);    
			
			$results = $this->model_politico_politico->getPoliticoBens($this->request->get['politicoid'],$ano);  
			$this->data['bens'] = $results;

            $total = 0;

            foreach($this->data['bens'] as $key=>$value)
            {
                $total = $total+$this->data['bens'][$key]['valor'];
            }

            $this->data['totalBens'] = $total;

			$results = $this->model_politico_politico->getPoliticoProcessos($this->request->get['politicoid'],$ano);  
			$this->data['processos'] = $results;
			
			$results = $this->model_politico_politico->getPoliticoVerbas($this->request->get['politicoid'],$anoVerbas);  
			$this->data['verbas'] = $results;

            $totalverbas = 0;

            foreach($this->data['verbas'] as $key=>$value)
            {
                $totalverbas = $totalverbas+$this->data['verbas'][$key]['verba'];
            }

            $this->data['totalVerbas'] = $totalverbas;
			
			$results = $this->model_politico_politico->getPoliticoMaterias($this->data['politicos'][0]['apelido'],$anoNoticias);
			$this->data['materias'] = $results;
			
			$results = $this->model_politico_politico->getPoliticoCorrupcao($this->request->get['politicoid']);  
			$this->data['corrupcao'] = $results;
			
			$results = $this->model_politico_politico->getPoliticoFrases($this->request->get['politicoid']);  
			$this->data['frases'] = $results;
			
			$results = $this->model_politico_politico->getCasaBadges($this->data['politicos'][0]['casaId']);  
			$this->data['casa_badges'] = $results;

            $results = $this->model_politico_politico->getVotos($this->request->get['politicoid']);
            $this->data['votos'] = $results;

            $this->data['fotos'] = $this->model_politico_politico->getFotos($this->request->get['politicoid']);

            $this->load->model('tool/image');

            foreach ($this->data['fotos'] as $key=>$value)
            {
                $this->data['fotos'][$key]['thumb'] =  $this->model_tool_image->resize('data/fotos/'.$this->data['fotos'][$key]['filename'], 263,0);
            }

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/politico.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/politico/politico.tpl';
			} else {
				$this->template = 'default/template/politico/politico.tpl';
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

            $this->data['politicos_estado'] = $this->model_politico_politico->getPoliticosLandPageEstado();

			$this->data['politicos'] = $this->model_politico_politico->getPoliticosLandPage();

            $this->load->model('tool/image');

            foreach ($this->data['politicos'] as $key=>$value)
            {
                foreach ($this->data['politicos'][$key] as $chave=>$valor)
                {
                   if(!isset($this->data['politicos'][$key][$chave]['avatar']) or $this->data['politicos'][$key][$chave]['avatar'] == "" or is_null($this->data['politicos'][$key][$chave]['avatar']) or $key == "casa")
                    $this->data['politicos'][$key][$chave]['thumb'] =  $this->model_tool_image->resize("data/no_image.jpg", 50,50);
                    else
                    $this->data['politicos'][$key][$chave]['thumb'] =  $this->model_tool_image->resize("data/fotos/".$this->data['politicos'][$key][$chave]['avatar'], 50,0);
                }
            }

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

    public function rank()
    {

        $this->language->load('politico/politico');

        $this->load->model('politico/politico');

        $this->document->title = $this->language->get('politico');

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php',
            'text'      => "Principal",
            'separator' => "");

        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php?route=politico/politico',
            'text'      => "Políticos",
            'separator' => ">");

        if($this->request->get['rank'] == "verbas")
        {
            $this->data['titulo'] = "Uso de verbas";

        }
        elseif($this->request->get['rank'] == "processos")
        {
            $this->data['titulo'] = "Processos na justiça";
        }
        elseif($this->request->get['rank'] == "bens")
        {
            $this->data['titulo'] = "Declaração de bens";
        }
        elseif($this->request->get['rank'] == "like")
        {
            $this->data['titulo'] = "Thumbs up!";
        }
        elseif($this->request->get['rank'] == "deslike")
        {
            $this->data['titulo'] = "Thumbs down!";
        }
        elseif($this->request->get['rank'] == "corrupcao")
        {
            $this->data['titulo'] = "Associação a casos de corrupção";
        }

        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php?route=politico/politico/rank',
            'text'      => "Rank",
            'separator' => ">");

        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php?route=politico/politico/rank&rank='.$this->request->get['rank'],
            'text'      => $this->data['titulo'],
            'separator' => ">");

        $this->data['rank'] = $this->request->get['rank'];

        $this->data['politicosRank'][0]['personagens'] = $this->model_politico_politico->getRank($this->request->get['rank']);

        $this->load->model('tool/image');

        foreach ($this->data['politicosRank'][0]['personagens'] as $key=>$value)
        {

            if(!isset($this->data['politicosRank'][0]['personagens'][$key]['avatar']) or $this->data['politicosRank'][0]['personagens'][$key]['avatar'] == "" or is_null($this->data['politicosRank'][0]['personagens'][$key]['avatar']) or $key == "casa")
                $this->data['politicosRank'][0]['personagens'][$key]['thumb'] =  $this->model_tool_image->resize("data/no_image.jpg", 100,100);
            else
                $this->data['politicosRank'][0]['personagens'][$key]['thumb'] =  $this->model_tool_image->resize("data/fotos/".$this->data['politicosRank'][0]['personagens'][$key]['avatar'], 100,0);

        }

        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));

    }

    public function getPoliticiansId()
    {
        $ano = '2010';
        $anoVerbas = '2011';
        $anoNoticias = '2012';

        $output= "";

        $this->load->model('api/api');

        $this->load->model('tool/image');

        foreach($this->request->post as $keyx=>$valuex)
        {
            $results = $this->model_api_api->getPoliticos($valuex);

            foreach($results as $key=>$value)
            {
                $output .= "<politico>";

                foreach($results[$key] as $chave=>$valor)
                {
                    $output .= "<".$chave.">".($valor)."</".$chave.">";
                }

                $output .= "</politico>";

            }
        }
            $this->creatXML($output);
        }

    public function listPoliticians()
    {

        $ano = '2010';

        $anoVerbas = '2011';

        $anoNoticias = '2012';

        $this->load->model('politico/politico');

        $output= "";

        $output .= "<politicos>";

        foreach($this->request->post as $key=>$value)
        {
            $output .= "<politico>";

            $this->request->get['politicoid'] = $value;

            $resultsPolitico = $this->model_politico_politico->getPolitico($this->request->get['politicoid']);

            $output .= "<nome>".$resultsPolitico[0]['nome']."</nome>";

            $output .= "<partido>".$resultsPolitico[0]['partidoNome']."</partido>";

            $output .= "<estado>".$resultsPolitico[0]['uf_sigla']."</estado>";

            $bancada = $this->model_politico_politico->getPoliticoBancada($this->request->get['politicoid']);

            $this->data['politicos'] = array();
            $this->data['politicos'] = $resultsPolitico;

            foreach($bancada as $keyu=>$valueu){
                $output .= "<bancada>".$bancada[$keyu]['grupo']."</bancada>";
            }

            $results = $this->model_politico_politico->getPoliticoBens($this->request->get['politicoid'],$ano);

            if($results)
            {

            $this->data['bens'] = $results;

            $output .= '<bens>';

            $total = 0;

            foreach($this->data['bens'] as $keyx=>$valuex)
            {
                $output .= "<item>";
                $output .= '<descricao>'.(str_replace("=>"," : ",$this->data['bens'][$keyx]['bem'])).'</descricao>';
                $output .= "<valor>".$this->data['bens'][$keyx]['valor']."</valor>";
                $output .= "<ano>".$ano."</ano>";
                $output .= "</item>";
            }

            $output .= "</bens>";
            }

            $results = $this->model_politico_politico->getPoliticoProcessos($this->request->get['politicoid'],$ano);

            //print_r($results);

            $this->data['processos'] = $results;

            if($results)
            {

                $output .= '<justica>';

                $total = 0;

                foreach($this->data['processos'] as $keyx=>$valuex)
                {
                    $output .= "<item>";

                    if($this->data['processos'][$keyx]['fonte'] != "")
                        $output .= '<origem><![CDATA[ '.$this->data['processos'][$keyx]['fonte'].' ]]></origem>';

                    if($this->data['processos'][$keyx]['descricao'] != "" and strlen($this->data['processos'][$keyx]['descricao']) > 2)
                    {
                        //$this->data['processos'][$keyx]['descricao'] = "teste";

                        $output .= '<descricao><![CDATA['.$this->data['processos'][$keyx]['descricao'].']]></descricao>';
                    }

                    if($this->data['processos'][$keyx]['link'] != "")
                        $output .= '<url><![CDATA['.$this->data['processos'][$keyx]['link'].']]></url>';

                    $output .= "</item>";
                }

                $this->data['totalBens'] = $total;

                $output .= "</justica>";
            }

            $results = $this->model_politico_politico->getPoliticoVerbasAPI($this->request->get['politicoid'],$anoVerbas,$resultsPolitico[0]['casaId']);
            $this->data['verbas'] = $results;

            $totalverbas = 0;

            $output .= "<verbas>";

            foreach($this->data['verbas'] as $keyz=>$valuez)
            {
                $output .= "<item>";
                    $output .= "<ano>".$this->data['verbas'][$keyz]['ano']."</ano>";
                    $output .= "<mes>".$this->data['verbas'][$keyz]['mes']."</mes>";
                    $output .= "<valor>".$this->data['verbas'][$keyz]['verba']."</valor>";
                    $output .= "<descricao><![CDATA[".$this->data['verbas'][$keyz]['descricao']."]]></descricao>";
                $output .= "</item>";
            }

            $output .= "</verbas>";

            $results = $this->model_politico_politico->getPoliticoMaterias($this->data['politicos'][0]['apelido'],$anoNoticias);
            $this->data['materias'] = $results;

            $results = $this->model_politico_politico->getPoliticoCorrupcao($this->request->get['politicoid']);
            $this->data['corrupcao'] = $results;

            $output .= "<escandalos>";

            foreach($this->data['corrupcao'] as $keyz=>$valuez)
            {
                $output .= "<item>";
                $output .= "<nome>".$this->data['corrupcao'][$keyz]['corrupcaoTitulo']."</nome>";
                $output .= "<data>".$this->data['corrupcao'][$keyz]['data']."</data>";
                $output .= "</item>";
            }

            $output .= "</escandalos>";

            $results = $this->model_politico_politico->getPoliticoFrases($this->request->get['politicoid']);
            $this->data['frases'] = $results;

            $results = $this->model_politico_politico->getCasaBadges($this->data['politicos'][0]['casaId']);
            $this->data['casa_badges'] = $results;

            $results = $this->model_politico_politico->getVotos($this->request->get['politicoid']);
            $this->data['votos'] = $results;

            $this->data['fotos'] = $this->model_politico_politico->getFotos($this->request->get['politicoid']);

            $this->load->model('tool/image');

            foreach ($this->data['fotos'] as $keye=>$valuee)
            {
                $this->data['fotos'][$keye]['thumb'] =  $this->model_tool_image->resize('data/fotos/'.$this->data['fotos'][$keye]['filename'], 263,0);
            }


            $output .= "</politico>";
        }

        $output .= "</politicos>";

        $this->creatXML($output);
    }

    public function creatXML($data)
    {

        $output  = '<?xml version="1.0" encoding="UTF-8" ?>';

        $output .= "<return>";

        $output .= $data;

        $output .= "</return>";

        $this->response->addHeader('Content-Type: application/xml');
        $this->response->setOutput($output);

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