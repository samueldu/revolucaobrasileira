<?php
class ModelDebateDebate extends Model {

    public function getTotalDebates($nome,$sort,$order)
{
    $sql = "select * from wallposts where origem='7'";

    $query = $this->db->query($sql);
    return $query->num_rows;

}

    public function getDebates($nome,$sort,$order,$start = 0, $limit = 20)
    {
        $sql = "select * from wallposts where origem='7'";

        if ($start < 0) {
            $start = 0;
        }

        $sql .= " LIMIT " . (int)$start . "," . (int)$limit;

        $query = $this->db->query($sql);

        //print $sql;

        return $query->rows;

        $query = $this->db->query($sql);
        return $query->num_rows;

    }

	public function getAbsurdo($product_id) {
	
	$query = $this->db->query("    select * from absurdo 
		inner join absurdo_to_categoria on absurdo_to_categoria.idAbsurdo = absurdo.id
		inner join absurdo_categoria on absurdo_categoria.language_id = '" . (int)$this->config->get('config_language_id') . "' and absurdo_to_categoria.idCategoriaAbsurdo = absurdo_categoria.idCategoria
		inner join absurdo_description on absurdo_description.language_id = '" . (int)$this->config->get('config_language_id') . "' and absurdo_description.absurdoId = absurdo.id

	where absurdo.id = '$product_id'");
	
	return $query->rows;
	
	}
	
	public function getAbsurdos() {
	
	$sql = "
		
		select * from absurdo 
		inner join absurdo_to_categoria on absurdo_to_categoria.idAbsurdo = absurdo.id
		inner join absurdo_categoria on absurdo_categoria.language_id = '" . (int)$this->config->get('config_language_id') . "' and absurdo_to_categoria.idCategoriaAbsurdo = absurdo_categoria.idCategoria
		inner join absurdo_description on absurdo_description.language_id = '" . (int)$this->config->get('config_language_id') . "' and absurdo_description.absurdoId = absurdo.id";

	$query = $this->db->query($sql);
	
	return $query->rows;
	
	}
	
	public function getAbsurdosByCategory($id) {
	
	$sql = "
		
		select * from absurdo 
		inner join absurdo_to_categoria on absurdo_to_categoria.idAbsurdo = absurdo.id and absurdo_to_categoria.idCategoriaAbsurdo = '".$id."'
		inner join absurdo_categoria on absurdo_categoria.language_id = '" . (int)$this->config->get('config_language_id') . "' and absurdo_to_categoria.idCategoriaAbsurdo = absurdo_categoria.idCategoria
		inner join absurdo_description on absurdo_description.language_id = '" . (int)$this->config->get('config_language_id') . "' and absurdo_description.absurdoId = absurdo.id";

	$query = $this->db->query($sql);
	
	return $query->rows;
	
	}
}
?>