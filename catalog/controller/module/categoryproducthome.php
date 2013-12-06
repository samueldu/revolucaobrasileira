<?php  
class ControllerModulecategoryproducthome extends Controller {
	protected $category_id = 0;
	protected $path = array();
	
	protected function index() {
		$this->language->load('module/categoryproducthome');
		
    	//$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('catalog/product');
		$this->load->model('catalog/review');
		$this->load->model('tool/seo_url');
		$this->load->model('tool/image');
		
			
		$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');
		
			
		$this->data['products'] = array();
		$results = $this->model_catalog_product->getProductsByMultipleCategoryId($this->config->get('categoryproducthome_category'),'p.sort_order', 'ASC', 0, $this->config->get('categoryproducthome_limit'));
			
		foreach ($results as $result_category){
			foreach ($result_category as $result) {
				$this->data['heading_title'][$result['category_id']]= $this->model_catalog_category->getCategory($result['category_id']);
				
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
				
				$this->data['products'][$result['category_id']][] = array(
					'product_id'    => $result['product_id'],
					'name'    		=> $result['name'],
					'quantity'    		=> $result['quantity'],
					'model'   		=> $result['model'],
					'rating'  		=> $rating,
					'stars'   		=> sprintf($this->language->get('text_stars'), $rating),
					'price'   		=> $price,
					'options'   	=> $options,
					'special' 		=> $special,
					'image'   		=> $this->model_tool_image->resize($image, 38, 38),
					'thumb'   		=> $this->model_tool_image->resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
					'href'    		=> $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $result['product_id']),
					'add'    		=> $add
				);
				
				foreach($this->data['products'] as $k_product => $product)
	          	{
	          		foreach ($this->data["products"][$k_product] as $key=>$value)
	          			$this->data['products'][$k_product][$key]['txt'] = $this->cart->celula($this->data['products'][$k_product][$key]);
				}
			}
		}

		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = TRUE;
		} elseif ($this->customer->isLogged()) {
			$this->data['display_price'] = TRUE;
		} else {
			$this->data['display_price'] = FALSE;
		}
		//$this->data['categoryproducthome'] = $this->getProducts($this->config->get('categoryproducthome_category'),$this->config->get('categoryproducthome_limit'));
						
		$this->id = 'categoryproducthome';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/categoryproducthome.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/categoryproducthome.tpl';
		} else {
			$this->template = 'default/template/module/categoryproducthome.tpl';
		}
		
		$this->render();
  	}
	
	protected function getProducts($category_id, $limit=20) {
		
		$categoryproducthome = array();
		$category_id = array_shift($this->path);
		
		$results = $this->model_catalog_product->getProductsByCategoryId($category_id);
		
		$i=0;
		foreach ($results as $result) {	
			if (!$current_path) 
			{
				$new_path = $result['category_id'];
			} 
			else 
			{
				$new_path = $current_path . '_' . $result['category_id'];
			}
			
			if ($result['image']) {
						$image = $result['image'];
					} else {
						$image = 'no_image.jpg';
					}
			
			
			if ($this->category_id == $result['category_id']) {
				$categoryproducthome[$i]['href'] = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&amp;path=' . $new_path);
			
			} else {
				$categoryproducthome[$i]['href'] = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/category&amp;path=' . $new_path);
			}
			$categoryproducthome[$i]['thumb'] = $this->model_tool_image->resize($image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			$categoryproducthome[$i]['name'] = $result['name'];
			
        $i++;
 
		}
 
		
		return $categoryproducthome;
	}		
}
?>