<?php 
class ControllerProductCategory extends Controller {  
	public function index() { 
		$this->language->load('product/category');
	
		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
      		'href'      => HTTP_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
       		'separator' => FALSE
   		);	

		$this->load->model('catalog/category');
		$this->load->model('tool/seo_url');  
		
		if (isset($this->request->get['path'])) {
			$path = '';
		
			$parts = explode('_', $this->request->get['path']);
			
			$title = "";
		
			foreach ($parts as $path_id) {
				$category_info = $this->model_catalog_category->getCategory($path_id);
				
				if ($category_info) {
					if (!$path) {
						$path = $path_id;
					} else {
						$path .= '_' . $path_id;
					}
					
					//$title .= " ".$category_info['name'].",";  

	       			$this->document->breadcrumbs[] = array(
   	    				'href'      => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $path),
    	   				'text'      => $category_info['name'],
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}		
		
			$category_id = array_pop($parts);
		} else {
			$category_id = 0;
		}
		
		//$title = substr($title,0,strlen($title)-1);
		
		//implementaÃ§Ã£o para filtro de marcas
		/*
		$this->load->model('catalog/manufacturer');
		$this->data['text_filter_manufactures'] = $this->language->get('text_filter_manufactures');
		$this->data['text_all_brands'] = $this->language->get('text_all_brands');
		$manufactures = $this->model_catalog_manufacturer->getManufacturesToCategory($category_id);
		$manufacture = null;
		foreach ($manufactures as $value){
			$manufacture[] = $value;
			$manufacture[count($manufacture)-1]["href_url"] = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC&manufacturer_id='.$value['manufacturer_id']);
		}
		$this->data["manufactures"] = $manufacture;
		$this->data["selectManufacurer"] = HTTP_SERVER . 'index.php?route=product/category&path=' . $path;
		*/
		//fim 
		
		
		//implementação para filtro de tamanhos 
		
				
		$category_info = $this->model_catalog_category->getCategory($category_id);
	
		if ($category_info) {
			
			if($category_info['title'] == "")			
	  		$this->document->title =  $this->config->get('config_name').", ".$category_info['name'];
	  		else
			$this->document->title =  $category_info['title'];
			
			$this->document->keywords = $category_info['meta_keywords'];
			
			$this->document->description = $category_info['meta_description'];
			
			$this->data['heading_title'] = $category_info['name'];
			
			$this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			
			$this->data['text_sort'] = $this->language->get('text_sort');
			
			$this->load->model('tool/image'); 
			
			if ($category_info['image']) {
				$image = $category_info['image'];
			} else {
				$image = '';
			}

			$this->data['thumb'] = $this->model_tool_image->resize($image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else { 
				$page = 1;
			}	
			
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'p.sort_order';
			}
			
			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'ASC';
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$manufacturer_id = $this->request->get['manufacturer_id'];
			} else {
				$manufacturer_id = 'p.manufacturer_id';
			}
			
			if (isset($this->request->get['option_id'])) {
				$option_id = $this->request->get['option_id'];
			} else {
				$option_id  = 'product_option_value_description.name';
			}
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}
			
