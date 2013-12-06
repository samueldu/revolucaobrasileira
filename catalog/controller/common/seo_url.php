<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
			
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);   
			
			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");   
				
				if ($query->num_rows) {
					$url = explode('=', $query->row['query']); 
					
					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}
					
					if ($url[0] == 'politico_id') {
						$this->request->get['politico_id'] = $url[1];
					}  
					
					if ($url[0] == 'absurdo_id') {
						$this->request->get['absurdo_id'] = $url[1];
					}  
					
					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}	
					
					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}
					
					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}
					
										if ($url[0] == 'blog_id') {
						$this->request->get['blog_id'] = $url[1];
					}
					
					
	
				} else {
					//$this->request->get['route'] = 'error/not_found';	
					
					//print_R($this->request->get);
					
					$query = null;
					
					if (($this->request->get['_route_'] == 'product/product' && isset($this->request->get['product_id']))) {
						$query = "product_id=".$this->request->get['product_id'];
					} elseif ($this->request->get['_route_'] == 'product/category' && isset($this->request->get['path'])) {
						$query = "category_id=".$this->request->get['path'];         
					} elseif ($this->request->get['_route_'] == 'product/manufacturer' && isset($this->request->get['manufacturer_id'])) {
						$query = "manufacturer_id=".$this->request->get['manufacturer_id'];
					} elseif ($this->request->get['_route_'] == 'information/information' && isset($this->request->get['information_id'])) {
						$query = "information_id=".$this->request->get['information_id'];
					}elseif ($this->request->get['_route_'] == 'politico/politico' && isset($this->request->get['politico_id'])) {
						$query = "politico_id=".$this->request->get['politico_id'];
					}elseif ($this->request->get['_route_'] == 'conteudo/absurdo' && isset($this->request->get['absurdo_id'])) {
						$query = "absurdo_id=".$this->request->get['absurdo_id'];
					}

					if ($query) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->db->escape($query) . "'");
						if ($query->num_rows) {
							$this->redirect("/".$query->row['keyword']);
						}
					}

					// All other request might be a normal route.
					$this->request->get['route'] = $this->request->get['_route_'];
				}
			}
			
	   
			
			/* excessoes para ajax */
			if(!substr_count($this->request->get['_route_'],"product/product/review") 
			and !substr_count($this->request->get['_route_'],"product/product/write")
			and !substr_count($this->request->get['_route_'],"product/product/avise")
			and !substr_count($this->request->get['_route_'],"quickview")
			and !substr_count($this->request->get['_route_'],"information")
			and !substr_count($this->request->get['_route_'],"callback")
			and !substr_count($this->request->get['_route_'],"callback")
			and !substr_count($this->request->get['_route_'],"ajax"))      
			{ 
			
			if (isset($this->request->get['product_id'])) {
				$this->request->get['route'] = 'product/product';
			} elseif(isset($this->request->get['search']) and !substr_count($this->request->get['_route_'],"autocomplete")) {
				$this->request->get['route'] = 'product/search';
			} elseif (isset($this->request->get['path'])) {
				$this->request->get['route'] = 'product/category';
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$this->request->get['route'] = 'product/manufacturer';
			} elseif (isset($this->request->get['information_id'])) {
				$this->request->get['route'] = 'information/information';
			}elseif (isset($this->request->get['politico_id'])) {
				$this->request->get['route'] = 'politico/politico';
			}elseif (isset($this->request->get['absurdo_id'])) {
				$this->request->get['route'] = 'conteudo/absurdo';
			}elseif (isset($this->request->get['blog_id'])) {
					$this->request->get['route'] = 'module/blog';
				}  
			
			}    
			
			if (isset($this->request->get['route'])) {
				return $this->forward($this->request->get['route']);
			}
		}
	}
}        
?>