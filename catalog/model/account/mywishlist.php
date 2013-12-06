<?php
class ModelAccountMywishlist extends Model {
	public function addMywishlist($data) {
		$query = $this->db->query("select null from " . DB_PREFIX . "mywishlist where member_id = '" . (int)$this->customer->getId() . "' and product_id = '" . $this->db->escape($data['id']) . "'");
		if( count($query->rows) > 0 ){
		}else{
			$this->db->query("INSERT INTO " . DB_PREFIX . "mywishlist SET 
			member_id = '" . (int)$this->customer->getId() . "', 
			product_id = '" . $this->db->escape($data['id']) . "', 
			dtadd = NOW()
			");
			
			$id = $this->db->getLastId();
			//$this->data['text_error'] = $this->language->get('text_success');
			return $id;
		}
	}
	
	public function deleteMywishlist($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "mywishlist WHERE id = '" . (int)$id . "' AND member_id = '" . (int)$this->customer->getId() . "'");
	}	
	
	public function getMywishlists() {
		$list_data = array();
		if(isset($this->request->get['memid'])){
			$custid = $this->request->get['memid'];
		}else{
			$custid = $this->customer->getId();
		}
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "mywishlist WHERE member_id = '" . (int)$custid . "'");
	
		foreach ($query->rows as $result) {
		
			$list_data[] = array(
				'id'     => $result['id'],
				'product_id'      => $result['product_id'],
				'member_id'       => $result['member_id'],
				'dtadd'        => $result['dtadd']
			);
		}		
		
		return $list_data;
	}	
	
}
?>