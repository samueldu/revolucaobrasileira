<?php
class ModelAccountCustomer extends Model {
	public function addCustomer($data) {
		
		$dataXau = $data['dataNasc'];
  		$data_nova = implode(preg_match("~\/~", $dataXau) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $dataXau) == 0 ? "-" : "/", $dataXau)));

        if(!isset($data['twitter_id']))
            $data['twitter_id'] = "";

        if(!isset($data['facebook_id']))
            $data['facebook_id'] = "";


        if(isset($data['address_1']))
        {

            $this->db->query("
            INSERT INTO " . DB_PREFIX . "address
            SET
            customer_id = '',
            firstname = '" . $this->db->escape($data['firstname']) . "',
            lastname = '" . $this->db->escape($data['lastname']) . "',
            company = '" . $this->db->escape($data['company']) . "',
            address_1 = '" . $this->db->escape($data['address_1']) . "',
            address_2 = '" . $this->db->escape($data['address_3']) . "',
            address_3 = '" . $this->db->escape($data['address_2']) . "',
            bairro = '" . $this->db->escape($data['bairro']) . "',
            city = '" . $this->db->escape($data['city']) . "',
            postcode = '" . $this->db->escape($data['postcode']) . "',
            country_id = '" . (int)$data['country_id'] . "',
            zone_id = '" . (int)$data['zone_id'] . "'");

            $address_id = $this->db->getLastId();
        }
        else
            $address_id = "";

      	$this->db->query("
      	INSERT INTO " . DB_PREFIX . "customer 
      	SET     
      	address_id = '".$address_id."',          
      	store_id = '" . (int)$this->config->get('config_store_id') . "', 
      	firstname = '" . $this->db->escape($data['firstname']) . "', 
      	lastname = '" . $this->db->escape($data['lastname']) . "', 
      	email = '" . $this->db->escape($data['email']) . "', 
      	telephone = '" . $this->db->escape($data['telephone']) . "', 
      	fax = '" . $this->db->escape($data['fax']) . "', 
      	password = '" . $this->db->escape(md5($data['password'])) . "', 
      	newsletter = '" . (int)$data['newsletter'] . "', 
      	customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "', 
      	status = '1', 
      	date_added = NOW(), 
      	cpfCnpj = '" . $this->db->escape($data['cpfCnpj']) . "', 
      	rg = '" . $this->db->escape($data['rg']) . "', 
      	sexo = '" . $this->db->escape($data['sexo']) . "', 
      	dataNasc = '".$data_nova."',
      	twitter_id = '" . $this->db->escape($data['twitter_id']) . "',
      	facebook_id = '" . $this->db->escape($data['facebook_id']) . "'");
      	
      	$customer_id = $this->db->getLastId();    

      	$this->db->query("UPDATE " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "' where address_id = '" . (int)$address_id . "'");
		
		if (!$this->config->get('config_customer_approval')) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET approved = '1' WHERE customer_id = '" . (int)$customer_id . "'");
		}		
	}
	
	public function editCustomer($data) {
		$this->db->query("
		UPDATE " . DB_PREFIX . "customer 
		SET 
		firstname = '" . $this->db->escape($data['firstname']) . "', 
		lastname = '" . $this->db->escape($data['lastname']) . "', 
		email = '" . $this->db->escape($data['email']) . "', 
		telephone = '" . $this->db->escape($data['telephone']) . "',
		dataNasc = '" . $this->db->escape($data['dataNasc']) . "',  
		cpfCnpj = '" . $this->db->escape($data['cpfCnpj']) . "',  
		rg = '" . $this->db->escape($data['rg']) . "',  
		fax = '" . $this->db->escape($data['fax']) . "' 
		WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}

	public function editPassword($email, $password) {
      	$this->db->query("UPDATE " . DB_PREFIX . "customer SET password = '" . $this->db->escape(md5($password)) . "' WHERE email = '" . $this->db->escape($email) . "'");
	}

	public function editNewsletter($newsletter) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}
			
	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		     
		return $query->row;
	} 
	
	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($email) . "'");
		return $query->row['total'];
	}
}
?>