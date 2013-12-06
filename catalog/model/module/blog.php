<?php
#############################################################################
#  Module Blog & News for Opencart 1.4.x From Team SiamOpencart.com		  													       #
#  เว็บผู้พัฒนา www.siamopencart.com ,www.thaiopencart.com                                                                                 #
#  โดย Somsak2004 วันที่ 13 กุมภาพันธ์ 2553                                                                                                            #
#############################################################################
# โดยการสนับสนุนจาก                                                                                                                                            #
# Unitedsme.com : ผู้ให้บริการเช่าพื้นที่เว็บไซต์ จดโดเมน ระบบ Linux                                                                              #
# Net-LifeStyle.com : ผู้ให้บริการเช่าพื้นที่เว็บไซต์์ จดโดเมน ระบบ Linux																           #
# SiamWebThai.com : SEO ขั้นเทพ โปรโมทเว็บขั้นเซียน ออกแบบ พัฒนาเว็บไซต์ / ตามความต้องการ และถูกใจ Google 		   #
#############################################################################
class ModelModuleBlog extends Model {
	
	public function getPosts($blog_id = null, $limit = null, $category_id = null, $tipo = null, $count = null,$product_id = null) {

		$post_data = array();
		$where = null;
		$wlimit = null;
		$wtable = null;
		$wCategory = null;
		
		if(!is_null($blog_id)){
			$where = 'AND b.post_id = '.$blog_id;
		}else{
			$where = 'AND b.video_destaque = false';
		}
		
		if(!is_null($tipo)){
			$where .= " AND b.".$tipo." = 1 ";
		}
		
		if(!is_null($limit)){
			if(is_array($limit)){
				$wlimit = "LIMIT ".$limit[0].",".$limit[1];
			}else{
				$wlimit = "LIMIT ".$limit;
			} 
		}
		if(!is_null($category_id)){
			$wCategory = "AND btc.blog_id = b.post_id
						  AND btc.category_id = ".$category_id;
			$wtable = ", ".DB_PREFIX . "blog_to_category btc";
		}
		
		//print $product_id;
		
		if(!is_null($product_id)){
			$wCategory .= " AND b.product_id = '".$product_id."'";
		}
		
		$query = "
		SELECT * 
		FROM " . DB_PREFIX . "blog as b,
		" . DB_PREFIX . "user u
		" . $wtable . "
		WHERE b.author_id = u.user_id 
		AND b.status = 'published' ".$where."
		" . $wCategory . "
		ORDER BY date_posted DESC ".$wlimit;
		
		//print $query;

		$query = $this->db->query($query);
		
		if($count == true){
			return count($query->rows);
		}
		
		foreach ($query->rows as $result) {
			
			$sql = "select * from blog_description where blog_description.post_id = '".$result['post_id']."' and blog_description.language_id = '2'";
			
			$queryx = $this->db->query($sql);    
			
			$result2 = $queryx->rows;
			
			if(!isset($result2[0]['title']))
			$result2[0]['title'] = "";
			
			if(!isset($result2[0]['meta_description']))
			$result2[0]['meta_description'] = "";
			
			if(!isset($result2[0]['meta_keywords']))
			$result2[0]['meta_keywords'] = "";
			
			//print_r($result2 );   
			
			$post_data[] = array(
				'post_id' => $result['post_id'],
				'subject' => $result['subject'],
				'title' => $result2[0]['title'],
				'product_id' => $result['product_id'],  
				'content' => htmlspecialchars_decode($result['content']),
				'resumo' => htmlspecialchars_decode($result['resumo']),
				'status' => $result['status'],
				'date_posted' => date('F j, Y, g:i a', strtotime($result['date_posted'])),
				'author' => $result['firstname'],
				'youtube' => $result['youtube'],
				'meta_title' =>$result2[0]['title'],
				'meta_description'=> $result2[0]['meta_description'],
				'meta_keywords'=> $result2[0]['meta_keywords']
				
			);
		}
		
			
		
		//print_r($post_data);
		
		return $post_data;
	}
	
		public function getNoticiasHome($blog_id = null, $limit = null, $category_id = null, $tipo = null, $count = null) {

		$post_data = array();
		$where = null;
		$wlimit = null;
		$wtable = null;
		$wCategory = null;
		
		if(!is_null($blog_id)){
			$where = 'AND b.post_id = '.$blog_id;
		}else{
			$where = 'AND b.video_destaque = false';
		}
		
		if(!is_null($tipo)){
			$where .= " AND b.".$tipo." = 1 ";
		}
		
		if(!is_null($limit)){
			if(is_array($limit)){
				$wlimit = "LIMIT ".$limit[0].",".$limit[1];
			}else{
				$wlimit = "LIMIT ".$limit;
			} 
		}
		if(!is_null($category_id)){
			$wCategory = "AND btc.blog_id = b.post_id
						  AND btc.category_id = ".$category_id;
			$wtable = ", ".DB_PREFIX . "blog_to_category btc";
		}
		$query = "
		SELECT * 
		FROM " . DB_PREFIX . "blog as b,
		" . DB_PREFIX . "user u
		" . $wtable . "
		WHERE b.author_id = u.user_id 
		AND product_id IS NOT NULL
		AND b.status = 'published' ".$where."
		" . $wCategory . "
		ORDER BY date_posted DESC ".$wlimit;

		$query = $this->db->query($query);
		
		if($count == true){
			return count($query->rows);
		}
		
		foreach ($query->rows as $result) {
			
			$sql = "select * from blog_description where blog_description.post_id = '".$result['post_id']."' and blog_description.language_id = '2'";
			
			$queryx = $this->db->query($sql);    
			
			$result2 = $queryx->rows;  		
			
			$sqlx = "select image from product where product.product_id = '".$result['product_id']."' limit 1";
			
			$queryxx = $this->db->query($sqlx);    
			
			$result2x = $queryxx->row;
			
			if(!isset($result2[0]['title']))
			$result2[0]['title'] = "";
			
			if(!isset($result2[0]['meta_description']))
			$result2[0]['meta_description'] = "";
			
			if(!isset($result2[0]['meta_keywords']))
			$result2[0]['meta_keywords'] = "";
			
			//print_r($result2 );   
			
			$post_data[] = array(
				'post_id' => $result['post_id'],
				'subject' => $result['subject'],
				'content' => htmlspecialchars_decode($result['content']),
				'resumo' => htmlspecialchars_decode($result['resumo']),
				'status' => $result['status'],
				'date_posted' => date('F j, Y, g:i a', strtotime($result['date_posted'])),
				'author' => $result['firstname'],
				'youtube' => $result['youtube'],
				'meta_title' =>$result2[0]['title'],
				'meta_description'=> $result2[0]['meta_description'],
				'meta_keywords'=> $result2[0]['meta_keywords'],
				'product_id'=> $result['product_id'],
				'image'=>$result2x
			);
		}    
		
		//print_r($post_data);
		
		return $post_data;
	}
	
	public function getImages($post_id){
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_image WHERE blog_id = ".$post_id);
		return $result->rows;
	}
	
	public function getVideosDestaque($limit = null){
		$wlimit = null;
		if(!is_null($limit)){
			$wlimit = "LIMIT ".$limit; 
		}
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog WHERE video_destaque = 1 ORDER BY date_posted DESC ".$wlimit);
		return $result->rows;
	}
	
		
	public function getFranquiaByNoticia($limit = null){
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog WHERE video_destaque = 1 ORDER BY date_posted DESC ".$wlimit);
		return $result->rows;
	}
}
?>