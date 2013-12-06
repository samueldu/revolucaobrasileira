<?php
class ModelCheckoutShipping extends Model {

	public function ipagare()
	{
	
    	$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "ipagare_meios` WHERE status = '1' order by ordem");
			
		if ($order_query->num_rows) {
			
			foreach ($order_query->rows as $result) {
			$data[$result['id']]['nome'] = $result['nome'];
			$data[$result['id']]['convenio'] = $result['convenio'];
			$data[$result['id']]['tipo'] = $result['tipo'];
			$data[$result['id']]['numeroParcela'] = $result['numeroParcela'];         
			$data[$result['id']]['parcelaMinima'] = $result['parcelaMinima'];   
			$data[$result['id']]['texto'] = $result['texto'];   
		}
		
		return $data;
			
		}
		else
		{
			return FALSE;	
		}
	}
}
