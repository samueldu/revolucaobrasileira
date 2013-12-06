<?php
class ModelModuleHotsite extends Model {
	public function getProductsCategorys(){
		$sql =	"SELECT c.category_id,
						cd.name as category_name,
						p.product_id,
						pd.name as product_name
				   FROM " . DB_PREFIX . "product p
			  LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
			  LEFT JOIN " . DB_PREFIX . "product_to_category ptc ON (p.product_id = ptc.product_id)
			  LEFT JOIN " . DB_PREFIX . "category c ON (ptc.category_id = c.category_id)
			  LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
				  WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'
					AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
					AND p.status = 1
					AND c.status = 1
			   ORDER BY c.category_id, p.product_id";
		
		$result = $this->db->query($sql);
		return $result->rows;
	} 
}
?>