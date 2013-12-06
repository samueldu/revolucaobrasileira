<?php
class ModelCatalogProduct extends Model {
	public function getProduct($product_id) {
		//$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, m.image AS manufacturer_logo FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
		$sql = "SELECT DISTINCT p.*, pd.description AS description, pd.meta_description AS meta_description, pd.meta_keywords AS meta_keywords, pd.name AS name, p.image, md.name AS manufacturer, ss.name AS stock, manu.image as manufacturer_logo FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) LEFT JOIN manufacturer manu ON (manu.manufacturer_id = md.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'";
        $query = $this->db->query($sql);

		return $query->row;
	}

	public function getProducts() {
		//$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, wcd.unit AS weight_class FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (p.weight_class_id = wcd.weight_class_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
        $query = $this->db->query("SELECT DISTINCT p.*, pd.description AS description, pd.meta_description AS meta_description, pd.meta_keywords AS meta_keywords, pd.name AS name, p.image, md.name AS manufacturer, ss.name AS stock, wcd.unit AS weight_class FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (p.weight_class_id = wcd.weight_class_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
	
		return $query->rows;
	}
	
	public function getProductsByCategoryId($category_id, $sort = 'p.sort_order', $order = 'ASC', $start = 0, $limit = 20, $manufacturer_id = 'p.manufacturer_id',$option_id = 'product_option_value_description.name') {
	//	$sql = "SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating,(SELECT CASE WHEN (p1.quantity > 0 ) THEN 1 ELSE 0 END FROM " . DB_PREFIX . "product p1 WHERE p1." . DB_PREFIX . "product_id = p.product_id) as IS_STOCK FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "'";
    $sql = "SELECT p.*, pd.description AS description, pd.meta_description AS meta_description, pd.meta_keywords AS meta_keywords, pd.name AS name, p.image, md.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) 
    FROM " . DB_PREFIX . "review r 
    WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating,(SELECT CASE WHEN (p1.quantity > 0 ) THEN 1 ELSE 0 END 
    FROM " . DB_PREFIX . "product p1 
    WHERE p1." . DB_PREFIX . "product_id = p.product_id) as IS_STOCK FROM " . DB_PREFIX . "product p 
    LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
    LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
    LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id) 
    LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) 
    LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
    
    if($option_id !== 'product_option_value_description.name')
	{
    	$sql .= " INNER JOIN " . DB_PREFIX . "product_option_value_description ON (p2c.product_id = product_option_value_description.product_id AND 				   product_option_value_description.name = '".$option_id."')
    	INNER JOIN " . DB_PREFIX . "product_option_value ON (product_option_value_description.product_option_value_id = product_option_value.product_option_value_id AND product_option_value.quantity > 0 and product_option_value_description.product_id = product_option_value.product_id)";
	}
    
    $sql .= " WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "'";
         

		if($manufacturer_id !== 'p.manufacturer_id'){
			$sql .= " AND p.manufacturer_id = ". (int) $manufacturer_id;
		}
		
		$sort_data = array(
			'pd.name',
			'p.sort_order',
			'special',
			'rating',
			'p.price',
			'p.model'
		);
		
		if($this->config->get('config_order_stock') == '1'){
			$is_stock = " IS_STOCK DESC, ";
		}else{
			$is_stock = '';
		}

		if (in_array($sort, $sort_data)) {
			if ($sort == 'pd.name' || $sort == 'p.model') {
				$sql .= " ORDER BY $is_stock LCASE(" . $sort . ")";
			} else {
				$sql .= " ORDER BY $is_stock " . $sort;
			}
		} else {
			$sql .= " ORDER BY $is_stock p.sort_order";	
		}
			
		if ($order == 'DESC') {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		$sql .= " , date_added desc ";
		
		if ($start < 0) {
			$start = 0;
		}
		
		$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
		
		//print $sql;
		
		$query = $this->db->query($sql);
								  
		return $query->rows;
	} 

