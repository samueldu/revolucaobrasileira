<?php   
class ControllerConteudoAbsurdo extends Controller {
	
		public function index() { 
	
		$ano = '2010';
		$anoVerbas = '2011';
		
		//$module_data = array();
		
		$this->load->model('checkout/extension');
		
		$this->language->load('conteudo/absurdo');   
		
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
			'href'      => HTTP_SERVER . 'index.php?route=conteudo/absurdo',
			'text'      => $this->language->get('text_title'),
			'separator' => FALSE
		);
			
		$this->load->model('conteudo/absurdo');  
		
		if(isset($this->request->get['absurdo_id']))
		{		
			$results = $this->model_conteudo_absurdo->getAbsurdo($this->request->get['absurdo_id']);
			
			$this->document->breadcrumbs[] = array(
				'href'      => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=conteudo/absurdo&idCategoria='.$results[0]['idCategoria']),
				'text'      => $results[0]['nomeCategoriaAbsurdo'],
				'separator' => FALSE
			);
			
			   
			$this->document->breadcrumbs[] = array(
				'href'      => HTTP_SERVER . 'index.php?route=conteudo/absurdo',
				'text'      => $results[0]['absurdo_titulo'],
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
			$results = $this->model_conteudo_absurdo->getAbsurdos();
		}
		
		foreach($results as $key=>$value)
		{
		
			$this->data['politicos'][] = array(
			'id'=>$results[$key]['id'],
			'inicioAbsurdo'=>$results[$key]['inicioAbsurdo'],
			'like'=>$results[$key]['like'],
			'idCategoriaAbsurdo'=>$results[$key]['idCategoriaAbsurdo'],
			'link'=>$this->model_tool_seo_url->rewrite(HTTP_SERVER .'index.php?route=conteudo/absurdo&absurdo_id='.$results[$key]['id']));				
		}
		
		$this->data['politicos'] = array();
		$this->data['politicos'] = $results;		
		
		
		if(isset($this->request->get['absurdo_id']))
		{
			$this->template = $this->config->get('config_template') . '/template/absurdo/absurdo.tpl'; 
		}
		elseif(isset($this->request->get['idCategoria']))
		{
			$this->template = $this->config->get('config_template') . '/template/absurdo/listagem.tpl'; 
		}
		else
		{
			$this->template = $this->config->get('config_template') . '/template/absurdo/listagem.tpl';
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
		
		$this->load->model('checkout/extension');
		
		$this->language->load('conteudo/absurdo');   
		
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
			'href'      => HTTP_SERVER . 'index.php?route=conteudo/absurdo',
			'text'      => $this->language->get('text_title'),
			'separator' => FALSE
		);
		
		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=conteudo/absurdo/inserir',
			'text'      => 'Inserir',
			'separator' => FALSE
		);
			
		$this->load->model('conteudo/absurdo'); 
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
		
		$this->template = $this->config->get('config_template') . '/template/absurdo/inserir.tpl';

		
		$this->children = array(
			'common/column_right',
			'common/column_left',
			'common/footer',
			'common/header'
		);     
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
	
	}

}    