<?php   
class ControllerConteudoCorrupcao extends Controller {
	public function index() { 
	
		$ano = date('Y');

		$this->load->model('checkout/extension');
		$this->load->model('conteudo/corrupcao');  
		
		$this->language->load('conteudo/corrupcao');     
		
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
			'href'      => HTTP_SERVER . 'index.php?route=conteudo/corrupcao',
			'text'      => 'Corrupção no Brasil',
			'separator' => false
		);


		$this->load->model('conteudo/corrupcao'); 
		
		if(isset($this->request->get['corrupcao_id']))
		{

            $this->document->breadcrumbs[] = array(
                'href'      => HTTP_SERVER . 'index.php?route=conteudo/corrupcao/lista',
                'text'      => "Casos de corrupção",
                'separator' => false
            );

			$results = $this->model_conteudo_corrupcao->getCorrupcao($this->request->get['corrupcao_id']);

            //print_R($results);

            $this->load->model('tool/image');

            foreach ($results[0]['personagens'] as $key=>$value)
            {

                if(!isset($results[0]['personagens'][$key]['avatar']) or $results[0]['personagens'][$key]['avatar'] == "" or is_null($results[0]['personagens'][$key]['avatar']))
                    $results[0]['personagens'][$key]['thumb'] =  $this->model_tool_image->cropsize("data/no_image.jpg", 100,100);
                else
                    $results[0]['personagens'][$key]['thumb'] =  $this->model_tool_image->cropsize("data/fotos/".$results[0]['personagens'][$key]['avatar'], 100,100);
            }

            $this->data['casos_semelhantes'] = $this->model_conteudo_corrupcao->getCorrupcaoSemelhantes($this->request->get['corrupcao_id']);

            foreach($this->data['casos_semelhantes'] as $key=>$value)
            {
                $this->data['casos_semelhantes'][$key]['descricao'] = $this->resumo($this->data['casos_semelhantes'][$key]['descricao'],150);
            }

						$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=conteudo/corrupcao?corrupcao_id'.$this->request->get['corrupcao_id'],
			'text'      => $results[0]['titulo'],
			'separator' => false
			 );        
			 
			 $this->template = $this->config->get('config_template') . '/template/corrupcao/corrupcao.tpl';
			  
		}
		else
		{

            if(!isset($this->request->get['ordem']))
            $this->request->get['ordem'] = "recentes";

			$results = $this->model_conteudo_corrupcao->getCorrupcaoLandPage(null,$this->request->get['ordem']);

            $this->data['politicos'] = array();

            $this->data['casos_semelhantes'] = $this->model_conteudo_corrupcao->getCorrupcaoSemelhantes(null,3);

            $this->data['frases'] = $this->model_conteudo_corrupcao->getRankFrases();

            $this->data['politicosRank'][0]['personagens'] = $this->model_conteudo_corrupcao->getRankCorrupcao(null);

            //debug($this->data['politicosRank'][0]['personagens']);

			$this->template = $this->config->get('config_template') . '/template/corrupcao/index.tpl';

            $this->load->model('tool/image');

            foreach ($this->data['politicosRank'][0]['personagens'] as $key=>$value)
            {

                if(!isset($this->data['politicosRank'][0]['personagens'][$key]['avatar']) or $this->data['politicosRank'][0]['personagens'][$key]['avatar'] == "" or is_null($this->data['politicosRank'][0]['personagens'][$key]['avatar']))
                    $this->data['politicosRank'][0]['personagens'][$key]['thumb'] =  $this->model_tool_image->cropsize("data/no_image.jpg", 100,100);
                else
                    $this->data['politicosRank'][0]['personagens'][$key]['thumb'] =  $this->model_tool_image->cropsize("data/fotos/".$this->data['politicosRank'][0]['personagens'][$key]['avatar'], 100,100);
            }
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

    public function getPoliticoCorrupcao()
    {
        $this->load->model('conteudo/corrupcao');

        $results = $this->model_conteudo_corrupcao->getCorrupcao(null);

    }

    public function lista()
    {

        if(!isset($this->request->get['ordem']))
            $this->request->get['ordem'] = "recentes";

        $ano = date('Y');

        $this->load->model('checkout/extension');
        $this->load->model('conteudo/corrupcao');

        $this->language->load('conteudo/corrupcao');

        $results = $this->model_checkout_extension->getExtensions('module');

        $this->data['modules'] = array();

        $this->document->title = $this->language->get('politico');

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php?route=common/home',
            'text'      => $this->language->get('text_home'),
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php?route=conteudo/corrupcao',
            'text'      => "Corrupção no Brasil",
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php?route=conteudo/corrupcao/lista',
            'text'      => "Casos de corrupção",
            'separator' => false
        );

        $this->load->model('conteudo/corrupcao');

        $results = $this->model_conteudo_corrupcao->getCorrupcao(null,$this->request->get['ordem']);
        $this->template = $this->config->get('config_template') . '/template/corrupcao/listagem.tpl';

        $this->data['politicos'] = array();
        $this->data['politicos'] = $results;

        $this->data['governos'] = $this->model_conteudo_corrupcao->getGovernos();

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