<?php
final class Customer {
	private $customer_id ='0';
	private $firstname;
	private $lastname;
	private $email;
	private $telephone;
	private $fax;
	private $newsletter;
	
	// alteracoes
	
	private $dataNasc;
	private $sexo;
	private $rg;
	private $cpfCnpj;
	
	private $customer_group_id;
	private $address_id;
	
	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
				
		if (isset($this->session->data['customer_id'])) { 
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND status = '1'");
			
			if ($customer_query->num_rows) {
				$this->customer_id = $customer_query->row['customer_id'];
				$this->firstname = $customer_query->row['firstname'];
				$this->lastname = $customer_query->row['lastname'];
				$this->email = $customer_query->row['email'];
				$this->telephone = $customer_query->row['telephone'];
				$this->fax = $customer_query->row['fax'];
				
				$this->dataNasc = $customer_query->row['dataNasc'];
				$this->sexo = $customer_query->row['sexo'];
				$this->rg = $customer_query->row['rg'];
				$this->cpfCnpj = $customer_query->row['cpfCnpj'];
				
				$this->newsletter = $customer_query->row['newsletter'];
				$this->customer_group_id = $customer_query->row['customer_group_id'];
				$this->address_id = $customer_query->row['address_id'];
							
				//$this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(serialize($this->session->data['cart'])) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "'");
			} else {
				$this->logout();
			}
		}
	}
		
	public function login($email, $password,$uid=null,$facebook=null) {
		if (!$this->config->get('config_customer_approval')) {

            if(!is_null($uid))
            {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE twitter_id = '".$uid."'");
            }
            elseif(!is_null($facebook))
            {
                $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE facebook_id = '".$facebook."'");
        }
            else
            {
            $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "' AND password = '" . $this->db->escape(md5($password)) . "' AND status = '1'");
                }

        } else {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "' AND password = '" . $this->db->escape(md5($password)) . "' AND status = '1' AND approved = '1'");
		}
		
		if ($customer_query->num_rows) {
			$this->session->data['customer_id'] = $customer_query->row['customer_id'];	
			
			if (($customer_query->row['cart']) && (is_string($customer_query->row['cart']))) {
				$cart = unserialize($customer_query->row['cart']);
				
				foreach ($cart as $key => $value) {
					if (!array_key_exists($key, $this->session->data['cart'])) {
						$this->session->data['cart'][$key] = $value;
					} else {
						$this->session->data['cart'][$key] += $value;
					}
				}			
			}
			
			$like_to_politico = $this->db->query("SELECT * FROM " . DB_PREFIX . "like_to_politico 
			WHERE userId = '" . $this->session->data['customer_id'] . "'");
			
			foreach($like_to_politico->rows as $key=>$value)
			{
				$this->session->data['votos']['like']['politico'][$like_to_politico->rows[$key]['politicoId']] = $like_to_politico->rows[$key]['politicoId'];
			}
			
			
			$like_to_materia = $this->db->query("SELECT * FROM " . DB_PREFIX . "like_to_materia 
			WHERE userId = '" . $this->session->data['customer_id'] . "'");
			
			foreach($like_to_materia->rows as $key=>$value)
			{
				$this->session->data['votos']['like']['materia'][$like_to_materia->rows[$key]['materiaId']] = $like_to_materia->rows[$key]['materiaId'];
			}
			
			$like_to_casa = $this->db->query("SELECT * FROM " . DB_PREFIX . "like_to_casa 
			WHERE userId = '" . $this->session->data['customer_id'] . "'");
			
			foreach($like_to_casa->rows as $key=>$value)
			{
				$this->session->data['votos']['like']['casa'][$like_to_casa->rows[$key]['casaId']] = $like_to_casa->rows[$key]['casaId'];
			}


			$deslike_to_politico = $this->db->query("SELECT * FROM " . DB_PREFIX . "deslike_to_politico 
			WHERE userId = '" . $this->session->data['customer_id'] . "'");
			
			foreach($deslike_to_politico->rows as $key=>$value)
			{
				$this->session->data['votos']['deslike']['politico'][$deslike_to_politico->rows[$key]['politicoId']] = $deslike_to_politico->rows[$key]['politicoId'];
			}
			
			$deslike_to_materia = $this->db->query("SELECT * FROM " . DB_PREFIX . "deslike_to_materia 
			WHERE userId = '" . $this->session->data['customer_id'] . "'");
			
			foreach($deslike_to_materia->rows as $key=>$value)
			{
				$this->session->data['votos']['deslike']['materia'][$deslike_to_materia->rows[$key]['materiaId']] = $deslike_to_materia->rows[$key]['materiaId'];
			}
			
			$deslike_to_casa = $this->db->query("SELECT * FROM " . DB_PREFIX . "deslike_to_casa 
			WHERE userId = '" . $this->session->data['customer_id'] . "'");
			
			foreach($deslike_to_casa->rows as $key=>$value)
			{
				$this->session->data['votos']['like']['casa'][$deslike_to_casa->rows[$key]['casaId']] = $deslike_to_casa->rows[$key]['casaId'];
			}
			
			
			$this->customer_id = $customer_query->row['customer_id'];
			$this->firstname = $customer_query->row['firstname'];
			$this->lastname = $customer_query->row['lastname'];
			$this->email = $customer_query->row['email'];
			$this->telephone = $customer_query->row['telephone'];
			$this->fax = $customer_query->row['fax'];
			
			$this->session->data['customer_name'] = $this->firstname." ".$this->lastname;
			
			$this->dataNasc = $customer_query->row['dataNasc'];
			$this->sexo = $customer_query->row['sexo'];
			$this->rg = $customer_query->row['rg'];
			$this->cpfCnpj = $customer_query->row['cpfCnpj'];
			
			$this->newsletter = $customer_query->row['newsletter'];
			$this->customer_group_id = $customer_query->row['customer_group_id'];
			$this->address_id = $customer_query->row['address_id'];
			
			/* modificacoes para funcionamento da wall*/
			
			$mem_email       = $email;
			$id             = $customer_query->row['customer_id'];
			$username        = $customer_query->row['firstname'];
			$mem_fname       = $customer_query->row['firstname'];
			$mem_lname       = $customer_query->row['lastname'];
			$mem_pic       = '';
			$gender       = $customer_query->row['sexo'];

			$this->session->data['id_user']  = $id;

			setcookie("username", $username);

			setcookie("mem_id", $id);

			$this->session->data['username'] = $username;
			$this->session->data['mem_email']     = $mem_email;
			$this->session->data['mem_fname']  = $mem_fname;
			$this->session->data['mem_lname']  = $mem_lname;
			$this->session->data['gender']      = $gender;
			$this->session->data['mem_pic']     = $mem_pic;
			$this->session->data['wall_login'] = 1;
			
	  
			return TRUE;
		} else {
			return FALSE;
		}
	}
  
	public function logout() {
		unset($this->session->data['customer_id']);

		$this->customer_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
		
		$this->dataNasc = '';
		$this->sexo = '';
		$this->rg = '';
		$this->cpfCnpj = '';
		
		$this->newsletter = '';
		$this->customer_group_id = '';
		$this->address_id = '';

        session_destroy();

        setcookie(session_name(), '', time() - 3600);
        setcookie("facebookAccessToken", '', time() - 3600);
        //PHPSESSID
    }
  
	public function isLogged() {
		return $this->customer_id;
	}

	public function getId() {
		return $this->customer_id;
	}
	  
	public function getFirstName() {
		return $this->firstname;
	}
  
	public function getLastName() {
		return $this->lastname;
	}
  
	public function getEmail() {
		return $this->email;
	}
  
	public function getTelephone() {
		return $this->telephone;
	}
  
	public function getFax() {
		return $this->fax;
	}
	
	public function getDataNasc() {
		return $this->dataNasc;
	}
	
	public function getSexo() {
		return $this->sexo;
	}

	public function getRg() {
		return $this->rg;
	}

	public function getCpfCnpj() {
		return $this->cpfCnpj;
	}  	
	
	public function getNewsletter() {
		return $this->newsletter;	
	}

	public function getCustomerGroupId() {
		return $this->customer_group_id;	
	}
	
	public function getAddressId() {
		return $this->address_id;	
	}
}
?>