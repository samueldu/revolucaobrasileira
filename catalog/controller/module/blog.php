<?php  
#############################################################################
#  Module Blog & News for Opencart 1.4.x From Team SiamOpencart.com		  							   #
#  เว็บผู้พัฒนา www.siamopencart.com ,www.thaiopencart.com                                                 #
#  โดย Somsak2004 วันที่ 13 กุมภาพันธ์ 2553                                                                  #
#############################################################################
# โดยการสนับสนุนจาก                                                                                      #
# Unitedsme.com : ผู้ให้บริการเช่าพื้นที่เว็บไซต์ จดโดเมน ระบบ Linux                                              #
# Net-LifeStyle.com : ผู้ให้บริการเช่าพื้นที่เว็บไซต์์ จดโดเมน ระบบ Linux										   #
# SiamWebThai.com : SEO ขั้นเทพ โปรโมทเว็บขั้นเซียน ออกแบบ พัฒนาเว็บไซต์ / ตามความต้องการ และถูกใจ Google 		   #
#############################################################################
class ControllerModuleBlog extends Controller {
	
	public function index() {
		$this->language->load('module/blog');
		
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_cep'] = $this->language->get('entry_cep');
		$this->data['entry_phone'] = $this->language->get('entry_phone');
		$this->data['entry_investimento'] = $this->language->get('entry_investimento');
		$this->data['entry_review'] = $this->language->get('entry_review');
		$this->data['entry_rating'] = $this->language->get('entry_rating');
		$this->data['entry_good'] = $this->language->get('entry_good');
		$this->data['entry_bad'] = $this->language->get('entry_bad');
		$this->data['entry_captcha'] = $this->language->get('entry_captcha');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
	
		$this->data['by'] = $this->language->get('by');
		$this->id = 'blog';
		$this->load->model('module/blog');
		if(isset($this->request->get['tipo'])){
			$tipo = $this->request->get['tipo'];
		}else{
			$tipo = null;
		}
		
		if(isset($this->request->get["blog_id"])){
		
			$posts = $this->model_module_blog->getPosts($this->request->get["blog_id"],null);
		}elseif($this->request->get["route"] == 'module/blog'){
			if(isset($this->request->get["page"])){
				$page = $this->request->get["page"];
			}else{
				$page = 1;
			}
			
			$pagina = Array(($page - 1) * 15, 15);
			
			
			$posts = $this->model_module_blog->getPosts(null,$pagina,null,$tipo);
			$total = $this->model_module_blog->getPosts(null,null,null,$tipo,true);
			
			
			$pagination = new Pagination();
			$pagination->total = $total;
			$pagination->page = $page;
			$pagination->limit = 15; 
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = HTTP_SERVER . 'index.php?route=module/blog/&page={page}';

			$this->data['pagination'] = $pagination->render();
		}else{
			$posts = $this->model_module_blog->getPosts(null,4,null,$tipo);
		}
		
		if(isset($tipo) && !empty($tipo)){
			if($tipo == 'repasse'){
				$this->data["title_type"] = "Repasse de negócios";
			}else{
				$this->data["title_type"] = "Pontos Comerciais";
			}
		}else{
			$this->data["title_type"] = "Notícias";
		}
		
		$this->load->model('tool/seo_url');
		$this->load->model('tool/image');
		
		$totalPosts = $this->model_module_blog->getPosts(null,10,null,$tipo,null);

		//print "aqui";
		//print_r($posts);
		
	
		for($i=0;$i<count($posts);$i++){
			if(strlen($posts[$i]['youtube']) > 0){
				$posts[$i]['embed'] = $this->getEmbedYoutube($posts[$i]['youtube']);
				$posts[$i]['youtube'] = $this->getThumbYoutube($posts[$i]['youtube'],$posts[$i]["subject"]);
			}
			$posts[$i]['images'] = $this->model_module_blog->getImages($posts[$i]['post_id']);

			$posts[$i]['href'] = $this->model_tool_seo_url->rewrite(HTTP_SERVER . "index.php?route=module/blog&blog_id=" . $posts[$i]['post_id']);
			
			$posts[$i]['descricao'] = trim(substr(strip_tags($posts[$i]['resumo']),0,150))." ...";
			
			if(isset($posts[$i]['product_id']))
			{
			$posts[$i]['product_id'] = $posts[$i]['product_id']; 
			
			$product_id_last = $posts[$i]['product_id']; 
			}
			
			for($y=0;$y<count($posts[$i]['images']);$y++){
				if ($posts[$i]['images'][$y]['image'] && file_exists(DIR_IMAGE . $posts[$i]['images'][$y]['image'])) {
					$posts[$i]['images'][$y]['thumb'] = $this->model_tool_image->resize($posts[$i]['images'][$y]['image'], 60, 60);
				} else {
					$posts[$i]['images'][$y]['thumb'] = $this->model_tool_image->resize('no_image.jpg', 60, 60);
				}
			}
		}
		
		$i = 0;
		
		for($i=0;$i<count($totalPosts);$i++){
			if(strlen($totalPosts[$i]['youtube']) > 0){
				$totalPosts[$i]['embed'] = $this->getEmbedYoutube($totalPosts[$i]['youtube']);
				$totalPosts[$i]['youtube'] = $this->getThumbYoutube($totalPosts[$i]['youtube'],$totalPosts[$i]["subject"]);
			}
			$totalPosts[$i]['images'] = $this->model_module_blog->getImages($totalPosts[$i]['post_id']);

			$totalPosts[$i]['href'] = $this->model_tool_seo_url->rewrite(HTTP_SERVER . "index.php?route=module/blog&blog_id=" . $totalPosts[$i]['post_id']);
			
			$totalPosts[$i]['descricao'] = trim(substr(strip_tags($totalPosts[$i]['resumo']),0,150))." ...";
			
			for($y=0;$y<count($totalPosts[$i]['images']);$y++){
				if ($totalPosts[$i]['images'][$y]['image'] && file_exists(DIR_IMAGE . $totalPosts[$i]['images'][$y]['image'])) {
					$totalPosts[$i]['images'][$y]['thumb'] = $this->model_tool_image->resize($totalPosts[$i]['images'][$y]['image'], 60, 60);
				} else {
					$totalPosts[$i]['images'][$y]['thumb'] = $this->model_tool_image->resize('no_image.jpg', 60, 60);
				}
			}
		}
		


		$this->data['posts'] = $posts;    
		
		if(isset($product_id_last))
		{

			$this->data['product_id'] = $product_id_last;		
			$posts = $this->model_module_blog->getPosts(null,7,null,null,null,$product_id_last);
			$this->load->model('tool/seo_url');
			$this->load->model('tool/image');
			
			$this->data['link_franquia'] = $this->model_tool_seo_url->rewrite(HTTP_SERVER . "index.php?route=product/product&product_id=" . $product_id_last);
			
			
			for($i=0;$i<count($posts);$i++){
				$posts[$i]['titulo'] = $posts[$i]['subject'];   
				$posts[$i]['descricao'] = trim(substr(strip_tags($posts[$i]['resumo']),0,150))." ...";
				$posts[$i]['href'] = $this->model_tool_seo_url->rewrite(HTTP_SERVER . "index.php?route=module/blog&blog_id=" . $posts[$i]['post_id']);
			}
			$this->data['posts_relacionados'] = $posts;   
		}
		
		$this->data['totalPosts'] = $totalPosts;
		
	
		if(isset($this->request->get["blog_id"])){
			$this->children = array(
				'common/column_right',
				'common/column_left',
				'common/footer',
				'common/header'
			);
			
		$this->document->keywords = $posts[0]['meta_keywords'];
			
		$this->document->description = $posts[0]['meta_description'];
		
		$this->document->title = $posts[0]['meta_title'];
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/news.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/news.tpl';
			} else {
				$this->template = 'default/template/module/news.tpl';
			}
			
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
		}elseif($this->request->get["route"] == 'module/blog'){
			$this->children = array(
				'common/column_right',
				'common/column_left',
				'common/footer',
				'common/header'
			);
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/list_news.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/list_news.tpl';
			} else {
				$this->template = 'default/template/module/list_news.tpl';
			}
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
		}else{
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blog.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/blog.tpl';
			} else {
				$this->template = 'default/template/module/blog.tpl';
			}
			$this->render();
		}
	}
	
	private function getEmbedYoutube($link){
		$_link = explode("/", $link);
		$cont = count($_link)-1;
		$embed = '<iframe width="425" height="349" src="http://www.youtube.com/embed/'.$_link[$cont].'" frameborder="0" allowfullscreen></iframe>';
		return $embed;
	}
	
	private function getThumbYoutube($link, $post_name){
		$_link = explode("/", $link);
		$cont = count($_link)-1;
		$img = '<img src="//i3.ytimg.com/vi/'.$_link[$cont].'/default.jpg" alt="'.$post_name.'">';
		return $img;
	}
	
}
?>