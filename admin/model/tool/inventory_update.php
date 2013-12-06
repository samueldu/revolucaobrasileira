<?php
class ModelToolInventoryUpdate extends Model {
	public function inventory_update($column, $reference, $quantity) {
	  $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE ".$column." = '" . $reference . "'");		
		 if ($query->row['total'] != 0) {
	 $sql = "UPDATE " . DB_PREFIX . "product SET quantity = '" . $this->db->escape($quantity) . "' WHERE ".$column." = '" . $reference . "'";
	 //print $sql;
  	 $this->db->query($sql);		
		 return true; 
		 } else {
   	 return false;			
	 	 }
	}
}
?>
