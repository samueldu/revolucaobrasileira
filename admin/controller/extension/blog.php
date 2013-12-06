<?php 
class ControllerExtensionBlog extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('extension/blog');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('extension/blog');
		 
		$this->getList();
	}

	public function post() {
		$this->load->language('extension/blog');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('extension/blog');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$news_image = null;
			$category = null;
			$url = null;
			if(isset($this->request->post['news_image'])){
				$news_image = $this->request->post['news_image'];
				unset($this->request->post['news_image']);
			}

			if(isset($this->request->post['blog_category'])){
				$category = $this->request->post['blog_category'];
				unset($this->request->post['blog_category']);
			}
			
			if(isset($this->request->post['url'])){
				$url = $this->request->post['url'];
				unset($this->request->post['url']);
			}
			
			$data = array();

			if(!isset($this->request->post['video_destaque'])){
				$data['video_destaque'] = 0;
			}
			
			if(!isset($this->request->post['repasse'])){
				$data['repasse'] = 0;
			}

			if(!isset($this->request->post['pontos'])){
				$data['pontos'] = 0;
			}
			
			if(isset($this->session->data['user_id_product']))
			$data['author_id'] = $_SESSION['user_id'];
			else
			$data['author_id'] = $_SESSION['user_id'];      

			$post_id = $this->model_extension_blog->addPost(array_merge($this->request->post, $data));
			$this->model_extension_blog->addImage($post_id, $news_image);
			$this->model_extension_blog->addCategory($post_id, $category);
			$this->model_extension_blog->addUrl($post_id,$url);
			
			
			$this->session->data['success'] = $this->language->get('text_post_added');
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/blog&token=' . $this->session->data['token']); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('extension/blog');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('extension/blog');
		
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->load->model('module/deadcow_seo');
			$this->model_module_deadcow_seo->generateBlog($this->request->get['post_id'],$this->request->post['subject']);
			
			if(isset($this->request->post['news_image'])){
				$news_image = $this->request->post['news_image'];
				unset($this->request->post['news_image']);
				$this->model_extension_blog->addImage($this->request->get['post_id'], $news_image);
			}

			if(isset($this->request->post['blog_category'])){
				$category = $this->request->post['blog_category'];
				unset($this->request->post['blog_category']);
			}else{
				$category = array();
			}
			$this->model_extension_blog->addCategory($this->request->get['post_id'], $category);
			
			if(isset($this->request->post['url'])){
				$url = $this->request->post['url'];
				unset($this->request->post['url']);
				$this->model_extension_blog->addUrl($this->request->get['post_id'],$url);
			}
			
			$data = array();
			
			if(!isset($this->request->post['video_destaque'])){
				$data['video_destaque'] = 0;
			}
			if(!isset($this->request->post['pontos'])){
				$data['pontos'] = 0;
			}
			if(!isset($this->request->post['repasse'])){
				$data['repasse'] = 0;
			}
			
			

			$this->model_extension_blog->editPost($this->request->get['post_id'], array_merge($this->request->post, $data));
			
			$this->session->data['success'] = $this->language->get('text_post_updated');
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/blog&token=' . $this->session->data['token']);
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('extension/blog');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('extension/blog');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			$this->model_extension_blog->deleteCategories($this->request->post['selected']);
			
			$this->session->data['success'] = $this->language->get('text_posts_deleted');

			$this->redirect(HTTPS_SERVER.'index.php?route=extension/blog&token=' . $this->session->data['token']);
		}

		$this->getList();
	}

	private function getList() {
		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		);

		$this->document->breadcrumbs[] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=extension/blog&token=' . $this->session->data['token'],
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);
		
		$this->data['add'] = HTTPS_SERVER . 'index.php?route=extension/blog/post&token=' . $this->session->data['token'];
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=extension/blog/delete&token=' . $this->session->data['token'];
		
		
		$this->data['posts'] = array();
		
		$results = $this->model_extension_blog->getPosts();

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=extension/blog/update&post_id=' . $result['post_id'] . '&token=' . $this->session->data['token']
				
			);
					
			$this->data['posts'][] = array(
				'post_id' => $result['post_id'],
				'subject'        => $result['subject'],
				'status'        => ucfirst($result['status']),
				'date_posted'  => $result['date_posted'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['post_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_subject'] = $this->language->get('column_subject');
		$this->data['column_date_posted'] = $this->language->get('column_date_posted');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_add'] = $this->language->get('button_add');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['confirm_delete'] = $this->language->get('confirm_delete');
		$this->data['blog_published'] = $this->language->get('blog_published');
		$this->data['blog_draft'] = $this->language->get('blog_draft');
		$this->data['footblog'] = $this->language->get('footblog');
 
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->template = 'extension/blog_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getForm() {

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_franquia'] = $this->language->get('entry_franquia');         		
		$this->data['entry_url'] = $this->language->get('entry_url');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_subject'] = $this->language->get('entry_subject');
		$this->data['entry_content'] = $this->language->get('entry_content');
		$this->data['entry_resumo'] = $this->language->get('entry_resumo');
		$this->data['entry_youtube'] = $this->language->get('entry_youtube');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_video_destaque'] = $this->language->get('entry_video_destaque');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['blog_published'] = $this->language->get('blog_published');
		$this->data['blog_draft'] = $this->language->get('blog_draft');
		$this->data['footblog'] = $this->language->get('footblog');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_add_image'] = $this->language->get('button_add_image');

		$this->data['author_name'] = $this->language->get('author_name');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_link'] = $this->language->get('tab_link');
		
		if(isset($this->session->data['user_id_product']))
		{
		$this->data['author'] = $this->user->getUserName();
		$this->data['user_id_product'] = $this->session->data['user_id_product'];
		}
		else                  
		{
		$this->data['author'] =$this->model_extension_blog->getAuthor($_SESSION['user_id']);
		}
		
		

		$this->data['error_warning'] = '';
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		}
	
		$this->data['error_subject'] = '';
		if (isset($this->error['subject'])) {
			$this->data['error_subject'] = $this->error['subject'];
		}
	
		$this->data['error_content'] = '';
		if (isset($this->error['content'])) {
			$this->data['error_content'] = $this->error['content'];
		}
		
		$this->data['error_resumo'] = '';
		if (isset($this->error['resumo'])) {
			$this->data['error_resumo'] = $this->error['resumo'];
		}

		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		);

		$this->document->breadcrumbs[] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token'],
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);
		
		if (!isset($this->request->get['post_id'])) {
			$this->data['status'] = 'published';
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=extension/blog/post&token=' . $this->session->data['token'];
		} else {
			$thisPost = $this->model_extension_blog->getPost($this->request->get['post_id']);
			$this->data = array_merge($this->data, $thisPost);
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=extension/blog/update&post_id=' . $this->request->get['post_id'] . '&token=' . $this->session->data['token'];
		}
		
		$this->load->model('tool/image');  
		
		$this->data['news_images'] = array();
		
		if (isset($this->request->get['post_id'])) {
			$results = $this->model_extension_blog->getImages($this->request->get['post_id']);
			foreach ($results as $result) {
				if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
					$this->data['news_images'][] = array(
						'preview' => $this->model_tool_image->resize($result['image'], 100, 100),
						'file'    => $result['image']
					);
				} else {
					$this->data['news_images'][] = array(
						'preview' => $this->model_tool_image->resize('no_image.jpg', 100, 100),
						'file'    => $result['image']
					);
				}
			}
			//debug($this->data['news_images']);exit;
		}
		
		$this->data['url'] = '';
		$this->load->model('extension/blog');
		if (isset($this->request->get['url'])) {
			$this->data['url'] = $this->request->get['url']; 
		}else{
			if(isset($this->request->get['post_id'])){
				$url = $this->model_extension_blog->getUrl($this->request->get['post_id']);
				if(!is_null($url)){
					$this->data['url'] = $url;
				}
			}
		}

		$this->load->model('catalog/category');
				
				
		if(!isset($this->session->data['user_id_product'])) 
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		else
		$this->data['categories'] = $this->model_catalog_category->getCategoriesByProduct(0,$this->session->data['user_id_product']);
		
		
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

		if (isset($this->request->post['subject'])) {
			$this->data['subject'] = $this->request->post['subject'];
		}
		
		if (isset($this->request->post['content'])) {
			$this->data['content'] = $this->request->post['content'];
		}
		
		if (isset($this->request->post['resumo'])) {
			$this->data['content'] = $this->request->post['resumo'];
		}
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		}
		
		$this->load->model('tool/image');
		$this->data['token'] = $this->session->data['token'];
		$this->data['image_row'] = Array();
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/blog&token=' . $this->session->data['token'];

		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		

		if (isset($this->request->post['blog_description'])) {
			$this->data['blog_description'] = $this->request->post['blog_description'];
		} elseif(isset($this->request->get['post_id'])) {
			$this->data['blog_description'] = $this->model_extension_blog->getBlogDescriptions($this->request->get['post_id']);
		} 
		else
		{
			$this->data['blog_description'] = array();
		}
		

		$this->template = 'extension/blog_post.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		if (isset($this->request->post['product_id'])) {
			$this->data['product_id'] = $this->request->post['product_id'];
		}
		
		if (isset($this->data->session['user_product_id'])) {
			$this->data['user_product_id'] = $this->data->session['user_product_id'];   
		}
		else
		$this->data['user_product_id'] = "";
		
		$this->load->model('catalog/product');   
		
		$results = $this->model_catalog_product->getProducts();
		
		$this->data['products'][] = array(
				'product_id' => 0,
				'name'       => 'Nenhuma',
				'model'      => '',
				'image'      => '',
				'quantity'   => '',
				'status'     => '',
				'selected'   => isset($this->request->post['selected']) && in_array(0, $this->request->post['selected']),
			);
						
		foreach ($results as $result) {
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
			
			  $this->data['products'][] = array(
				'product_id' => $result['product_id'],
				'name'       => $result['name'],
				'model'      => $result['model'],
				'image'      => $image,
				'quantity'   => $result['quantity'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']),
			);
		}

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		
		if (!$this->user->hasPermission('modify', 'extension/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
   
		if (empty($this->request->post['subject'])) {
			$this->error['subject'] = $this->language->get('error_subject');
		}
		
		if (empty($this->request->post['content'])) {
			$this->error['content'] = $this->language->get('error_content');
		}
		
		if (empty($this->request->post['resumo'])) {
			$this->error['resumo'] = $this->language->get('error_resumo');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return TRUE; 
		} else {
			return FALSE;
		}
	}
}
?>