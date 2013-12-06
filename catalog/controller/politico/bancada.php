<?php   
class ControllerPoliticoBancada extends Controller {

    public function index()
    {
        $this->language->load('politico/bancada');

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
            'separator' => FALSE
        );

        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php?route=politico/bancada',
            'text'      => $this->language->get('bancadas'),
            'separator' => FALSE
        );


        if(isset($this->request->get['idGrupo']))
        {

            $this->document->breadcrumbs[] = array(
                'href'      => HTTP_SERVER . 'index.php?route=politico/bancada/?idGrupo='.$this->request->get['idGrupo'],
                'text'      => $this->language->get('titulo_'.$this->request->get['idGrupo']),
                'separator' => FALSE
            );


        $this->data['titulo'] = $this->language->get('titulo_'.$this->request->get['idGrupo']);

        $this->load->model('politico/politico');

        $this->data['politicosRank'][0]['personagens'] = $this->model_politico_politico->getPoliticos(null,null,null,null,'politicos.apelido','ASC', 0, 100, $this->request->get['idGrupo']);

        $this->data['estatisticas']['numero'] = count($this->data['politicosRank'][0]['personagens']);

        $numProc = 0;
        $numProcZero = 0;

            if($this->request->get['idGrupo'] == 3)
            {
                $this->data['estatisticas']['verbaDivulgacao'] = $this->model_politico_politico->getMediaVerbasDivulgacao();;

                foreach($this->data['politicosRank'][0]['personagens'] as $key=>$value)
                {

                    $results = $this->model_politico_politico->getPoliticoProcessos($this->data['politicosRank'][0]['personagens'][$key]['politicoId']);
                    if(count($results) == 0)
                    {
                        $numProcZero = $numProcZero + 1;
                        $this->data['politicosRank'][0]['personagens'][$key]['processos'] = 0;
                    }
                    else
                    {
                        $this->data['politicosRank'][0]['personagens'][$key]['processos'] = $results;
                    }
                    $numProc = $numProc + count($results);
                }

                $this->data['estatisticas']['numProc'] = $numProc;
                $this->data['estatisticas']['numProcZero'] = $numProcZero;
                $this->data['estatisticas']['numPorcentagem'] = number_format(((($this->data['estatisticas']['numero']-$numProcZero)*100/$this->data['estatisticas']['numero'])),2,",",".")."%";
                $this->data['estatisticas']['numProcTotal'] = 564;
                $this->data['estatisticas']['numPoliticosTotal'] = 2468;
                $this->data['estatisticas']['numPorcentagemTotal'] = number_format(((($this->data['estatisticas']['numProcTotal'])*100/$this->data['estatisticas']['numPoliticosTotal'])),2,",",".")."%";

                $this->load->model('tool/image');

                $this->data['fotos'] = $this->model_politico_politico->getFotos($this->data['politicosRank'][0]['personagens'][0]['politicoId']);

                foreach ($this->data['fotos'] as $key=>$value)
                {
                    $this->data['fotos'][$key]['thumb'] =  $this->model_tool_image->resize('data/fotos/'.$this->data['fotos'][$key]['filename'], 263,0);
                }

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/bancada-tv.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/politico/bancada-tv.tpl';
                } else {
                    $this->template = 'default/template/politico/bancada-tv.tpl';
                }

            }
            elseif($this->request->get['idGrupo'] == 1)
            {

        $this->data['estatisticas']['igrejas'] = array();

        foreach($this->data['politicosRank'][0]['personagens'] as $key=>$value)
        {

            if(!isset($this->data['estatisticas']['igrejas'][$this->data['politicosRank'][0]['personagens'][$key]['desc']]))
            $this->data['estatisticas']['igrejas'][$this->data['politicosRank'][0]['personagens'][$key]['desc']] = 1;
            else
            $this->data['estatisticas']['igrejas'][$this->data['politicosRank'][0]['personagens'][$key]['desc']] = $this->data['estatisticas']['igrejas'][$this->data['politicosRank'][0]['personagens'][$key]['desc']]+1;

            $results = $this->model_politico_politico->getPoliticoProcessos($this->data['politicosRank'][0]['personagens'][$key]['politicoId']);
            if(count($results) == 0)
            {
                $numProcZero = $numProcZero + 1;
                $this->data['politicosRank'][0]['personagens'][$key]['processos'] = 0;
            }
            else
            {
                $this->data['politicosRank'][0]['personagens'][$key]['processos'] = $results;
            }
            $numProc = $numProc + count($results);
        }

        $this->data['estatisticas']['numProc'] = $numProc;
        $this->data['estatisticas']['numProcZero'] = $numProcZero;
        $this->data['estatisticas']['numPorcentagem'] = number_format(((($this->data['estatisticas']['numero']-$numProcZero)*100/$this->data['estatisticas']['numero'])),2,",",".")."%";
        $this->data['estatisticas']['numProcTotal'] = 564;
        $this->data['estatisticas']['numPoliticosTotal'] = 2468;
        $this->data['estatisticas']['numPorcentagemTotal'] = number_format(((($this->data['estatisticas']['numProcTotal'])*100/$this->data['estatisticas']['numPoliticosTotal'])),2,",",".")."%";

        $this->load->model('tool/image');

        $this->data['fotos'] = $this->model_politico_politico->getFotos($this->data['politicosRank'][0]['personagens'][0]['politicoId']);

        foreach ($this->data['fotos'] as $key=>$value)
        {
            $this->data['fotos'][$key]['thumb'] =  $this->model_tool_image->resize('data/fotos/'.$this->data['fotos'][$key]['filename'], 263,0);
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/bancada-evangelica.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/politico/bancada-evangelica.tpl';
        } else {
            $this->template = 'default/template/politico/bancada-evangelica.tpl';
        }

        }
        elseif($this->request->get['idGrupo'] == 2)
            {

                $this->data['estatisticas']['igrejas'] = array();

                foreach($this->data['politicosRank'][0]['personagens'] as $key=>$value)
                {

                    if(!isset($this->data['estatisticas']['igrejas'][$this->data['politicosRank'][0]['personagens'][$key]['desc']]))
                        $this->data['estatisticas']['igrejas'][$this->data['politicosRank'][0]['personagens'][$key]['desc']] = 1;
                    else
                        $this->data['estatisticas']['igrejas'][$this->data['politicosRank'][0]['personagens'][$key]['desc']] = $this->data['estatisticas']['igrejas'][$this->data['politicosRank'][0]['personagens'][$key]['desc']]+1;

                    $results = $this->model_politico_politico->getPoliticoProcessos($this->data['politicosRank'][0]['personagens'][$key]['politicoId']);
                    if(count($results) == 0)
                    {
                        $numProcZero = $numProcZero + 1;
                        $this->data['politicosRank'][0]['personagens'][$key]['processos'] = 0;
                    }
                    else
                    {
                        $this->data['politicosRank'][0]['personagens'][$key]['processos'] = $results;
                    }
                    $numProc = $numProc + count($results);
                }

                $this->data['estatisticas']['numProc'] = $numProc;
                $this->data['estatisticas']['numProcZero'] = $numProcZero;
                $this->data['estatisticas']['numPorcentagem'] = number_format(((($this->data['estatisticas']['numero']-$numProcZero)*100/$this->data['estatisticas']['numero'])),2,",",".")."%";
                $this->data['estatisticas']['numProcTotal'] = 564;
                $this->data['estatisticas']['numPoliticosTotal'] = 2468;
                $this->data['estatisticas']['numPorcentagemTotal'] = number_format(((($this->data['estatisticas']['numProcTotal'])*100/$this->data['estatisticas']['numPoliticosTotal'])),2,",",".")."%";

                $this->load->model('tool/image');

                $this->data['fotos'] = $this->model_politico_politico->getFotos($this->data['politicosRank'][0]['personagens'][0]['politicoId']);

                foreach ($this->data['fotos'] as $key=>$value)
                {
                    $this->data['fotos'][$key]['thumb'] =  $this->model_tool_image->resize('data/fotos/'.$this->data['fotos'][$key]['filename'], 263,0);
                }

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/bancada-ruralista.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/politico/bancada-ruralista.tpl';
                } else {
                    $this->template = 'default/template/politico/bancada-ruralista.tpl';
                }

            }
        }
        else
        {

            $this->load->model('politico/politico');

            $this->data['bancada'] = $this->model_politico_politico->getBancada();

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/bancada-index.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/politico/bancada-index.tpl';
            } else {
                $this->template = 'default/template/politico/bancada-index.tpl';
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
            'separator' => FALSE);

        $this->document->breadcrumbs  = array(
            'href'      => HTTP_SERVER . 'index.php?route=politico/politico',
            'tetx' => "Político",
            'separator' => FALSE);

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
            'separator' => false);

        $this->document->breadcrumbs[] = array(
            'href'      => HTTP_SERVER . 'index.php?route=politico/politico/rank&rank='.$this->request->get['rank'],
            'text'      => $this->data['titulo'],
            'separator' => false);

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

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/politico/rank.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/politico/rank.tpl';
        } else {
            $this->template = 'default/template/politico/rank.tpl';
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