	public function getProductsByMultipleCategoryId($category_id, $sort = 'p.sort_order', $order = 'ASC', $start = 0, $limit = 20, $manufacturer_id = 'p.manufacturer_id') {
		$category_ids = explode(",",$category_id);
		foreach ($category_ids as $category_id){
			$sql = "SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating,(SELECT CASE WHEN (p1.quantity > 0 ) THEN 1 ELSE 0 END FROM " . DB_PREFIX . "product p1 WHERE p1." . DB_PREFIX . "product_id = p.product_id) as IS_STOCK FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "'";
			
			if($manufacturer_id !== 'p.manufacturer_id'){
				$sql .= " AND p.manufacturer_id = ". (int) $manufacturer_id;
			}
			
			$sort_data = array(
				'pd.name',
				'p.sort_order',
				'special',
				'rating',
				'p.price',
				'p.model'
			);
			
			if($this->config->get('config_order_stock') == '1'){
				$is_stock = " IS_STOCK DESC, ";
			}else{
				$is_stock = '';
			}
				
			if (in_array($sort, $sort_data)) {
				if ($sort == 'pd.name' || $sort == 'p.model') {
					$sql .= " ORDER BY $is_stock LCASE(" . $sort . ")";
				} else {
					$sql .= " ORDER BY $is_stock " . $sort;
				}
			} else {
				$sql .= " ORDER BY $is_stock p.sort_order";	
			}
				
			if ($order == 'DESC') {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			
			if ($start < 0) {
				$start = 0;
			}
			
			$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
			
			$query = $this->db->query($sql);
			$return[] = $query->rows;
		}
		return $return;
	} 
	
	public function getTotalProductsByCategoryId($category_id = 0, $manufacturer_id,$option_id) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_category p2c 
		LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id) 
		LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)"; 
		if($option_id !== 'product_option_value_description.name')
		{
			$sql .= " INNER JOIN product_option_value_description ON p2c.product_id = product_option_value_description.product_id AND product_option_value_description.name = '".$option_id."' 
			inner join product_option_value on (product_option_value_description.product_option_value_id = product_option_value.product_option_value_id and product_option_value.quantity > 0)"; 
		}

		$sql .= "WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' 
		AND p2c.category_id = '" . (int)$category_id . "'";
		if($manufacturer_id !== 'p.manufacturer_id')
			$sql .= " AND p.manufacturer_id = ".$manufacturer_id;

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getProductsByManufacturerId($manufacturer_id, $sort = 'p.sort_order', $order = 'ASC', $start = 0, $limit = 20) {
		//$sql = "SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating,(SELECT CASE WHEN (p1.quantity > 0 ) THEN 1 ELSE 0 END FROM " . DB_PREFIX . "product p1 WHERE p1." . DB_PREFIX . "product_id = p.product_id) as IS_STOCK FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND m.manufacturer_id = '" . (int)$manufacturer_id. "'";
        $sql = "SELECT p.*, pd.description AS description, pd.meta_description AS meta_description, pd.meta_keywords AS meta_keywords, pd.name AS name, p.image, md.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating,(SELECT CASE WHEN (p1.quantity > 0 ) THEN 1 ELSE 0 END FROM " . DB_PREFIX . "product p1 WHERE p1." . DB_PREFIX . "product_id = p.product_id) as IS_STOCK FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND md.manufacturer_id = '" . (int)$manufacturer_id. "'";
 

		$sort_data = array(
			'pd.name',
			'p.sort_order',
			'special',
			'rating',
			'p.price',
			'p.model'
		);
		
		if($this->config->get('config_order_stock') == '1'){
			$is_stock = " IS_STOCK DESC, ";
		}else{
			$is_stock = '';
		}
		
		if (in_array($sort, $sort_data)) {
			if ($sort == 'pd.name' || $sort == 'p.model') {
				$sql .= " ORDER BY $is_stock LCASE(" . $sort . ")";
			} else {
				$sql .= " ORDER BY $is_stock " . $sort;
			}
		} else {
			$sql .= " ORDER BY $is_stock p.sort_order";	
		}
			
		if ($order == 'DESC') {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if ($start < 0) {
			$start = 0;
		}
		
		$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	} 

	public function getTotalProductsByManufacturerId($manufacturer_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE status = '1' AND date_available <= NOW() AND manufacturer_id = '" . (int)$manufacturer_id . "'");
		
		return $query->row['total'];
	}
	
	public function getProductsByTag($tag, $category_id = 0, $sort = 'p.sort_order', $order = 'ASC', $start = 0, $limit = 20) {
		if ($tag) {
		
			//$sql = "SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating,(SELECT CASE WHEN (p1.quantity > 0 ) THEN 1 ELSE 0 END FROM " . DB_PREFIX . "product p1 WHERE p1." . DB_PREFIX . "product_id = p.product_id) as IS_STOCK FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_tags pt ON (p.product_id = pt.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND (LCASE(pt.tag) = '" . $this->db->escape(strtolower($tag)) . "'";
            $sql = "SELECT p.*, pd.description AS description, pd.meta_description AS meta_description, pd.meta_keywords AS meta_keywords, pd.name AS name, p.image, md.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating,(SELECT CASE WHEN (p1.quantity > 0 ) THEN 1 ELSE 0 END FROM " . DB_PREFIX . "product p1 WHERE p1." . DB_PREFIX . "product_id = p.product_id) as IS_STOCK FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_tags pt ON (p.product_id = pt.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND (LCASE(pt.tag) = '" . $this->db->escape(strtolower($tag)) . "'";
 

			$keywords = explode(" ", $tag);
						
			foreach ($keywords as $keyword) {
				$sql .= " OR LCASE(pt.tag) = '" . $this->db->escape(mb_strtolower($keyword, 'UTF8')) . "'";
			}
			
			$sql .= ")";
			
			if ($category_id) {
				$data = array();
				
				$this->load->model('catalog/category');
				
				$string = rtrim($this->getPath($category_id), ',');
				
				foreach (explode(',', $string) as $category_id) {
					$data[] = "category_id = '" . (int)$category_id . "'";
				}
				
				$sql .= " AND p.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE " . implode(" OR ", $data) . ")";
			}
		
			$sql .= " AND p.status = '1' AND p.date_available <= NOW() GROUP BY p.product_id";
		
			$sort_data = array(
				'pd.name',
				'p.sort_order',
				'special',
				'rating',
				'p.price',
				'p.model'
			);
			
			if($this->config->get('config_order_stock') == '1'){
				$is_stock = " IS_STOCK DESC, ";
			}else{
				$is_stock = '';
			}
				
			if (in_array($sort, $sort_data)) {
				if ($sort == 'pd.name' || $sort == 'p.model') {
					$sql .= " ORDER BY $is_stock LCASE(" . $sort . ")";
				} else {
					$sql .= " ORDER BY $is_stock " . $sort;
				}
			} else {
				$sql .= " ORDER BY $is_stock p.sort_order";	
			}
			
			if ($order == 'DESC') {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if ($start < 0) {
				$start = 0;
			}
		
			$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
			
			$query = $this->db->query($sql);
			
			$products = array();
			
			foreach ($query->rows as $key => $value) {
				$products[$value['product_id']] = $this->getProduct($value['product_id']);
			}
			
			return $products;
		}
	}
	
	public function getProductsByKeyword($keyword, $category_id = 0, $description = FALSE, $model = FALSE, $sort = 'p.sort_order', $order = 'ASC', $start = 0, $limit = 20,$modelType = "or") {
		if ($keyword) {
						
			//$sql = "SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating,(SELECT CASE WHEN (p1.quantity > 0 ) THEN 1 ELSE 0 END FROM " . DB_PREFIX . "product p1 WHERE p1." . DB_PREFIX . "product_id = p.product_id) as IS_STOCK FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "'";
            $sql = "SELECT p.*, pd.description AS description, pd.meta_description AS meta_description, pd.meta_keywords AS meta_keywords, pd.name AS name, p.image, md.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating,(SELECT CASE WHEN (p1.quantity > 0 ) THEN 1 ELSE 0 END FROM " . DB_PREFIX . "product p1 WHERE p1." . DB_PREFIX . "product_id = p.product_id) as IS_STOCK FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "'";
             
			
			if (!$description) {
				$sql .= " AND (LCASE(pd.name) LIKE '%" . $this->db->escape(mb_strtolower($keyword, 'UTF8')) . "%'";
			} else {
				$sql .= " AND (LCASE(pd.name) LIKE '%" . $this->db->escape(mb_strtolower($keyword, 'UTF8')) . "%' OR LCASE(pd.description) LIKE '%" . $this->db->escape(mb_strtolower($keyword, 'UTF8')) . "%'";
			}
			
			if (!$model) {
				$sql .= ")";
			} else {
				$sql .= " $modelType LCASE(p.model) LIKE '%" . $this->db->escape(strtolower($model)) . "%')";
			}
			
			if ($category_id) {
				$data = array();
				
				$this->load->model('catalog/category');
				
				$string = rtrim($this->getPath($category_id), ',');
				
				foreach (explode(',', $string) as $category_id) {
					$data[] = "category_id = '" . (int)$category_id . "'";
				}
				
				$sql .= " AND p.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE " . implode(" OR ", $data) . ")";
			}
		
			$sql .= " AND p.status = '1' AND p.date_available <= NOW() GROUP BY p.product_id";
		
			$sort_data = array(
				'pd.name',
				'p.sort_order',
				'special',
				'rating',
				'p.price',
				'p.model'
			);
			
			if($this->config->get('config_order_stock') == '1'){
				$is_stock = " IS_STOCK DESC, ";
			}else{
				$is_stock = '';
			}
			
			
			
			if (in_array($sort, $sort_data)) {
				if ($sort == 'pd.name' || $sort == 'p.model') {
					$sql .= " ORDER BY $is_stock LCASE(" . $sort . ")";
				} else {
					$sql .= " ORDER BY $is_stock " . $sort;
				}
			} else {
				$sql .= " ORDER BY $is_stock p.sort_order";	
			}
			
			if ($order == 'DESC') {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			
			$sql .= " , date_added desc ";

			if ($start < 0) {
				$start = 0;
			}
		
			$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
			
			//print $sql;
			

			$query = $this->db->query($sql);
						
			return $query->rows;
		}
		return 0;	
	}
	
	public function getTotalProductsByKeyword($keyword, $category_id = 0, $description = FALSE, $model = FALSE) {
		if ($keyword) {
			$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
			
			if (!$description) {
				$sql .= " AND (LCASE(pd.name) LIKE '%" . $this->db->escape(mb_strtolower($keyword, 'UTF8')) . "%'";
			} else {
				$sql .= " AND (LCASE(pd.name) LIKE '%" . $this->db->escape(mb_strtolower($keyword, 'UTF8')) . "%' OR LCASE(pd.description) LIKE '%" . $this->db->escape(mb_strtolower($keyword, 'UTF8')) . "%'";
			}

			if (!$model) {
				$sql .= ")";
			} else {
				$sql .= " OR LCASE(p.model) LIKE '%" . $this->db->escape(mb_strtolower($keyword, 'UTF8')) . "%')";
			}

			if ($category_id) {
				$data = array();
				
				$this->load->model('catalog/category');
				
				$string = rtrim($this->getPath($category_id), ',');
				
				foreach (explode(',', $string) as $category_id) {
					$data[] = "category_id = '" . (int)$category_id . "'";
				}
				
				$sql .= " AND p.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE " . implode(" OR ", $data) . ")";
			}
			
			$sql .= " AND p.status = '1' AND p.date_available <= NOW()";
			
			$query = $this->db->query($sql);
		
			if ($query->num_rows) {
				return $query->row['total'];
			} else {
				return 0;
			}
		}
		return 0;
	}
	
	public function getTotalProductsByTag($tag, $category_id = 0) {
		if ($tag) {
		
			$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_tags pt ON (p.product_id = pt.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND (LCASE(pt.tag) = '" . $this->db->escape(strtolower($tag)) . "'";

			$keywords = explode(" ", $tag);
						
			foreach ($keywords as $keyword) {
				$sql .= " OR LCASE(pt.tag) = '" . $this->db->escape(mb_strtolower($keyword, 'UTF8')) . "'";
			}
			
			$sql .= ")";
			
			if ($category_id) {
				$data = array();
				
				$this->load->model('catalog/category');
				
				$string = rtrim($this->getPath($category_id), ',');
				
				foreach (explode(',', $string) as $category_id) {
					$data[] = "category_id = '" . (int)$category_id . "'";
				}
				
				$sql .= " AND p.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE " . implode(" OR ", $data) . ")";
			}
		
			$sql .= " AND p.status = '1' AND p.date_available <= NOW()";
					
			$query = $this->db->query($sql);
			
			if ($query->num_rows) {
				return $query->row['total'];
			} else {
				return 0;
			}
		}
		return 0;
	}
	
	public function getPath($category_id) {
		$string = $category_id . ',';
		
		$results = $this->model_catalog_category->getCategories($category_id);

		foreach ($results as $result) {
			$string .= $this->getPath($result['category_id']);
		}
		
		return $string;
	}	
	
	public function getLatestProducts($limit) {
		$product_data = null;//$this->cache->get('product.latest.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $limit);

		if (!$product_data) { 
			$query = $this->db->query("SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, product_to_category.category_id AS path, (SELECT AVG(r.rating) 
			FROM " . DB_PREFIX . "review r 
			WHERE p.product_id = r.product_id 
			GROUP BY r.product_id) AS rating 
			FROM " . DB_PREFIX . "product p 
			LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
			LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) 
			LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_category ON (product_to_category.product_id = p.product_id)
			WHERE p.status = '1' AND p.date_available <= NOW() 
			AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' 
			AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			ORDER BY p.date_added DESC LIMIT " . (int)$limit);
		 	 
			$product_data = $query->rows;

			$this->cache->set('product.latest.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $limit, $product_data);
		}
		
		return $product_data;
	}
	
	public function getPopularProducts($limit) {
		//$query = $this->db->query("SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.viewed, p.date_added DESC LIMIT " . (int)$limit);
        $query = $this->db->query("SELECT p.*, pd.description AS description, pd.meta_description AS meta_description, pd.meta_keywords AS meta_keywords, pd.name AS name, p.image, md.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.viewed, p.date_added DESC LIMIT " . (int)$limit);
                       
		 	 		
		return $query->rows;
	}
	
	public function getFeaturedProducts($limit) {
		$product_data = $this->cache->get('product.featured.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $limit);

		if (!$product_data) { 
			//$query = $this->db->query("SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product_featured f LEFT JOIN " . DB_PREFIX . "product p ON (f.product_id=p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (f.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' LIMIT " . (int)$limit);
            $query = $this->db->query("SELECT p.*, pd.description AS description, pd.meta_description AS meta_description, pd.meta_keywords AS meta_keywords, pd.name AS name, p.image, md.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);
               
	
			$product_data = $query->rows;

			$this->cache->set('product.featured.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $limit, $product_data);
		}
		
		return $product_data;
	}

	public function getBestSellerProducts($limit) {
		$product_data = $this->cache->get('product.bestseller.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $limit);

		if (!$product_data) { 
			$product_data = array();
			
			$query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) WHERE o.order_status_id > '0' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);
			
			foreach ($query->rows as $result) {
				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.product_id = '" . (int)$result['product_id'] . "' AND p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
				
				if ($product_query->num_rows) {
					$product_data[] = $product_query->row;
				}
			}

			$this->cache->set('product.bestseller.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $limit, $product_data);
		}
		
		return $product_data;
	}
		
	public function updateViewed($product_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = viewed + 1 WHERE product_id = '" . (int)$product_id . "'");
	}
	
	public function getProductOptions($product_id) {
		$product_option_data = array();
		
		$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order");
		
		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();
			
			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY sort_order asc");
			
			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value_description WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'name'                    => $product_option_value_description_query->row['name'],
         			'price'                   => $product_option_value['price'],
         			'prefix'                  => $product_option_value['prefix'],
         			'quantity'        => $product_option_value['quantity']  
				);
			}
						
			$product_option_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_description WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
						
        	$product_option_data[] = array(
        		'product_option_id' => $product_option['product_option_id'],
				'name'              => $product_option_description_query->row['name'],
				'option_value'      => $product_option_value_data,
				'sort_order'        => $product_option['sort_order']
        	);
      	}	
		
		return $product_option_data;
	}
	
		
	
	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}
	
	public function getProductTags($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_tags WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->rows;
	}
	
	public function getProductDiscount($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity = '1' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");
		
		if ($query->num_rows) {
			return $query->row['price'];
		} else {
			return FALSE;
		}
	}

	public function getProductDiscounts($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;		
	}
	
	public function getProductSpecial($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");
		
		if ($query->num_rows) {
			return $query->row['price'];
		} else {
			return FALSE;
		}
	}
	
	public function getProductSpecials($sort = 'p.sort_order', $order = 'ASC', $start = 0, $limit = 20) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}		

		$sql = "SELECT *, pd.name AS name, p.price, (SELECT ps2.price FROM " . DB_PREFIX . "product_special ps2 WHERE p.product_id = ps2.product_id AND ps2.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps2.date_start = '0000-00-00' OR ps2.date_start < NOW()) AND (ps2.date_end = '0000-00-00' OR ps2.date_end > NOW())) ORDER BY ps2.priority ASC, ps2.price ASC LIMIT 1) AS special, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating,(SELECT CASE WHEN (p1.quantity > 0 ) THEN 1 ELSE 0 END FROM " . DB_PREFIX . "product p1 WHERE p1." . DB_PREFIX . "product_id = p.product_id) as IS_STOCK FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW())AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) AND ps.product_id NOT IN (SELECT pd2.product_id FROM " . DB_PREFIX . "product_discount pd2 WHERE p.product_id = pd2.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW()))) GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.sort_order',
			'special',
			'rating',
			'p.price',
			'p.model'
		);
		
		if($this->config->get('config_order_stock') == '1'){
			$is_stock = " IS_STOCK DESC, ";
		}else{
			$is_stock = '';
		}
			
		if (in_array($sort, $sort_data)) {
			if ($sort == 'pd.name' || $sort == 'p.model') {
				$sql .= " ORDER BY $is_stock LCASE(" . $sort . ")";
			} else {
				$sql .= " ORDER BY $is_stock " . $sort;
			}
		} else {
			$sql .= " ORDER BY p.sort_order";	
		}
			
		if ($order == 'DESC') {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if ($start < 0) {
			$start = 0;
		}
		
		$sql .= " LIMIT " . (int)$start . "," . (int)$limit;

		$query = $this->db->query($sql);
		
		return $query->rows;
	}	

	public function getTotalProductSpecials() {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}		
		
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) AND ps.product_id NOT IN (SELECT pd2.product_id FROM " . DB_PREFIX . "product_discount pd2 WHERE p.product_id = pd2.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())))");
		
		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;	
		}
	}	
	
	public function getProductRelated($product_id) {
		$product_data = array();

		$product_related_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($product_related_query->rows as $result) { 
			//$product_query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.product_id = '" . (int)$result['related_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
            $product_query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, md.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.product_id = '" . (int)$result['related_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
             
			
			if ($product_query->num_rows) {
				$product_data[$result['related_id']] = $product_query->row;
			}
		}
		
		return $product_data;
	}
	
	public function getCategories($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function avise($product_id,$variacao,$email) {
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "product_avise (product_id,variacao,email) values ('".(int)$product_id."','".$variacao."','".$email."')");
	}
	
		public function getProductOtherColors($product_id) {
		$product_data = array();

		$product_related_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($product_related_query->rows as $result) { 
			//$product_query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.product_id = '" . (int)$result['related_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
            $product_query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, md.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.product_id = '" . (int)$result['related_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
             
			
			if ($product_query->num_rows) {
				$product_data[$result['related_id']] = $product_query->row;
			}
		}
		
		return $product_data;
	}
	
}
?>