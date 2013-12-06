<?php
class ModelSaleOrderNew extends Model {
	public function getAddress($address_id) {
		$address_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$address_id . "'");
		
		if ($address_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$address_query->row['country_id'] . "'");
			
			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';	
				$address_format = '';
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$code = $zone_query->row['code'];
			} else {
				$zone = '';
				$code = '';
			}		
			
			$address_data = array(
				'firstname'      => $address_query->row['firstname'],
				'lastname'       => $address_query->row['lastname'],
				'company'        => $address_query->row['company'],
				'address_1'      => $address_query->row['address_1'],
				'address_2'      => $address_query->row['address_2'],
				'postcode'       => $address_query->row['postcode'],
				'city'           => $address_query->row['city'],
				'zone_id'        => $address_query->row['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $code,
				'country_id'     => $address_query->row['country_id'],
				'country'        => $country,	
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format
			);
			
			return $address_data;
		} else {
			return FALSE;	
		}
	}
	
	public function getLanguageByCode($code) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "language WHERE code = '" . $code . "'");
	
		return $query->row;
	}
	
	public function getCurrencyByCode($code) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "currency WHERE code = '" . $code. "'");
	
		return $query->row;
	}
	
	function getExtensions($type) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "'");

		return $query->rows;
	}
	
	public function createNewOrder($data) {
		$query = $this->db->query("SELECT order_id FROM `" . DB_PREFIX . "order` WHERE date_added < '" . date('Y-m-d', strtotime('-1 month')) . "' AND order_status_id = '0'");
		
		foreach ($query->rows as $result) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$result['order_id'] . "'");
      		$this->db->query("DELETE FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$result['order_id'] . "'");
      		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$result['order_id'] . "'");
      		$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$result['order_id'] . "'");
	  		$this->db->query("DELETE FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$result['order_id'] . "'");
      		$this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$result['order_id'] . "'");
		}		
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET 
			  store_id = '" . (int)$data['store_id'] . "'
			, store_name = '" . $this->db->escape($data['store_name']) . "'
			, store_url = '" . $this->db->escape($data['store_url']) . "'
			, customer_id = '" . (int)$data['customer_id'] . "'
			, customer_group_id = '" . (int)$data['customer_group_id'] . "'
			, firstname = '" . $this->db->escape($data['firstname']) . "'
			, lastname = '" . $this->db->escape($data['lastname']) . "'
			, email = '" . $this->db->escape($data['email']) . "'
			, telephone = '" . $this->db->escape($data['telephone']) . "'
			, fax = '" . $this->db->escape($data['fax']) . "'
			, total = '" . (float)$data['total'] . "'
			, language_id = '" . (int)$data['language_id'] . "'
			, currency = '" . $this->db->escape($data['currency']) . "'
			, currency_id = '" . (int)$data['currency_id'] . "'
			, value = '" . (float)$data['value'] . "'
			, coupon_id = '" . (int)$data['coupon_id'] . "'
			, ip = '" . $this->db->escape($data['ip']) . "'
			, shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "'
			, shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "'
			, shipping_company = '" . $this->db->escape($data['shipping_company']) . "'
			, shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "'
			, shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "'
			, shipping_city = '" . $this->db->escape($data['shipping_city']) . "'
			, shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "'
			, shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "'
			, shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "'
			, shipping_country = '" . $this->db->escape($data['shipping_country']) . "'
			, shipping_country_id = '" . (int)$data['shipping_country_id'] . "'
			, shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "'
			, shipping_method = '" . $this->db->escape($data['shipping_method']) . "'
			, payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "'
			, payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "'
			, payment_company = '" . $this->db->escape($data['payment_company']) . "'
			, payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "'
			, payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "'
			, payment_city = '" . $this->db->escape($data['payment_city']) . "'
			, payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "'
			, payment_zone = '" . $this->db->escape($data['payment_zone']) . "'
			, payment_zone_id = '" . (int)$data['payment_zone_id'] . "'
			, payment_country = '" . $this->db->escape($data['payment_country']) . "'
			, payment_country_id = '" . (int)$data['payment_country_id'] . "'
			, payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "'
			, payment_method = '" . $this->db->escape($data['payment_method']) . "'
			, comment = '" . $this->db->escape($data['comment']) . "'
			, order_status_id = '" . $this->db->escape($data['order_status_id']) . "'
			, date_modified = NOW()
			, date_added = NOW()");

		$order_id = $this->db->getLastId();

		foreach ($data['products'] as $product) { 
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "order_product SET 
						  order_id = '" . (int)$order_id . "'
						, product_id = '" . (int)$product['product_id'] . "'
						, name = '" . $this->db->escape($product['name']) . "'
						, model = '" . $this->db->escape($product['model']) . "'
						, price = '" . (float)$product['price'] . "'
						, total = '" . (float)$product['total'] . "'
						, tax = '" . (float)$product['tax'] . "'
						, quantity = '" . (int)$product['quantity'] . "'");
			
			$order_product_id = $this->db->getLastId();

			if($data['config_stock_checkout'] == false)
			{
				$this->db->query("
					UPDATE " . DB_PREFIX . "product SET 
							   quantity = (quantity - " . (int)$product['quantity'] . ") 
					WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");
			}
			
			
			foreach ($product['options'] as $option) {
				$this->db->query("
					INSERT INTO " . DB_PREFIX . "order_option SET 
						  order_id = '" . (int)$order_id . "'
						, order_product_id = '" . (int)$order_product_id . "'
						, product_option_value_id = '" . (int)$option['product_option_value_id'] . "'
						, name = '" . $this->db->escape($option['name']) . "'
						, `value` = '" . $this->db->escape($option['value']) . "'
						, price = '" . (float)$product['price'] . "'
						, prefix = '" . $this->db->escape($option['prefix']) . "'");
				
				if($data['config_stock_checkout'] == false)
				{
					$this->db->query("
						UPDATE " . DB_PREFIX . "product_option_value SET 
							  quantity = (quantity - " . (int)$product['quantity'] . ") 
						WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' 
								AND subtract = '1'");	
				}
				
			}
				
			foreach ($product['download'] as $download) {
				$this->db->query("
					INSERT INTO " . DB_PREFIX . "order_download SET 
						  order_id = '" . (int)$order_id . "'
						, order_product_id = '" . (int)$order_product_id . "'
						, name = '" . $this->db->escape($download['name']) . "'
						, filename = '" . $this->db->escape($download['filename']) . "'
						, mask = '" . $this->db->escape($download['mask']) . "'
						, remaining = '" . (int)($download['remaining'] * $product['quantity']) . "'");
			}	
		}
		
		foreach ($data['totals'] as $total) {
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "order_total SET 
					  order_id = '" . (int)$order_id . "'
					, title = '" . $this->db->escape($total['title']) . "'
					, text = '" . $this->db->escape($total['text']) . "'
					, `value` = '" . (float)$total['value'] . "'
					, sort_order = '" . (int)$total['sort_order'] . "'");
		}	

		return $order_id;
	}
}
?>
