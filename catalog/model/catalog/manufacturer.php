<?php
class ModelCatalogManufacturer extends Model {
	public function getManufacturer($manufacturer_id) {
		//$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m.manufacturer_id = '" . (int)$manufacturer_id . "' AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m.manufacturer_id = '" . (int)$manufacturer_id . "' AND md.language_id = '" . (int)$this->config->get('config_language_id') . "' AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
	
		return $query->row;	
	}
	
	public function getManufacturers() {
		$manufacturer = $this->cache->get('manufacturer.' . (int)$this->config->get('config_store_id'));            
		
		if (!$manufacturer) {
			//$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY sort_order, LCASE(m.name) ASC");
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "' AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY sort_order, LCASE(md.name) ASC");

			$manufacturer = $query->rows;              
			
			$this->cache->set('manufacturer.' . (int)$this->config->get('config_store_id'), $manufacturer);
		}
		
		return $manufacturer;
	} 
	
	public function getManufacturesToCategory($category_id){
		$manufacturer = $this->cache->get('manufacturerToCategory' . (int)$this->config->get('config_store_id').'_'.$category_id);
		
		if(!$manufacturer){
			$sql = "SELECT
					m.*
					FROM " . DB_PREFIX . "manufacturer m
					LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON m.manufacturer_id = m2s.manufacturer_id
					LEFT JOIN " . DB_PREFIX . "product p ON p.manufacturer_id = m.manufacturer_id and p.quantity > 0
					LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON p2c.product_id = p.product_id
					WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
					AND p2c.category_id = '".$category_id."' 
					GROUP BY m.manufacturer_id
					ORDER BY m.sort_order, LCASE(m.name) ASC";
					
					//print $sql;
					
			$query = $this->db->query($sql);
			$manufacturer = $query->rows;
			$this->cache->set('manufacturerToCategory' . (int)$this->config->get('config_store_id').'_'.$category_id, $manufacturer);
		}
		
		return $manufacturer;
	}
}
?>