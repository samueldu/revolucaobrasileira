<?php
class ModelAccountWall extends Model {
	public function getWallName($id) {
	
		$order_query = $this->db->query("SELECT firstname,lastname,facebook_id from `" . DB_PREFIX . "customer` WHERE customer_id = '" . $id . "'");
	
		return $order_query->row;  
	}

    public function getPendingFriends($id) {

        $order_query = $this->db->query("SELECT *,customer.firstname from cometchat_friends
        inner join customer on customer.customer_id = cometchat_friends.toid
        WHERE cometchat_friends.fromid = '" . $id . "' and cometchat_friends.confirm = '0'");

        return $order_query->rows;
    }
    
        public function getMyPendingFriends($id) {

        $order_query = $this->db->query("SELECT *,customer.firstname from cometchat_friends
        inner join customer on customer.customer_id = cometchat_friends.toid
        WHERE cometchat_friends.toid = '" . $id . "' and cometchat_friends.confirm = '0'");

        return $order_query->rows;
    }

    public function getFriendship($id) {

        $order_query = $this->db->query("SELECT * FROM cometchat_friends
        WHERE cometchat_friends.toid = '" . $this->customer->getId() . "' and cometchat_friends.fromid = '" . $id . "'");

        if($order_query->num_rows>0 and $order_query->row['confirm'] == "0")
        {
            $data['confirm'] = "A";
        }
        elseif($order_query->num_rows>0 and $order_query->row['confirm'] == "1")
        {
            $data['confirm'] = "1";
        }
        elseif($order_query->num_rows==0)
        {
            $data['confirm'] = "0";
        }

        return $data;
    }
    
        public function getFriends($id) {

        $order_query = $this->db->query("SELECT * FROM cometchat_friends
        LEFT JOIN customer on (customer.customer_id = cometchat_friends.fromid)
        WHERE (cometchat_friends.toid = '" . $id . "')");

        return $order_query->rows;
    }
    
    
    public function makeFriends($id,$id2) {

        $order_query = $this->db->query("update cometchat_friends set cometchat_friends.confirm='1' where (cometchat_friends.toid = '" . $id . "' and cometchat_friends.fromid = '" . $id2 . "')");
        $order_query = $this->db->query("update cometchat_friends set cometchat_friends.confirm='1' where (cometchat_friends.toid = '" . $id2 . "' and cometchat_friends.fromid = '" . $id . "')");

    }
}
?>