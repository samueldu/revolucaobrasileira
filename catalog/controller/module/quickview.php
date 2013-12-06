<?php
class ControllerModuleQuickView extends Controller {
	protected function index() {
		$this->language->load('module/quickview');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->id = 'quickview';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/quickview.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/quickview.tpl';
		} else {
			$this->template = 'default/template/module/quickview.tpl';
		}
		
		$this->render();
	}
	
	function getDetails(){
		$product_id = $this->request->get['product_id'];
		
		$this->load->model('catalog/product');
		$this->load->model('catalog/review');
		$this->load->model('tool/image');
		
		$product_info = $this->model_catalog_product->getProduct($product_id);
		$options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);
		
		$thumb = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'));
		
		$product_info["image"] = $thumb;
		$product_info["description"] = html_entity_decode($product_info["description"]);
		
		$price = "R$ 0,00";
		foreach ($product_info as $key => $value){
			if($key == 'price'){
				$price = $this->currency->format($value);
			}
		}
		
		$product_info["price"] = $price;
		$retorno["product_info"] = $product_info;
		$retorno["options"] = $options;
		$retorno["action"] = str_replace('&', '&amp',HTTP_SERVER . 'index.php?route=checkout/cart');
		
		$average = false;
		if ($this->config->get('config_review')) {
			$average = $this->model_catalog_review->getAverageRating($product_id);	
		} else {
			$average = false;
		}
		$this->load->model('tool/seo_url'); 

		$url = $this->model_tool_seo_url->rewrite(HTTP_SERVER . "index.php?route=product/product&product_id=" . $product_id);
		if($average !== 0){
			$retorno["average"] = '<img src="catalog/view/theme/'.TEMPLATE.'/image/stars_'.$average.'.png" alt="'.sprintf($this->language->get('text_stars'), $average).'" style="margin-top: 2px;" />
									<br><a href="'.$url.'#tab_review" style="margin-left:50px">Avalie você também.</a>';
		}else{
			$retorno["average"] = '<a href="'.$url.'#tab_review">Seja o primeiro a avaliar.</a>';
		}
		
		$special = $this->model_catalog_product->getProductSpecial($product_id);
			
		if ($special) {
			$special = $this->currency->format($special);
		} else {
			$special = FALSE;
		}
		
		$retorno["special"] = $special;
		
		$retorno["url_product"] = $url;
		
		echo json_encode($retorno);
	}
	
	public function addToCart(){
		$product_id = $this->request->get['product_id'];
		$quantity = $this->request->get['quantity'];
		$option = $this->request->get['option'];
		
		if($this->cart->add($product_id, $quantity, $option))
			echo json_encode(Array("reponse",true));
		else
			echo json_encode(Array("reponse",false));
	}
}
?>
