<?php   
class ControllerAjaxAjax extends Controller {

	public function index()
    {
	
		$ano = '2010';
		$anoVerbas = '2011';
		
		//$module_data = array();
		
		$this->load->model('checkout/extension');
		
		$this->language->load('corrupcao/corrupcao');     
		
		$results = $this->model_checkout_extension->getExtensions('module');

		//$this->data['modules'] = array();
		
		$this->document->title = $this->language->get('politico');    
		
		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=common/home',
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		); 
	
		$this->load->model('corrupcao/corrupcao');  
		
		if(isset($this->request->get['corrupcao_id']))		
		$results = $this->model_corrupcao_corrupcao->getCorrupcao($this->request->get['corrupcao_id']);
		else
		
		$results = $this->model_corrupcao_corrupcao->getCorrupcao();
		
		
		$this->data['politicos'] = array();
		$this->data['politicos'] = $results;		
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/corrupcao/corrupcao.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/corrupcao/corrupcao.tpl';
		} else {
			$this->template = 'default/template/corrupcao/corrupcao.tpl';
		}
		
				$this->children = array(
			'common/column_right',
			'common/column_left',
			'common/footer',
			'common/header'
		);     
		
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  		
	}
	
	public function add()
	{
		$result = mysql_query("select * from cometchat_friends where toid = '".$_POST['toid']."' and fromid = '".$_POST['fromid']."'");

		if(mysql_num_rows($result) == 0)
		{
		mysql_query("insert into cometchat_friends (toid,fromid,confirm) values ('".$_POST['toid']."','".$_POST['fromid']."','1')");
		mysql_query("insert into cometchat_friends (toid,fromid,confirm) values ('".$_POST['fromid']."','".$_POST['toid']."','1')");
		}
	}
	
	public function like()
	{
	
		$this->load->model('ajax/ajax');   
		
		$data['id'] = $this->request->get['id'];
		$data['userId'] = $this->request->get['userId'];   
		$data['action'] = $this->request->get['action']; 
		$data['page'] = $this->request->get['page'];    
		
		$result = $this->model_ajax_ajax->like($data);
	
	}
	
	public function mark()
	{
	
		$this->load->model('ajax/ajax');   
		
		$data['pId'] = $this->request->get['pId'];
		$data['userId'] = $this->request->get['userId'];   
		$data['materia_id'] = $this->request->get['materia_id']; 
		//$data['page'] = $this->request->get['page'];    
		
		$result = $this->model_ajax_ajax->mark($data);
	
	}
	
	public function mandaMsgPolitico()
	{
	
		$this->load->model('ajax/ajax');   
	
		$data['msg'] = $this->request->get['msg'];   
		$data['userId'] = $this->request->get['userId'];   
		$data['politicoId'] = $this->request->get['politicoId']; 
		$data['email'] = $this->request->get['email']; 
		$data['politicoEmail'] = $this->request->get['politicoEmail']; 
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');                
		$mail->setTo($data['politicoEmail']);    
		$mail->setFrom($data['email']);
		$mail->setSubject('');
		$mail->setHtml(html_entity_decode($data['msg'], ENT_QUOTES, 'UTF-8'));
		//$mail->send();   

		$result = $this->model_ajax_ajax->mandaMsgPolitico($data);
	
	}

    public function getNoticias()
    {

        $this->load->model('politico/politico');

        $anoNoticias = '2012';

        $results = $this->model_politico_politico->getPoliticoMaterias($this->request->post['apelido'],$anoNoticias);
        $json['materias'] = $results;

        $this->load->library('json');

        $this->response->setOutput(Json::encode($json));
    }

	public function getPoliticos()
	{

		$json['success'] = "ok";
		$json['politicos'] = array();
		
		if (isset($this->request->post['sort'])) {
		$sort = $this->request->post['sort'];
		} else {
		$sort = 'politicos.nome';
		}

		if (isset($this->request->post['order'])) {
		$order = $this->request->post['order'];
		} else {
		$order = 'ASC';
		}
		
		$this->load->model('politico/politico');

		if(!isset($_POST['partidoId']) or $_POST['partidoId'] == 0)
		$_POST['partidoId'] = null;
		
		if(!isset($_POST['casaId']) or $_POST['casaId'] == 0)
		$_POST['casaId'] = null;
		
		if(!isset($_POST['ufId']) or $_POST['ufId'] == 0)
		$_POST['ufId'] = null;
		
		if(!isset($_POST['page']) or $_POST['page'] == 0)
		$_POST['page'] = null;

        if(!isset($_GET['origem']))
            $_GET['origem'] = "outra";

        if(!isset($_POST['resultsPage']) or $_POST['resultsPage'] == 0)
            $this->request->post['resultsPage'] = 25;

        if(!isset($_POST['nome']))
            $_POST['nome'] = $_GET['nome'];


		$product_total = $this->model_politico_politico->getTotalPoliticos($_POST['nome'],$_POST['partidoId'],$_POST['casaId'] ,$_POST['ufId'],$sort,$order);
		
		$json['politicos'] = $this->model_politico_politico->getPoliticos($_POST['nome'],$_POST['partidoId'],$_POST['casaId'] ,$_POST['ufId'],$sort,$order,($_POST['page'] - 1) * $this->request->post['resultsPage'], $this->request->post['resultsPage']);

        $this->load->model('tool/image');

        if($_GET['origem']!="header")
        {

            foreach ($json['politicos'] as $key=>$value)
            {
                    if(!isset($json['politicos'][$key]['avatar']) or $json['politicos'][$key]['avatar'] == "" or is_null($json['politicos'][$key]['avatar']))
                        $json['politicos'][$key]['thumb'] =  $this->model_tool_image->resize("data/no_image.jpg", 50,50);
                    else
                        $json['politicos'][$key]['thumb'] =  $this->model_tool_image->resize("data/fotos/".$json['politicos'][$key]['avatar'], 50,0);
            }

        }

        if($_GET['origem'] == "header")
        {
            header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
            header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
            header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header ("Pragma: no-cache"); // HTTP/1.0
            header("Content-Type: application/json");

                echo "{\"results\": [";
                $arr = array();
                for ($i=0;$i<count($json['politicos']);$i++)
                {
                    $arr[] = "{\"id\": \"".$json['politicos'][$i]['id']."\", \"value\": \"".$json['politicos'][$i]['nome']."\", \"info\": \"".$json['politicos'][$i]['apelido']."\"}";
                }
                echo implode(", ", $arr);
                echo "]}";
        }
        else
        {

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $_POST['page'];
		$pagination->limit = $this->request->post['resultsPage'];
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = 'javascript:processa(\'{page}\')';

		$json['pagination'] = $pagination->render();
		
		$this->load->library('json');
			
		$this->response->setOutput(Json::encode($json));
        }
	
	}
	
	public function gravaPost()
	{	
	
		$categorias = "";
		$tags = "";
		$data = "";
	
		$categorias = explode("blog_category%5B%5D=",$_POST['categorias']);

		foreach($categorias as $key=>$value)
		$categorias[$key] = str_replace("&amp;","",$value);
		
		array_shift($categorias);

        $categorias = $_POST['categorias'];

		$data['categorias'] = $categorias;
		
		$tags = explode(",",$_POST['tags']);
		
		foreach($tags as $key=>$value)
		$tags[$key] = str_replace("&amp;","",$value);
		
		$data['tags'] = $tags; 
		$data['texto'] = $_POST['texto'];   
		$data['titulo'] = $_POST['titulo'];   
		
		$this->load->model('ajax/ajax');

        $randname = $this->clean($_POST['titulo']);

        $path = $_POST['imagem'][0];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        file_put_contents(BASE_DIR."catalog/view/theme/revolucao/image/data/debate/".$randname.".".$ext, file_get_contents($_POST['imagem'][0]));

        exit;

		$this->model_ajax_ajax->gravaPost($data);

		$this->load->library('json');
		$this->response->setOutput(Json::encode($json));
	}

    public function clean($str)
    {

        $cleaner = array();
        $cleaner[] = array('expression'=>"/[àáäãâª]/",'replace'=>"a");
        $cleaner[] = array('expression'=>"/[èéêë]/",'replace'=>"e");
        $cleaner[] = array('expression'=>"/[ìíîï]/",'replace'=>"i");
        $cleaner[] = array('expression'=>"/[òóõôö]/",'replace'=>"o");
        $cleaner[] = array('expression'=>"/[ùúûü]/",'replace'=>"u");
        $cleaner[] = array('expression'=>"/[ñ]/",'replace'=>"n");
        $cleaner[] = array('expression'=>"/[ç]/",'replace'=>"c");

        $str = strtolower($str);

        foreach( $cleaner as $cv ) $str = preg_replace($cv['expression'],$cv['replace'],$str);


        /*
		$clean_name = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $clean_name);
        */

        $name = strtolower(preg_replace("/[^a-z0-9-]/","_",(str_replace(" ","_",trim($str)))));

        return $name;

    }

    public function verbasDivulgacao()
    {
        ?>


[{
	"id":"\/animals",
	"label":"animals",
	"childs":[{
		"id":"\/animals\/MP900149032.JPG",
		"label":"MP900149032.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"69.03 Kb"
	},
	{
		"id":"\/animals\/MP900149034.JPG",
		"label":"MP900149034.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"52.26 Kb"
	},
	{
		"id":"\/animals\/MP900178768.JPG",
		"label":"MP900178768.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"22.89 Kb"
	},
	{
		"id":"\/animals\/MP900180462.JPG",
		"label":"MP900180462.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"42.03 Kb"
	},
	{
		"id":"\/animals\/MP900227673.JPG",
		"label":"MP900227673.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"42.26 Kb"
	},
	{
		"id":"\/animals\/MP900262227.JPG",
		"label":"MP900262227.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"30.15 Kb"
	},
	{
		"id":"\/animals\/MP900262236.JPG",
		"label":"MP900262236.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"33.58 Kb"
	},
	{
		"id":"\/animals\/MP900262280.JPG",
		"label":"MP900262280.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"26.45 Kb"
	},
	{
		"id":"\/animals\/MP900262921.JPG",
		"label":"MP900262921.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"32.06 Kb"
	},
	{
		"id":"\/animals\/MP900262930.JPG",
		"label":"MP900262930.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"35.42 Kb"
	},
	{
		"id":"\/animals\/MP900316895.JPG",
		"label":"MP900316895.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"60.12 Kb"
	},
	{
		"id":"\/animals\/MP900316896.JPG",
		"label":"MP900316896.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"31.98 Kb"
	},
	{
		"id":"\/animals\/MP900448371.JPG",
		"label":"MP900448371.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"268.76 Kb"
	},
	{
		"id":"\/animals\/MP900448575.JPG",
		"label":"MP900448575.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"255.07 Kb"
	}],
	"isFolder":true,
	"open":false,
	"icon":"folder",
	"type":"File folder",
	"size":"100"
},
{
	"id":"\/food",
	"label":"food",
	"childs":[{
		"id":"\/food\/MP900175374.JPG",
		"label":"MP900175374.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"22.12 Kb"
	},
	{
		"id":"\/food\/MP900175593.JPG",
		"label":"MP900175593.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"29.49 Kb"
	},
	{
		"id":"\/food\/MP900175611.JPG",
		"label":"MP900175611.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"25.98 Kb"
	},
	{
		"id":"\/food\/MP900177942.JPG",
		"label":"MP900177942.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"40.18 Kb"
	},
	{
		"id":"\/food\/MP900177952.JPG",
		"label":"MP900177952.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"28.61 Kb"
	},
	{
		"id":"\/food\/MP900178454.JPG",
		"label":"MP900178454.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"49.28 Kb"
	},
	{
		"id":"\/food\/MP900182664.JPG",
		"label":"MP900182664.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"63.7 Kb"
	},
	{
		"id":"\/food\/MP900182747.JPG",
		"label":"MP900182747.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"37.37 Kb"
	},
	{
		"id":"\/food\/MP900182758.JPG",
		"label":"MP900182758.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"42.76 Kb"
	},
	{
		"id":"\/food\/MP900202062.JPG",
		"label":"MP900202062.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"54.89 Kb"
	},
	{
		"id":"\/food\/MP900289740.JPG",
		"label":"MP900289740.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"34.21 Kb"
	},
	{
		"id":"\/food\/MP900289776.JPG",
		"label":"MP900289776.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"36.3 Kb"
	},
	{
		"id":"\/food\/MP900289936.JPG",
		"label":"MP900289936.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"82.76 Kb"
	},
	{
		"id":"\/food\/MP900309067.JPG",
		"label":"MP900309067.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"47.87 Kb"
	},
	{
		"id":"\/food\/MP900309568.JPG",
		"label":"MP900309568.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"43.32 Kb"
	},
	{
		"id":"\/food\/MP900386418.JPG",
		"label":"MP900386418.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"30.1 Kb"
	},
	{
		"id":"\/food\/MP900399227.JPG",
		"label":"MP900399227.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"95.81 Kb"
	}],
	"isFolder":true,
	"open":false,
	"icon":"folder",
	"type":"File folder",
	"size":""
},
{
	"id":"\/nature",
	"label":"nature",
	"childs":[{
		"id":"\/nature\/MP900049297.JPG",
		"label":"MP900049297.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"76.98 Kb"
	},
	{
		"id":"\/nature\/MP900049554.JPG",
		"label":"MP900049554.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"23.87 Kb"
	},
	{
		"id":"\/nature\/MP900049644.JPG",
		"label":"MP900049644.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"36.05 Kb"
	},
	{
		"id":"\/nature\/MP900049755.JPG",
		"label":"MP900049755.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"45.37 Kb"
	},
	{
		"id":"\/nature\/MP900049995.JPG",
		"label":"MP900049995.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"40.44 Kb"
	},
	{
		"id":"\/nature\/MP900049999.JPG",
		"label":"MP900049999.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"40.37 Kb"
	},
	{
		"id":"\/nature\/MP900070796.JPG",
		"label":"MP900070796.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"46.56 Kb"
	},
	{
		"id":"\/nature\/MP900091158.JPG",
		"label":"MP900091158.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"74.96 Kb"
	},
	{
		"id":"\/nature\/MP900144999.JPG",
		"label":"MP900144999.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"80.36 Kb"
	},
	{
		"id":"\/nature\/MP900175543.JPG",
		"label":"MP900175543.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"48.65 Kb"
	},
	{
		"id":"\/nature\/MP900175548.JPG",
		"label":"MP900175548.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"45.9 Kb"
	},
	{
		"id":"\/nature\/MP900175549.JPG",
		"label":"MP900175549.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"25.12 Kb"
	},
	{
		"id":"\/nature\/MP900175550.JPG",
		"label":"MP900175550.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"34.63 Kb"
	},
	{
		"id":"\/nature\/MP900177469.JPG",
		"label":"MP900177469.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"52.91 Kb"
	},
	{
		"id":"\/nature\/MP900182351.JPG",
		"label":"MP900182351.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"42.17 Kb"
	},
	{
		"id":"\/nature\/MP900185145.JPG",
		"label":"MP900185145.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"46.38 Kb"
	},
	{
		"id":"\/nature\/MP900185146.JPG",
		"label":"MP900185146.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"32.95 Kb"
	},
	{
		"id":"\/nature\/MP900201586.JPG",
		"label":"MP900201586.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"54.32 Kb"
	},
	{
		"id":"\/nature\/MP900201626.JPG",
		"label":"MP900201626.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"26.87 Kb"
	},
	{
		"id":"\/nature\/MP900201709.JPG",
		"label":"MP900201709.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"59.74 Kb"
	},
	{
		"id":"\/nature\/MP900201711.JPG",
		"label":"MP900201711.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"34.35 Kb"
	},
	{
		"id":"\/nature\/MP900201712.JPG",
		"label":"MP900201712.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"24.89 Kb"
	},
	{
		"id":"\/nature\/MP900227683.JPG",
		"label":"MP900227683.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"26.92 Kb"
	},
	{
		"id":"\/nature\/MP900341564.JPG",
		"label":"MP900341564.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"38 Kb"
	},
	{
		"id":"\/nature\/MP900442490.JPG",
		"label":"MP900442490.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"249.99 Kb"
	},
	{
		"id":"\/nature\/MP900448282.JPG",
		"label":"MP900448282.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"229.91 Kb"
	},
	{
		"id":"\/nature\/MP900448619.JPG",
		"label":"MP900448619.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"242.54 Kb"
	},
	{
		"id":"\/nature\/MP900448740.JPG",
		"label":"MP900448740.JPG",
		"childs":[],
		"isFolder":false,
		"open":false,
		"icon":"file",
		"type":"JPEG image",
		"size":"458.91 Kb"
	}],
	"isFolder":true,
	"open":false,
	"icon":"folder",
	"type":"File folder",
	"size":""
}]

<?


    }

    public function mediaVerbas()
    {

        $this->load->model('politico/politico');

        $results = $this->model_politico_politico->mediaVerbas();

        $csv = "Day,";

        $arrayNomes = array(
            "Gastos com escritório"=>"",
            "Combustíveis e locação de carros e barcos"=>"",
            "Consultorias"=>"",
            "Divulgação de atividade parlamentar"=>"",
            "Segurança"=>"",
            "Passagens aéreas e fretamentos de aeronaves"=>"",
            "Alimentação e hospedagem"=>"",
            "Locomoção alimentação e hospedagem"=>"",
            "Assinatura de publicações"=>"",
            "Serviços postais"=>"",
            "Telefonia"=>"");

        ksort($arrayNomes);

        foreach($arrayNomes as $key=>$value)
        {
            $csv .= $key.",";
        }

        $csv = rtrim($csv,',');

        $csv .= "\n";

        $retorno = array();

        foreach($results as $key=>$value)
        {

        switch ($results[$key]['descricao']) {
            case "Aluguel de imóveis para escritório político, compreendendo despesas concernentes a eles.":
            case "Aquisição de material de consumo para uso no escritório político, inclusive aquisição ou locação de software, despesas postais, aquisição de publicações, locação de móveis e de equipamentos.":
            case "AQUISIÇÃO DE MATERIAL DE ESCRITÓRIO.":
            case "AQUISIÇÃO OU LOC. DE SOFTWARE; SERV. POSTAIS; ASS.":
            case "MANUTENÇÃO DE ESCRITÓRIO DE APOIO À ATIVIDADE PARLAMENTAR":
            $results[$key]['descricao'] = "Gastos com escritório";
                break;
            case "COMBUSTÍVEIS E LUBRIFICANTES.":
            case "LOCAÇÃO DE VEÍCULOS AUTOMOTORES OU FRETAMENTO DE EMBARCAÇÕES":
            $results[$key]['descricao'] =  "Combustíveis e locação de carros e barcos";
                break;
            case "CONSULTORIAS, PESQUISAS E TRABALHOS TÉCNICOS.":
            case "Contratação de consultorias, assessorias, pesquisas, trabalhos técnicos e outros serviços de apoio ao exercício do mandato parlamentar":
                $results[$key]['descricao'] = "Consultorias";
                break;
            case "Divulgação da atividade parlamentar":
            case "DIVULGAÇÃO DA ATIVIDADE PARLAMENTAR.":
                $results[$key]['descricao'] = "Divulgação de atividade parlamentar";
                break;
            case "SERVIÇO DE SEGURANÇA PRESTADO POR EMPRESA ESPECIALIZADA.":
            case "Serviços de Segurança Privada":
                $results[$key]['descricao'] = "Segurança";
                break;
            case "PASSAGENS AÉREAS E FRETAMENTO DE AERONAVES":
            case "Passagens aéreas, aquáticas e terrestres nacionais":
            case "PASSAGENS AÉREAS E FRETAMENTO DE AERONAVES":
            case "EMISSãO BILHETE AéREO":
            case "MANUTENÇÃO DE ESCRITÓRIO DE APOIO À ATIVIDADE PARLAMENTAR":
                $results[$key]['descricao'] = "Passagens aéreas e fretamentos de aeronaves";
                break;

            case "HOSPEDAGEM ,EXCETO DO PARLAMENTAR NO DISTRITO FEDERAL.":
            case "FORNECIMENTO DE ALIMENTAÇÃO DO PARLAMENTAR":
                $results[$key]['descricao'] = "Alimentação e hospedagem";
                break;
            case "LOCOMOÇÃO, ALIMENTAÇÃO E  HOSPEDAGEM":
            case "Locomoção, hospedagem, alimentação, combustíveis e lubrificantes":
                $results[$key]['descricao'] = "Locomoção alimentação e hospedagem";
                break;
            case "ASSINATURA DE PUBLICAÇÕES":
                $results[$key]['descricao'] = "Assinatura de publicações";
                break;
            case "SERVIÇOS POSTAIS":
                $results[$key]['descricao'] = "Serviços postais";
                break;
            case "TELEFONIA":
                $results[$key]['descricao'] = "Telefonia";
                break;
            default:
                print "nao fui categorizado:".$results[$key]['descricao'];
                exit;
            }

            if(!isset($retorno[$results[$key]['ano']][$results[$key]['descricao']]))
            $retorno[$results[$key]['ano']][$results[$key]['descricao']] = $results[$key]['total'];
            else
            $retorno[$results[$key]['ano']][$results[$key]['descricao']] = $results[$key]['total']+$retorno[$results[$key]['ano']][$results[$key]['descricao']];
        }

        foreach($retorno as $key=>$value)
        {
            foreach($arrayNomes as $chave=>$valor)
            {
                if(!isset($retorno[$key][$chave]))
                    $retorno[$key][$chave] = 0;
            }
        }



        foreach($retorno as $key=>$value)
        {
            ksort($retorno[$key]);

            $aux = substr($key, -2);

            $csv .= "1/1/".$aux.",";

            foreach($retorno[$key] as $keyx=>$valuex)
            {
                $csv .= $valuex.",";
            }

            $csv = rtrim($csv,',');

            $csv .= "\n";
        }

       print $csv;
        /*
        $retorno = array();

        foreach($results as $key=>$value)
        {
            foreach($results as $keyx=>$valuex)
            {
                if(($results[$key]['ano'] == $results[$keyx]['ano']) and ($results[$key]['descricao'] == $results[$keyx]['descricao']) and ($results[$key]['total'] != $results[$keyx]['total']) and ($key != $keyx))
                {
                    $retorno[$key]['total'] = $results[$keyx]['total']+$results[$key]['total'];
                    $retorno[$key]['descricao'] = $results[$keyx]['descricao'];
                }
            }
        }

        print_R($retorno);
        */

    }

    public function confirm()
    {

        $this->load->model('account/wall');

        $results = $this->model_account_wall->makeFriends($this->request->post['toid'],$this->request->post['fromid']);
    }

    public function getImages()
    {
        $foto = "";

        // download pattern you can modify it
        $pattern='/http[a-z.\/\/-a-z_]{2,129}[a-z0-9_-]{1,90}.(gif|png|jpg)/';

        //getting url addresses
        //$gurl = "http://www.google.com/search?q=".rawurlencode($foldername)."&hl=pt-PT&gbv=2&tbm=isch&prmd=ivns&ei=GWPxTvPKNM2srAfKyPnPDw&start=".$i."&sa=X&biw=1920&bih=940&cp=14&um=1&tab=wi";

        //    $gurl = "http://www.google.com/search?start=0&num=$to&hl=pt-PT&site=imghp&tbm=isch&source=hp&biw=1920&bih=911&q=".rawurlencode(str_replace(" ","+",$foldername." politico"))."&oq=politico&gs_l=img.12..0j0i24.1209.1209.0.2141.1.1.0.0.0.0.225.225.2-1.1.0...0.0...1ac.1.Pe28z3jX99Q#q=".rawurlencode(str_replace(" ","+",$foldername))."=10&hl=pt-PT&site=imghp&tbs=isz:m&tbm=isch&source=lnt&sa=X&ei=F_2GUPqOLsfSqgGco4DIBw&ved=0CCAQpwUoAg&bav=on.2,or.r_gc.r_pw.r_cp.r_qf.&fp=91c6607967313ae1&bpcl=35466521&biw=1920&bih=911";

        //$gurl = "http://www.google.com/search?q=google+images&oe=utf-8&aq=t&rls=org.mozilla:en-US:official&client=firefox-a&um=1&ie=UTF-8&hl=pt-PT&tbm=isch&source=og&sa=N&tab=wi&ei=8NBXUInCFIHq0gGy4ICgCQ&biw=1920&bih=523&sei=8tBXULeNN8br0gG9w4H4Cg#q=".rawurlencode($foldername)."&um=1&hl=pt-PT&client=firefox-a&rls=org.mozilla:en-US:official&tbs=islt:vga,isz:m&tbm=isch&source=lnt&sa=X&ei=MNFXUL-qBufJ0QGk0oHABg&ved=0CCUQpwUoAg&bav=on.2,or.r_gc.r_pw.r_cp.r_qf.&fp=b623f8ce786712f0&biw=1920&bih=940";
        //$gurl = "https://www.google.com/search?hl=pt-PT&tok=Y4di59jJott3wP-UeIaD3w&cp=14&gs_id=3a&xhr=t&q=walter+feldman&bav=on.2,or.r_gc.r_pw.r_cp.r_qf.&biw=1920&bih=940&um=1&ie=UTF-8&tbm=isch&source=og&sa=N&tab=wi&ei=9NFXUP3CF6rC0QHJ8oGgBA#q=walter+feldman&um=1&hl=pt-PT&tbm=isch&source=lnt&tbs=isz:m&sa=X&ei=9tFXUJmhJpL0qQHN3YHYDw&ved=0CCcQpwUoAg&bav=on.2,or.r_gc.r_pw.r_cp.r_qf.&fp=219242a61ec58493&biw=1920&bih=940";

        //$gurl = "http://www.google.com/search?q=".rawurlencode(str_replace(" ","+",$this->request->get['titulo']))."&um=1&hl=pt-PT&client=firefox-a&sa=X&rls=org.mozilla:en-US:official&biw=1920&bih=941&tbm=isch&tbas=0&q=".rawurlencode(str_replace(" ","+",$this->request->get['titulo']))."&um=1&hl=pt-PT&client=firefox-a&rls=org.mozilla:en-US:official&tbs=isz:m,ic:color,itp:face&tbm=isch&source=lnt&sa=X&ei=PGGqUN2mLszI0AHF2ICgBQ&ved=0CDcQpwUoAQ&bav=on.2,or.r_gc.r_pw.r_qf.&fp=cf4d690c99219a5&bpcl=38625945&biw=1920&bih=973";

        $gurl = "https://www.google.com.br/search?q=".rawurlencode(str_replace(" ","+",$this->request->get['titulo']))."&client=firefox-a&hs=oIT&sa=X&rls=org.mozilla:pt-BR:official&noj=1&biw=1472&bih=725&tbm=isch&tbas=0";

        $pg = file_get_contents("$gurl");
        preg_match_all($pattern, $pg, $returnArray);
        $matches = $returnArray[0];
        $count = count($matches);
        foreach( $matches as $key){
            $key = str_replace("http://www.google.com.br/imgres?imgurl=","",$key);
            $randname = "foto_".rand(9,999999999);
            $foto .= '<div class="news-list-item"><img id="'.$randname.'" onclick="javascript:seleciona(\''.$randname.'\');" class="image-selector" src="'.$key.'" /></div>';
        }

        $this->load->library('json');

        $json['success'] = 'ok';

        $json['fotos'] = $foto;

        $this->response->setOutput(Json::encode($json));

    }
}
    ?>