<?php   
class ControllerDebateDebate extends Controller {
	
		public function index() { 

		$this->load->model('checkout/extension');
		
		$this->language->load('debate/debate');
		
		$this->load->model('tool/seo_url');   
		
		$results = $this->model_checkout_extension->getExtensions('module');
		
		$this->document->title = $this->language->get('text_title');    
		
		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=common/home',
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		); 
		
		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=debate/debate',
			'text'      => $this->language->get('text_title'),
			'separator' => FALSE
		);
			
		$this->load->model('debate/debate');
		
		if(isset($this->request->get['debate_id']))
		{

            $this->data['debate_id'] = $this->request->get['debate_id'];

            /*

			//$results = $this->model_conteudo_absurdo->getAbsurdo($this->request->get['debate_id']);
			
			$this->document->breadcrumbs[] = array(
				'href'      => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=conteudo/absurdo&idCategoria='.$results[0]['idCategoria']),
				'text'      => $results[0]['nomeCategoriaAbsurdo'],
				'separator' => FALSE
			);
            */
			
			   
			$this->document->breadcrumbs[] = array(
				'href'      => HTTP_SERVER . 'index.php?route=debate/debate',
				'text'      => 'post',
				'separator' => FALSE
			);
			
		}
		elseif(isset($this->request->get['idCategoria']))
		{
			$results = $this->model_conteudo_absurdo->getAbsurdosByCategory($this->request->get['idCategoria']);
			
			$this->document->breadcrumbs[] = array(
				'href'      => HTTP_SERVER . 'index.php?route=conteudo/absurdo&idCategoria='.$results[0]['idCategoria'],
				'text'      => $results[0]['nomeCategoriaAbsurdo'],
				'separator' => FALSE
			);
			
			
		}
		else
		{
			$results = $this->model_debate_debate->getAbsurdos();
		}

		
		if(isset($this->request->get['debate_id']))
		{
			$this->template = $this->config->get('config_template') . '/template/debate/debate.tpl';
		}
		elseif(isset($this->request->get['idCategoria']))
		{
			$this->template = $this->config->get('config_template') . '/template/debate/listagem.tpl';
		}
		else
		{
			$this->template = $this->config->get('config_template') . '/template/debate/index.tpl';
		}
		
		
		$this->children = array(
			'common/column_right',
			'common/column_left',
			'common/footer',
			'common/header'
		);     
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
			
			
			
	}
	
	public function inserir(){
        
                if (!$this->customer->isLogged()) {
            $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
        }
		
		$this->load->model('checkout/extension');
		
		$this->language->load('debate/debate');
		
		$this->load->model('tool/seo_url');   
		
		$results = $this->model_checkout_extension->getExtensions('module');
		
		$this->document->title = $this->language->get('text_title');    
		
		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=common/home',
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		); 
		
		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=debate/debate',
			'text'      => $this->language->get('text_title'),
			'separator' => FALSE
		);
		
		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=debate/debate/inserir',
			'text'      => 'Inserir',
			'separator' => FALSE
		);
			
		$this->load->model('debate/debate');
		$this->load->model('catalog/category');   
		
		$this->data['categories'] = $this->model_catalog_category->getCategories(614);	
		
		if (isset($this->request->post['blog_category'])) {
			$this->data['blog_category'] = $this->request->post['blog_category'];
		
		
		} elseif (isset($this->request->get['post_id'])) {
			$this->data['blog_category'] = array();
			$categories = $this->model_extension_blog->getCategory($this->request->get['post_id']);
			foreach($categories as $category){
				$this->data['blog_category'][] = $category['category_id'];
			}
		}elseif(isset($this->session->data['user_product_id']))
		{
		$this->data['blog_category'] = $this->data['blog_category'];
		} else {
			$this->data['blog_category'] = array();
		}
		
		$this->template = $this->config->get('config_template') . '/template/debate/inserir.tpl';

		
		$this->children = array(
			'common/column_right',
			'common/column_left',
			'common/footer',
			'common/header'
		);     
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
	
	}

    public function getDebates()
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

        $this->load->model('debate/debate');

        if(!isset($_POST['partidoId']) or $_POST['partidoId'] == 0)
            $_POST['partidoId'] = null;

        if(!isset($_GET['origem']))
            $_GET['origem'] = "outra";

        if(!isset($_POST['resultsPage']) or $_POST['resultsPage'] == 0)
            $this->request->post['resultsPage'] = 25;

        if(!isset($_POST['nome']))
            $_POST['nome'] = $_GET['nome'];


        $product_total = $this->model_debate_debate->getTotalDebates($_POST['nome'],$sort,$order);

        $json['debates'] = $this->model_debate_debate->getDebates($_POST['nome'],$sort,$order,($_POST['page'] - 1) * $this->request->post['resultsPage'], $this->request->post['resultsPage']);

        /*

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
        */

            $pagination = new Pagination();
            $pagination->total = $product_total;
            $pagination->page = $_POST['page'];
            $pagination->limit = $this->request->post['resultsPage'];
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = 'javascript:mostraDebates(\'$sort\',\'{page}\')';

            $json['pagination'] = $pagination->render();

            $this->load->library('json');

            $this->response->setOutput(Json::encode($json));
    }

}    