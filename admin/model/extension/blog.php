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
class ModelExtensionBlog extends Model {
	public function addPost($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog SET subject = '" . $data['subject'] . "', 
		content = '" . $data['content'] . "', resumo = '" . $data['resumo'] . "', author_id = '" . $data['author_id'] . "', 
		status = '" . $data['status'] . "', youtube = '" . $data['youtube'] . "', video_destaque = '" . $data['video_destaque'] . "',
		pontos = '" . $data['pontos'] . "',repasse = '" . $data['repasse'] . "', product_id = '" . $data['product_id'] . "', 
		date_modified = NOW(), date_posted = NOW()");
		
		$blog_id = $this->db->getLastId();
		
		//name = '" . $this->db->escape($value['name']) . "', 
		
		foreach ($data['blog_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_description SET post_id = '" . (int)$blog_id . "', 
				language_id = '" . (int)$language_id . "', 
				meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				description = '" . $this->db->escape($value['description']) . "'");
		}
		
		return $blog_id;
	}
	
	public function editPost($post_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET subject = '" . $data['subject'] . "', 
		content = '" . $data['content'] . "', resumo = '" . $data['resumo'] . "', status = '" . $data['status'] . "', 
		date_modified = NOW(), youtube = '" . $data['youtube'] . "', video_destaque = '" . $data['video_destaque'] . "',
		pontos = '" . $data['pontos'] . "',repasse = '" . $data['repasse'] . "', product_id = '" . $data['product_id'] . "' WHERE post_id = '$post_id'");	
		
		//name = '" . $this->db->escape($value['name']) . "', 
			
		foreach ($data['blog_description'] as $language_id => $value) {
				$this->db->query("update " . DB_PREFIX . "blog_description 
				SET 
				meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				description = '" . $this->db->escape($value['description']) . "' where post_id = '" . (int)$post_id . "' and language_id = '" . (int)$language_id . "'");
		}
	}
	
	public function deleteCategories($selected) {
		$selected_str='';
		foreach ($selected as $post_id) {
			$selected_str .= "'$post_id',";
		}
		$selected_str = substr($selected_str, 0, -1);
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog WHERE post_id IN (" . $selected_str . ")");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_description WHERE post_id IN (" . $selected_str . ")");     
	}

	public function getPost($post_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog 
		inner join blog_description on blog_description.post_id = '$post_id'
		WHERE blog.post_id = '".$post_id."'");
		 
		return $query->row;
	} 
	
	public function getPosts() {

		$post_data = array();
		
		if(isset($this->session->data['user_id_product']))
		$filter = "where product_id = '".$this->session->data['user_id_product']."'";
		else
		$filter = "";
	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog $filter ORDER BY date_posted DESC");
	
		foreach ($query->rows as $result) {
			$post_data[] = array(
				'post_id' => $result['post_id'],
				'subject' => $result['subject'],
				'status' => $result['status'],
				'date_posted' => $result['date_posted']
			);
		}	
		
		return $post_data;
	}
	public function getAuthor($user_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id  = '".$user_id."'");
		return $query->row['username'];
	} 

	public function addImage($blog_id = null, $new_image = null){
		if(!is_null($new_image)){
			if(!is_null($blog_id)){
				$result = $this->db->query("DELETE FROM " . DB_PREFIX . "blog_image WHERE blog_id = '".$blog_id."'");
			}
			$error = false;
			foreach ($new_image as $image){
				$sql = "INSERT INTO " . DB_PREFIX . "blog_image (blog_id, image) VALUES (".$blog_id.",'".$image."')";
				if(!$this->db->query($sql)){
					$error = true;
				}
			}
			return $error;
		}
	}
	
	public function getImages($post_id){
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_image WHERE blog_id = ".$post_id);
		return $result->rows;
	}
	
	public function addCategory($blog_id, $categories = null){
		if(!is_null($blog_id)){
			$result = $this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_category WHERE blog_id = '".$blog_id."'");
		}
		if(!is_null($categories)){
			$error = false;
			foreach ($categories as $category){
				$sql = "INSERT INTO " . DB_PREFIX . "blog_to_category (blog_id, category_id) VALUES (".$blog_id.",'".$category."')";
				if(!$this->db->query($sql)){
					$error = true;
				}
			}
			return $error;
		}

	}
	
	public function getCategory($post_id){
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_to_category WHERE blog_id = ".$post_id);
		return $result->rows;
	}
	
	public function getProductCategories($product_id) {
		$product_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}
	
	
	public function addUrl($post_id,$url){
		if(strlen(trim($url)) > 0){
			$this->db->query("delete from url_alias where `query` = 'blog_id=".$post_id."'");
			if($this->db->query("insert into url_alias (query,`keyword`) values ('blog_id=".$post_id."','".trim($url)."')"))
				return true;
			else 
				return false;
		}
	}
	
	public function getUrl($post_id){
		$query = $this->db->query("SELECT * FROM url_alias WHERE `query` = 'blog_id=".$post_id."'");
		return (isset($query->row['keyword']))?$query->row['keyword']:'';
	}
	
	public function getBlogDescriptions($post_id) {
		$product_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_description WHERE post_id = '" . (int)$post_id . "'");
		
		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'meta_keywords'    => $result['meta_keywords'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		
		
		return $product_description_data;
	}
}
?>