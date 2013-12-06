<?php
class ModelCatalogBanner extends Model {
	public function addProduct($data) {
	
	$dataXau = $data['dataInicio'];
  	$data['dataInicio'] = implode(preg_match("~\/~", $dataXau) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $dataXau) == 0 ? "-" : "/", $dataXau)));
  	
  	$dataXau = $data['dataFim'];
  	$data['dataFim'] = implode(preg_match("~\/~", $dataXau) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $dataXau) == 0 ? "-" : "/", $dataXau)));
	
        $this->db->query("
		INSERT INTO " . DB_PREFIX . "banner SET 
		posicao = '" . $data['model'] . "', 
   	    status = '" . (int)$data['status'] . "', 
   	    dataInicio = '" . $data['dataInicio'] . "', 
   	    dataFim = '" . $data['dataFim'] . "', 
   	    url = '" . $data['url'] . "',
    	urlImg = '" . $data['product_image'][0] . "',  
    	nome = '" . $data['name'] . "',  
   	    sort_order = '" . (int)$data['sort_order'] . "'");
		
		$product_id = $this->db->getLastId();
		
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "bannerCategoria SET bannerId = '" . (int)$product_id . "', categoriaId = '" . (int)$category_id . "'");
			}
		}

	}
	
	public function editProduct($product_id, $data) {
	
		$dataXau = $data['dataInicio'];
  	$data['dataInicio'] = implode(preg_match("~\/~", $dataXau) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $dataXau) == 0 ? "-" : "/", $dataXau)));
  	
  	$dataXau = $data['dataFim'];
  	$data['dataFim'] = implode(preg_match("~\/~", $dataXau) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $dataXau) == 0 ? "-" : "/", $dataXau)));

	
		$this->db->query("UPDATE " . DB_PREFIX . "banner  SET 
		posicao = '" . $data['model'] . "', 
   	    status = '" . (int)$data['status'] . "', 
   	    dataInicio = '" . $data['dataInicio'] . "', 
   	    dataFim = '" . $data['dataFim'] . "', 
   	    url = '" . $data['url'] . "',
    	urlImg = '" . $data['product_image'][0] . "',  
    	nome = '" . $data['name'] . "',  
   	    sort_order = '" . (int)$data['sort_order'] . "' 
   	    WHERE id = '" . (int)$product_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "bannerCategoria WHERE bannerId = '" . (int)$product_id . "'");
		
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "bannerCategoria SET bannerId = '" . (int)$product_id . "', categoriaId = '" . (int)$category_id . "'");
			}		
		}

	}
	
	public function copyProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data = array_merge($data, array('product_description' => $this->getProductDescriptions($product_id)));
			$data = array_merge($data, array('product_option' => $this->getProductOptions($product_id)));
						
			$data['keyword'] = '';
						
			$data['product_image'] = array();
			
			$results = $this->getProductImages($product_id);
			
			foreach ($results as $result) {
				$data['product_image'][] = $result['image'];
			}
			
			$data = array_merge($data, array('product_discount' => $this->getProductDiscounts($product_id)));
			$data = array_merge($data, array('product_special' => $this->getProductSpecials($product_id)));
			$data = array_merge($data, array('product_download' => $this->getProductDownloads($product_id)));
			$data = array_merge($data, array('product_category' => $this->getProductCategories($product_id)));
			$data = array_merge($data, array('product_store' => $this->getProductStores($product_id)));
			$data = array_merge($data, array('product_related' => $this->getProductRelated($product_id)));
			$data = array_merge($data, array('product_tags' => $this->getProductTags($product_id)));
			
			$this->addProduct($data);
		}
	}
	
	public function deleteProduct($product_id) {
	    $this->db->query("DELETE FROM " . DB_PREFIX . "bannerCategoria WHERE bannerId = '" . (int)$product_id . "'");   
		$this->db->query("DELETE FROM " . DB_PREFIX . "banner WHERE id = '" . (int)$product_id . "'");
     		
		$this->cache->delete('product');
	}
	
	public function getProduct($product_id) {
		$query = $this->db->query("select * FROM " . DB_PREFIX . "banner WHERE id = '" . (int)$product_id . "'");
				
		return $query->row;
	}
	
	public function getProducts($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "banner b 
			WHERE b.id > 0 "; 
		
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$sql .= " AND LCASE(b.nome) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
			}

			if (isset($data['filter_model']) && !is_null($data['filter_model'])) {
				$sql .= " AND LCASE(b.posicao) LIKE '%" . $this->db->escape(strtolower($data['filter_model'])) . "%'";
			}
					
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND b.status = '" . (int)$data['filter_status'] . "'";
			}

			$sort_data = array(
				'b.nome',
				'b.posicao',
				'b.status',
				'b.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY b.nome";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	

			$query = $this->db->query($sql);
		
			return $query->rows;
		} 
	}

	public function addFeatured($data) {
      	$this->db->query("DELETE FROM " . DB_PREFIX . "product_featured");
      	
		if (isset($data['product_featured'])) {
      		foreach ($data['product_featured'] as $product_id) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "product_featured SET product_id = '" . (int)$product_id . "'");
      		}			
		}
	}
	
	public function getFeaturedProducts() {
		$product_featured_data = array();
		
		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_featured");		
		
		foreach ($query->rows as $result) {
			$product_featured_data[] = $result['product_id'];
		}
		return $product_featured_data;
	}
	
	public function getProductsByKeyword($keyword) {
		if ($keyword) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND (LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($keyword)) . "%' OR LCASE(p.model) LIKE '%" . $this->db->escape(strtolower($keyword)) . "%')");
									  
			return $query->rows;
		} else {
			return array();	
		}		
	} 
	
	public function getProductsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");
								  
		return $query->rows;
	} 
	
	public function getProductDescriptions($product_id) {
		$product_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_keywords'    => $result['meta_keywords'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $product_description_data;
	}

	public function getProductOptions($product_id) {
		$product_option_data = array();
		
		$product_option = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order");
		
		foreach ($product_option->rows as $product_option) {
			$product_option_value_data = array();
			
			$product_option_value = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY sort_order");
			
			foreach ($product_option_value->rows as $product_option_value) {
				$product_option_value_description_data = array();
				
				$product_option_value_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value_description WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");

				foreach ($product_option_value_description->rows as $result) {
					$product_option_value_description_data[$result['language_id']] = array('name' => $result['name']);
				}
			
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'language'                => $product_option_value_description_data,
         			'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
         			'prefix'                  => $product_option_value['prefix'],
					'sort_order'              => $product_option_value['sort_order']
				);
			}
			
			$product_option_description_data = array();
			
			$product_option_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_description WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");

			foreach ($product_option_description->rows as $result) {
				$product_option_description_data[$result['language_id']] = array('name' => $result['name']);
			}
		
        	$product_option_data[] = array(
        		'product_option_id'    => $product_option['product_option_id'],
				'language'             => $product_option_description_data,
				'product_option_value' => $product_option_value_data,
				'sort_order'           => $product_option['sort_order']
        	);
      	}	
		
		return $product_option_data;
	}
	
	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT urlImg FROM " . DB_PREFIX . "banner WHERE id = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");
		
		return $query->rows;
	}
	
	public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");
		
		return $query->rows;
	}
	
	public function getProductDownloads($product_id) {
		$product_download_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_download_data[] = $result['download_id'];
		}
		
		return $product_download_data;
	}

	public function getProductStores($product_id) {
		$product_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_store_data[] = $result['store_id'];
		}
		
		return $product_store_data;
	}
	
	public function getProductCategories($product_id) {
		$product_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bannerCategoria WHERE bannerId = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_category_data[] = $result['categoriaId'];
		}

		return $product_category_data;
	}

	public function getProductRelated($product_id) {
		$product_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}
		
		return $product_related_data;
	}
	
	public function getProductTags($product_id) {
		$product_tag_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_tags WHERE product_id = '" . (int)$product_id . "'");
		
		$tag_data = array();
		
		foreach ($query->rows as $result) {
			$tag_data[$result['language_id']][] = $result['tag'];
		}
		
		foreach ($tag_data as $language => $tags) {
			$product_tag_data[$language] = implode(',', $tags);
		}
		
		return $product_tag_data;
	}
	
	public function getTotalProducts($data = array()) {
		$sql = "SELECT count(*) as total FROM " . DB_PREFIX . "banner b 
			WHERE b.id >= '0'";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$sql .= " AND LCASE(b.nome) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
		}

		if (isset($data['filter_model']) && !is_null($data['filter_model'])) {
			$sql .= " AND LCASE(b.posicao) LIKE '%" . $this->db->escape(strtolower($data['filter_model'])) . "%'";
		}
			
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND b.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
	
	public function getTotalProductsByStockStatusId($stock_status_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE image_id = '" . (int)$image_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByTaxClassId($tax_class_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByWeightClassId($weight_class_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByLengthClassId($length_class_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByOptionId($option_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByDownloadId($download_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalProductsByManufacturerId($manufacturer_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}
}
?>