<?
class ModelAjaxAjax extends Model {

	public function mark($data)
	{
		$this->db->query("
		INSERT INTO " . DB_PREFIX . "materia_mark 
		SET 
		pId = '".$data['pId']."', 
		materiaId = '".$data['materia_id']."', 
		userId = '".$data['userId']."',
		data = NOW()"); 
	}

	public function like($data) {
	
	GLOBAL $_SESSION;
	
	if($data['action'] == "like")
	{
		$action = "+";
		$name = "like"; 
		$_SESSION['votos']['like'][$data['page']][$data['id']] = $data['id'];
	} 
	elseif($data['action'] == "unlike")
	{
		$action = "-"; 
		$name = "like"; 
		unset($_SESSION['votos']['like'][$data['page']][$data['id']]);	
	}
	elseif($data['action'] == "deslike")
	{
		$action = "+";
		$name = "deslike"; 
		$_SESSION['votos']['deslike'][$data['page']][$data['id']] = $data['id'];    
	}
	elseif($data['action'] == "undeslike")
	{
		$action = "-"; 
		$name = "deslike"; 
		unset($_SESSION['votos']['deslike'][$data['page']][$data['id']]);  
	}
	
	if($data['page'] == "casa")
	{
	
		if($data['action'] == "like")
		{
			$this->db->query("
			INSERT INTO " . DB_PREFIX . "like_to_casa 
			SET 
			casaId = '".$data['id']."', 
			userId = '".$data['userId']."',
			data = NOW()"); 
		}
		
		if($data['action'] == "unlike")
		{
			$this->db->query("
			delete from " . DB_PREFIX . "like_to_casa 
			where 
			casaId = '".$data['id']."' and 
			userId = '".$data['userId']."'"); 
		}
		
		if($data['action'] == "deslike")
		{
			$this->db->query("
			INSERT INTO " . DB_PREFIX . "deslike_to_casa 
			SET 
			casaId = '".$data['id']."', 
			userId = '".$data['userId']."',
			data = NOW()"); 
		}
		
		if($data['action'] == "undeslike")
		{
			$this->db->query("
			delete from " . DB_PREFIX . "deslike_to_casa 
			where 
			casaId = '".$data['id']."' and 
			userId = '".$data['userId']."'");  
		}
		
		$this->db->query("
		update " . DB_PREFIX . "casa 
		SET 
		`$name` = `$name` ".$action." 1 
		where casaId =  '".$data['id']."'");   
	}

	if($data['page'] == "politico")
	{
	
		if($data['action'] == "like")
		{
			$this->db->query("
			INSERT INTO " . DB_PREFIX . "like_to_politico 
			SET 
			politicoId = '".$data['id']."', 
			userId = '".$data['userId']."',
			data = NOW()"); 
		}
		
		if($data['action'] == "unlike")
		{
			$this->db->query("
			delete from " . DB_PREFIX . "like_to_politico 
			where 
			politicoId = '".$data['id']."' and 
			userId = '".$data['userId']."'"); 
		}
		
		if($data['action'] == "deslike")
		{
			$this->db->query("
			INSERT INTO " . DB_PREFIX . "deslike_to_politico 
			SET 
			politicoId = '".$data['id']."', 
			userId = '".$data['userId']."',
			data = NOW()"); 
		}
		
		if($data['action'] == "undeslike")
		{
			$this->db->query("
			delete from " . DB_PREFIX . "deslike_to_politico 
			where 
			politicoId = '".$data['id']."' and 
			userId = '".$data['userId']."'");  
		}
		
		$this->db->query("
		update " . DB_PREFIX . "politicos 
		SET 
		`$name` = `$name` ".$action." 1 
		where id =  '".$data['id']."'");   
		
		$address_id = $this->db->getLastId();
	}
	
	if($data['page'] == "materia")
	{
	
		if($data['action'] == "like")
		{
			$this->db->query("
			INSERT INTO " . DB_PREFIX . "like_to_materia 
			SET 
			materiaId = '".$data['id']."', 
			userId = '".$data['userId']."',
			data = NOW()"); 
		}
		
		if($data['action'] == "unlike")
		{
			$this->db->query("
			delete from " . DB_PREFIX . "like_to_materia 
			where 
			materiaId = '".$data['id']."' and 
			userId = '".$data['userId']."'"); 
		}
		
		if($data['action'] == "deslike")
		{
			$this->db->query("
			INSERT INTO " . DB_PREFIX . "deslike_to_materia 
			SET 
			materiaId = '".$data['id']."', 
			userId = '".$data['userId']."',
			data = NOW()"); 
		}
		
		if($data['action'] == "undeslike")
		{
			$this->db->query("
			delete from " . DB_PREFIX . "deslike_to_materia 
			where 
			materiaId = '".$data['id']."' and 
			userId = '".$data['userId']."'");  
		}
		
		$this->db->query("
		update " . DB_PREFIX . "materia 
		SET 
		`$name` = `$name` ".$action." 1 
		where id =  '".$data['id']."'");   
		
		$address_id = $this->db->getLastId();
	}
	
	}
	
	public function mandaMsgPolitico($data)
	{
		$this->db->query("
		INSERT INTO " . DB_PREFIX . "message_to_politico 
		SET 
		politicoId = '".$data['politicoId']."', 
		msg = '".$data['msg']."', 
		userId = '".$data['userId']."',
		email = '".$data['email']."', 
		politicoEmail = '".$data['politicoEmail']."',  
		data = NOW()"); 
	}
	
	public function gravaPost($data)
	{



        $this->db->query("
        INSERT INTO " . DB_PREFIX . "wallposts 
        SET 
        description = '".$data['texto']."', 
        post = '".$data['titulo']."', 
        origem = '7',
        posted_by = '".$_SESSION['customer_id']."',
                userid = '".$_SESSION['customer_id']."',
        date_created = '".strtotime(date("Y-m-d H:i:s"))."'");

		foreach($data['categorias'] as $key=>$value)
		{
			
		}
	}


}