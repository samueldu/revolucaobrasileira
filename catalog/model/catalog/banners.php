<?php
class ModelCatalogBanners extends Model {
	public function getBanners($category_id) {
	/*	$query = $this->db->query("
		SELECT * 
		FROM " . DB_PREFIX . "banners as b
		INNER JOIN " . DB_PREFIX . "bannersCategorias as ba
		ON (b.id = ba.bannerId and ba.categoriaId = '0') 
		where b.status = '1'");
		
		
		return $query->rows;
		
		*/
		
		return 1;
	}
}
?>