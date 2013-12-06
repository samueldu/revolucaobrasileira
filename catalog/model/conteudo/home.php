<?
    class ModelConteudoHome extends Model {

    public function getFrase() {

    $query = $this->db->query("select * from frases_inicio where `status` = '1' order by rand() limit 1");

    return $query->row;

    }
    }
?>