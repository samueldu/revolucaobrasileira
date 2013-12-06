<?php
class ModelReportStock extends Model {
	public function getProductStockReport($start = 0, $limit = 20) {
		$total = 0;

		$product_data = array();

		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 20;
		}

		$query = $this->db->query("SELECT p.product_id, p.quantity AS stock, pd.name, p.sku, p.model, p.location FROM " . DB_PREFIX . "product p, " . DB_PREFIX . "product_description pd WHERE pd.product_id = p.product_id and pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.quantity ASC LIMIT " . (int)$start . "," . (int)$limit);

		foreach ($query->rows as $result) {

			$product_data[] = array(
				'id'    	=> $result['product_id'],
				'name'    	=> $result['name'],
				'sku'		=> $result['sku'],
				'location'	=> $result['location'],
				'model'   	=> $result['model'],
				'stock'  	=> $result['stock']
			);
			$subquery = $this->db->query("SELECT pod.name AS optionname, povd.name AS valuename, pov.subtract, pov.quantity FROM " . DB_PREFIX . "product_option_description pod, " . DB_PREFIX . "product_option_value_description povd, " . DB_PREFIX . "product_option_value pov WHERE pod.product_id = " . $result['product_id'] . " and pov.product_option_id = pod.product_option_id and povd.product_option_value_id = pov.product_option_value_id and pod.language_id = '" . (int)$this->config->get('config_language_id') . "' and povd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pov.quantity ASC");
			foreach ($subquery->rows as $ovresult) {
				if($ovresult['subtract'] == '1') {
					$product_data[] = array(
						'id' => '',
						'name' => '',
						'sku' => '',
						'location' => '',
						'model' => '- - - - ' . $ovresult['optionname'] . ' / ' . $ovresult['valuename'],
						'stock' => $ovresult['quantity']
					);
				}
			}
		}
		return $product_data;
	}
}
?>