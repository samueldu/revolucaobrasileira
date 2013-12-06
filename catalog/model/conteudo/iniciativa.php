<?php
class ModelConteudoIniciativa extends Model {

	public function getAbsurdo($product_id) {
	
	$query = $this->db->query("select iniciativa_description.nome,iniciativa_description.descricao from iniciativa
	inner join iniciativa_description on iniciativa_description.language_id = '" . (int)$this->config->get('config_language_id') . "' and
	iniciativa_description.iniciativaId = iniciativa.id
	where iniciativa.id = '$product_id'");
	
	return $query->rows;
	
	}

    public function getVideos($id)
    {
        $query = $this->db->query("select * from video where origem = 'causas' and idOrigem = '$id' ORDER BY ordem ASC");
        return $query->rows;
    }
	
	public function getAbsurdos() {
	
	$query = $this->db->query("select * from iniciativa
	inner join iniciativa_description on iniciativa_description.language_id = '" . (int)$this->config->get('config_language_id') . "' and
	iniciativa_description.iniciativaId = iniciativa.id");
	
	return $query->rows;
	
	}
	
	public function getPoliticoProcessos($product_id) {
	
	$sql = "select * from processos
		where processos.idPolitico = '".$product_id."' group by codigoSistema";

	$query = $this->db->query($sql);
	
	return $query->rows;
	
	}
	
	public function getPoliticoVerbas($product_id,$ano) {
	
	$sql = "select * from verbas
		where verbas.idPolitico ='$product_id' and ano = '$ano'";

	$query = $this->db->query($sql);
	
	return $query->rows;
	
	}
	
}
?>