			if (isset($this->request->get['option_id'])) {
				$url .= '&option_id=' . $this->request->get['option_id'];
			}
			
			
		$this->data['text_filter_sizes'] = $this->language->get('text_filter_sizes');
		$this->data['text_all_sizes'] = $this->language->get('text_all_sizes');
		$this->data["sizes"][] = array("href_url" => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort='.$sort.'&order='.$order.'&option_id=P'), "name" => 'P');
		
		$this->data["sizes"][] = array("href_url" => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort='.$sort.'&order='.$order.'&option_id=M'), "name" => 'M');
		
		$this->data["sizes"][] = array("href_url" => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort='.$sort.'&order='.$order.'&option_id=G'), "name" => 'G');
		
		$this->data["selectSize"] = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $path.'&sort='.$sort.'&order='.$order);
			
			
			
			$this->load->model('catalog/product');  
						 
			$category_total = $this->model_catalog_category->getTotalCategoriesByCategoryId($category_id);
			$product_total = $this->model_catalog_product->getTotalProductsByCategoryId($category_id, $manufacturer_id,$option_id);
			
			if ($category_total || $product_total) {
        		$this->data['categories'] = array();
        		
				$results = $this->model_catalog_category->getCategories($category_id);
				
        		foreach ($results as $result) {
					if ($result['image']) {
						$image = $result['image'];
					} else {
						$image = 'no_image.jpg';
					}
					
					$this->data['categories'][] = array(
            			'name'  => $result['name'],
            			'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url),
            			'thumb' => $this->model_tool_image->resize($image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'))
          			);
        		}
		
				$this->load->model('catalog/review');
				
				$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');
				
				$this->data['products'] = array();
        		
				$results = $this->model_catalog_product->getProductsByCategoryId($category_id, $sort, $order, ($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'), $manufacturer_id,$option_id);
				
        		foreach ($results as $result) {
        			/*echo "<pre>";
					print_r($result);
					exit;*/
					if ($result['image']) {
						$image = $result['image'];
					} else {
						$image = 'no_image.jpg';
					}
					
					if ($this->config->get('config_review')) {
						$rating = $this->model_catalog_review->getAverageRating($result['product_id']);	
					} else {
						$rating = false;
					}
 					
					$special = FALSE;
					
					$discount = $this->model_catalog_product->getProductDiscount($result['product_id']);
 					
					if ($discount) {
						$price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					
						$special = $this->model_catalog_product->getProductSpecial($result['product_id']);
					
						if ($special) {
							$special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
						}					
					}
			
					$options = $this->model_catalog_product->getProductOptions($result['product_id']);
					
					if ($options) {
						$add = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $result['product_id']);
					} else {
						$add = HTTPS_SERVER . 'index.php?route=checkout/cart&product_id=' . $result['product_id'];
					}
					
					$this->data['products'][] = array(
						'product_id' => $result['product_id'],
            			'name'    => $result['name'],
            			'quantity'    => $result['quantity'],
						'model'   => $result['model'],
            			'rating'  => $rating,
						'stars'   => sprintf($this->language->get('text_stars'), $rating),
						'thumb'   => $this->model_tool_image->resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
            			'price'   => $price,
            			'options' => $options,
						'special' => $special,
						'href'    => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&path=' . $this->request->get['path'] . '&product_id=' . $result['product_id']),
						'add'	  => $add
          			);
          			
          			//print_r($this->data['products']);
          			
          			//exit;
          			
          			foreach($this->data['products'] as $key=>$value)
          			{
          				$this->data['products'][$key]['txt'] = $this->cart->celula($this->data['products'][$key]);
          			}
          			          			
        		}

				if (!$this->config->get('config_customer_price')) {
					$this->data['display_price'] = TRUE;
				} elseif ($this->customer->isLogged()) {
					$this->data['display_price'] = TRUE;
				} else {
					$this->data['display_price'] = FALSE;
				}
		
				$url = '';
		
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}			
		
				$this->data['sorts'] = array();
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_default'),
					'value' => 'p.sort_order-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC&manufacturer_id='.$manufacturer_id.'&option_id='.$option_id)
				);
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_asc'),
					'value' => 'pd.name-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC&manufacturer_id='.$manufacturer_id.'&option_id='.$option_id)
				);
 
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_desc'),
					'value' => 'pd.name-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC&manufacturer_id='.$manufacturer_id.'&option_id='.$option_id)
				);

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_asc'),
					'value' => 'p.price-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort=p.price&order=ASC&manufacturer_id='.$manufacturer_id.'&option_id='.$option_id)
				); 

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_desc'),
					'value' => 'p.price-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort=p.price&order=DESC&manufacturer_id='.$manufacturer_id.'&option_id='.$option_id)
				); 
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort=rating&order=DESC&manufacturer_id='.$manufacturer_id.'&option_id='.$option_id)
				); 
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort=rating&order=ASC&manufacturer_id='.$manufacturer_id.'&option_id='.$option_id)
				);
				
	/*			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_model_asc'),
					'value' => 'p.model-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort=p.model&order=ASC')
				);
 
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_model_desc'),
					'value' => 'p.model-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . '&sort=p.model&order=DESC')
				);
				*/
				
				$url = '';
		
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}	

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['manufacturer_id'])) {
					$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
				}
				
				if (isset($this->request->get['option_id'])) {
					$url .= '&option_id=' . $this->request->get['option_id'];
				}
			
				$pagination = new Pagination();
				$pagination->total = $product_total;
				$pagination->page = $page;
				$pagination->limit = $this->config->get('config_catalog_limit');
				$pagination->text = $this->language->get('text_pagination');
				$pagination->url = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . $url . '&page={page}');
			
				$this->data['pagination'] = $pagination->render();
			
				$this->data['sort'] = $sort;
				$this->data['order'] = $order;
				$this->data['manufacturer_id'] = $manufacturer_id;
				$this->data['option_id'] = $option_id;
			
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/product/category.tpl';
				} else {
					$this->template = 'default/template/product/category.tpl';
				}	
				
				$this->children = array(
					'common/column_right',
					'common/column_left',
					'common/footer',
					'common/header'
				);
		
				$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));										
      		} else {
        		$this->document->title = $category_info['name'];
				
				$this->document->description = $category_info['meta_description'];
				
        		$this->data['heading_title'] = $category_info['name'];

        		$this->data['text_error'] = $this->language->get('text_empty');

        		$this->data['button_continue'] = $this->language->get('button_continue');

        		$this->data['continue'] = HTTP_SERVER . 'index.php?route=common/home';
		
				$this->data['categories'] = array();
				
				$this->data['products'] = array();
						
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/product/category.tpl';
				} else {
					$this->template = 'default/template/product/category.tpl';
				}	
				
				$this->children = array(
					'common/column_right',
					'common/column_left',
					'common/footer',
					'common/header'
				);
		
				$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
      		}
    	} else {
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
				
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}	
			
			if (isset($this->request->get['path'])) {	
	       		$this->document->breadcrumbs[] = array(
   	    			'href'      => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . $url),
    	   			'text'      => $this->language->get('text_error'),
        			'separator' => $this->language->get('text_separator')
        		);
			}
				
			$this->document->title = $this->language->get('text_error');

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = HTTP_SERVER . 'index.php?route=common/home';
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}	
			
			$this->children = array(
				'common/column_right',
				'common/column_left',
				'common/footer',
				'common/header'
			);
		
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
		}
  	}
}
?>