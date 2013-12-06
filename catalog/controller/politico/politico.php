<?php   
class ControllerPoliticoPolitico extends Controller {
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
			'separator' => false
		); 
	
		$this->load->model('politico/politico'); 
		
        /* tela politico */
		if(isset($this->request->get['politicoid']))
		{

            $results = $this->model_politico_politico->getPolitico($this->request->get['politicoid']);

            $this->data['politicos'] = array();
            $this->data['politicos'] = $results;
            $this->data['politicos'][0]['politicoId']= $this->request->get['politicoid'];
            $this->data['politicos'][0]['id']= $this->request->get['politicoid'];
            
            $this->data['transparencia'] = $this->model_politico_politico->getPoliticoTransparencia($this->data['politicos'][0]['ufId']);

            $this->data['bancada'] = $this->model_politico_politico->getPoliticoBancada($this->request->get['politicoid']);

            $this->data['assiduidade'] = $this->model_politico_politico->getPoliticoAssiduidade($this->request->get['politicoid']);

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

            if(isset($this->data['bancada'][0]["grupo"]))
            {
                $keyWords = ", bancada ".strtolower($this->data['bancada'][0]["grupo"]);
            }
            else
            {
                $keyWords = "";
            };
            
            $this->document->keywords = $this->data['politicos'][0]['nome'].", ".$this->data['politicos'][0]['apelido'].", ".$this->data['politicos'][0]['partidoNome'].", ".$this->data['politicos'][0]['cargo'].$keyWords;
            
            $this->document->description = $this->data['politicos'][0]['apelido'];
            
            $this->document->title = $this->data['politicos'][0]['nome']." - ".$this->data['politicos'][0]['partidoNome']." - ".$this->data['politicos'][0]['casaNome']." - ".$this->language->get('politico');  

            /* bens */
			
			$results = $this->model_politico_politico->getPoliticoBens($this->request->get['politicoid'],$ano);  
			$this->data['bens'] = $results;

            $total = 0;

            foreach($this->data['bens'] as $key=>$value)
            {
                $total = $total+$this->data['bens'][$key]['valor'];
            }

            $this->data['totalBens'] = $total;

            /* processos */

			$results = $this->model_politico_politico->getPoliticoProcessos($this->request->get['politicoid'],$ano);  
			$this->data['processos'] = $results;

            /* verbas */
			
			$results = $this->model_politico_politico->getPoliticoVerbas($this->request->get['politicoid'],$anoVerbas,$this->data['politicos'][0]['casaId']);
			$this->data['verbas'] = $results;

            /* media de verbas */

            $results = $this->model_politico_politico->getPoliticoMediaVerbas($this->data['politicos'][0]['casaId']);
            $this->data['mediaVerbas'] = $results;

            if(count($this->data['mediaVerbas']) and count($this->data['verbas']) and ($this->data['politicos'][0]['casaId'] == "1" or $this->data['politicos'][0]['casaId'] == "2"))
                $this->data['mediaVerbasGrafico'] = $this->retornaDadosGrafico($this->data['mediaVerbas']);
            else
                $this->data['mediaVerbasGrafico'] = array();

            if(count($this->data['verbas']) and ($this->data['politicos'][0]['casaId'] == "1" or $this->data['politicos'][0]['casaId'] == "2"))
                $this->data['verbasGrafico'] = $this->retornaDadosGrafico($this->data['verbas']);
            else
                $this->data['verbasGrafico'] = array();

            foreach($this->data['mediaVerbasGrafico'] as $key=>$value)
            {
                if(!isset($this->data['verbasGrafico'][$key]))
                    $this->data['verbasGrafico'][$key] = 0;
            }

            ksort( $this->data['verbasGrafico']);

            $totalverbas = 0;

            foreach($this->data['verbas'] as $key=>$value)
            {
                $totalverbas = $totalverbas+$this->data['verbas'][$key]['verba'];
            }

            $this->data['totalVerbas'] = $totalverbas;

            $this->data['materias'] = array();
			
			/*$results = $this->model_politico_politico->getPoliticoMaterias($this->data['politicos'][0]['apelido'],$anoNoticias);
			$this->data['materias'] = $results;
			*/
			
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

                if(!is_file(DIR_IMAGE."data/fotos/".$this->data['fotos'][$key]['filename']))
                {
                    $this->data['fotos'][$key]['thumb'] = $this->model_tool_image->cropsize("data/no_image.jpg", 263,0);
                    $this->data['fotos'][$key]['filename'] =  $this->model_tool_image->resize("data/no_image.jpg", 600,0);
                }
                else
                {
                    $this->data['fotos'][$key]['thumb'] =  $this->model_tool_image->resize('data/fotos/'.$this->data['fotos'][$key]['filename'], 263,0);
                    $this->data['fotos'][$key]['filename'] =  $this->model_tool_image->resize('data/fotos/'.$this->data['fotos'][$key]['filename'], 600,0);
                }
            }

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/politico.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/politico/politico.tpl';
			} else {
				$this->template = 'default/template/politico/politico.tpl';
			}
		}
		elseif(isset($this->request->get['casaId']))
		{

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
        elseif(isset($this->request->get['partidoId']))
        {
            $results = $this->model_politico_politico->getPoliticoPartido($this->request->get['partidoId']);

            $this->data['partido'] = array();

            $this->data['partido'] = $results;

            if(!is_null($this->request->get['partidoId']))
            {

                $this->document->breadcrumbs[] = array(
                    'href'      => HTTP_SERVER . 'index.php?route=politico/politico&partidoId='.$results[0]['partidoId'],
                    'text'      => $results[0]['partidoNome'],
                    'separator' => FALSE);
            }

            $resultsxx = $this->model_politico_politico->getPoliticos(null,$this->request->get['partidoId'],null,null,'politicos.nome','ASC',0,500);

            $this->data['politicos'] = array();

            $this->data['politicos'] = $resultsxx;

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/partido.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/politico/partido.tpl';
            } else {
                $this->template = 'default/template/politico/partido.tpl';
            }
        }
		else
		{
            $this->data['politicos_estado'] = $this->model_politico_politico->getPoliticosLandPageEstado();

			$this->data['politicos'] = $this->model_politico_politico->getPoliticosLandPage();

            $this->data['bancada'] = $this->model_politico_politico->getBancada();

            $this->load->model('tool/image');

            foreach ($this->data['politicos'] as $key=>$value)
            {
                foreach ($this->data['politicos'][$key] as $chave=>$valor)
                {
                    foreach ($this->data['politicos'][$key][$chave] as $chavedois=>$valordois)
                    {
                       if(!isset($this->data['politicos'][$key][$chave][$chavedois]['avatar']) or $this->data['politicos'][$key][$chave][$chavedois]['avatar'] == "" or is_null($this->data['politicos'][$key][$chave][$chavedois]['avatar']) or $key == "casa")
                        $this->data['politicos'][$key][$chave][$chavedois]['thumb'] =  $this->model_tool_image->cropsize("data/no_image.jpg", 50,50);
                        else
                        {
    
                            if(!is_file(DIR_IMAGE."data/fotos/".$this->data['politicos'][$key][$chave][$chavedois]['avatar']))
                                $this->data['politicos'][$key][$chave][$chavedois]['thumb'] = $this->model_tool_image->cropsize("data/no_image.jpg", 100,100);
                            else
                            $this->data['politicos'][$key][$chave][$chavedois]['thumb'] =  $this->model_tool_image->cropsize("data/fotos/".$this->data['politicos'][$key][$chave][$chavedois]['avatar'], 100,100);
                            //$this->data['politicos'][$key][$chave][$chavedois]['filename'] =  $this->model_tool_image->resize("data/fotos/".$this->data['politicos'][$key][$chave][$chavedois]['filename'], 200);
                        }
                    }
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

    public function mediaVerbasPolitico()
    {

        $this->load->model('politico/politico');

        /* verbas */

        $results = $this->model_politico_politico->getPoliticoVerbas($this->request->get['politicoId'],null,$this->request->get['casaId']);
        $this->data['verbas'] = $results;

        /* media de verbas */

        $results = $this->model_politico_politico->getPoliticoMediaVerbas($this->request->get['casaId']);
        $this->data['mediaVerbas'] = $results;

        if(count($this->data['mediaVerbas']))
            $this->data['mediaVerbasGrafico'] = $this->retornaDadosGrafico($this->data['mediaVerbas']);
        else
            $this->data['mediaVerbasGrafico'] = array();

        if(count($this->data['verbas']))
            $this->data['verbasGrafico'] = $this->retornaDadosGrafico($this->data['verbas']);
        else
            $this->data['verbasGrafico'] = array();

        foreach($this->data['mediaVerbasGrafico'] as $key=>$value)
        {
            if(!isset($this->data['verbasGrafico'][$key]))
                $this->data['verbasGrafico'][$key] = 0;
        }

        ksort( $this->data['verbasGrafico']);

        $totalverbas = 0;

        foreach($this->data['verbas'] as $key=>$value)
        {
            $totalverbas = $totalverbas+$this->data['verbas'][$key]['verba'];
        }

        $this->data['totalVerbas'] = $totalverbas;

        print "Day,Gastos,Media\n";

        foreach($this->data['verbas'] as $key=>$value)
        {
            print '1/'.$this->data['verbas'][$key]['mes']."/".$this->data['verbas'][$key]['ano'].",".$this->data['verbas'][$key]['verba'].",".number_format($this->data['mediaVerbasGrafico'][$this->data['verbas'][$key]['ano'].'/'.$this->data['verbas'][$key]['mes']],2,".","")."\n";
        }
    }

    public function retornaDadosGrafico($dados)
    {
        $return = "";
        foreach($dados as $key=>$value)
        {

            for($i=1;12>=$i;$i++)
            {

                if($i > date('m') and $dados[$key]['ano'] == date('Y'))
                {

                }
                else
                {

                    /*
                if($i<10)
                    $a = "0";
                else
                    */
                    $a = "";

                if(!isset($return[$dados[$key]['ano'].'/'.$a.$i]))
                    $return[$dados[$key]['ano'].'/'.$a.$i] = 0;
                }
            }
        }

        foreach($dados as $key=>$value)
        {

            /*
            if($dados[$key]['mes']<10)
                $a = "0";
            else
            */
            $a = "";

            $dados[$key]['mes'] = $a.$dados[$key]['mes'];

            if(isset($return[$dados[$key]['ano'].'/'.$dados[$key]['mes']]))
            {
                $return[$dados[$key]['ano'].'/'.$dados[$key]['mes']] = $return[$dados[$key]['ano'].'/'.$dados[$key]['mes']]+$dados[$key]['verba'];
            }
            else
            {
                $return[$dados[$key]['ano'].'/'.$dados[$key]['mes']] = $dados[$key]['verba'];
            }
        }


        return $return;
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
            'separator' => false);

        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php?route=politico/politico',
            'text'      => "Políticos",
            'separator' => false);

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
        elseif($this->request->get['rank'] == "transparencia")
        {
            $this->data['titulo'] = "Transparência";
        }
        elseif($this->request->get['rank'] == "index")
        {
            $this->data['titulo'] = "Ranks";
        }

        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php?route=politico/politico/rank&rank=index',
            'text'      => "Ranks",
            'separator' => false);

        if($this->request->get['rank'] != "index")
        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php?route=politico/politico/rank&rank='.$this->request->get['rank'],
            'text'      => $this->data['titulo'],
            'separator' => false);

        $this->data['rank'] = $this->request->get['rank'];

        if( $this->data['rank'] != "index")
        $this->data['politicosRank'][0]['personagens'] = $this->model_politico_politico->getRank($this->request->get['rank']);

        $this->load->model('tool/image');

        if($this->request->get['rank'] == "transparencia")
        {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/rank-transparencia.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/politico/rank-transparencia.tpl';
            } else {
                $this->template = 'default/template/politico/rank-transparencia.tpl';
            }
        }
        else
        {

            if( $this->data['rank'] != "index")
            foreach ($this->data['politicosRank'][0]['personagens'] as $key=>$value)
            {

                if(!isset($this->data['politicosRank'][0]['personagens'][$key]['avatar']) or $this->data['politicosRank'][0]['personagens'][$key]['avatar'] == "" or is_null($this->data['politicosRank'][0]['personagens'][$key]['avatar']) or $key == "casa")
                    $this->data['politicosRank'][0]['personagens'][$key]['thumb'] =  $this->model_tool_image->cropsize("data/no_image.jpg", 100,100);
                else
                    $this->data['politicosRank'][0]['personagens'][$key]['thumb'] =  $this->model_tool_image->cropsize("data/fotos/".$this->data['politicosRank'][0]['personagens'][$key]['avatar'], 100,100);

            }


        if($this->request->get['rank'] != "index")
        {

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/rank-'.$this->request->get['rank'].'.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/politico/rank-'.$this->request->get['rank'].'.tpl';
        } else {
            $this->template = $this->config->get('config_template').'/template/politico/rank.tpl';
        }

        }else{

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/rank-index.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/politico/rank-index.tpl';
            } else {
                $this->template = 'default/template/politico/rank-index.tpl';
            }

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