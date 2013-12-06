<?php
class ModelMateriasMaterias extends Model {

	public function getMateria($product_id) {
	
	$query = $this->db->query("select *,$product_id as materia_id from materia 
	inner join jornais  on materia.jornalId = jornais.id
	where materia.id = '$product_id'");
	
	return $query->rows;
	
	}
	
	public function getMateriaMark($product_id) {
	$query = $this->db->query("select count(*) as valor,pId from materia_mark where materia_mark.materiaId = '$product_id' group by materia_mark.pId");
	
	$return = "";

	foreach($query->rows as $key=>$value)
	{
		$return[$query->rows[$key]['pId']] = $query->rows[$key]['valor'];
	}
	
	return $return;

	}

    public function getMateriasHomeEstado($materia_id=null,$limit=5) {

        $query = $this->db->query("select *,DATE_FORMAT(materia.data, '%d') as d,materia.id as materia_id, jornais.id as jornal_id from materia
		inner join jornais  on materia.jornalId = jornais.id and jornais.nome like ('".estado_sigla." - %')
		where materia.id != '$materia_id' order by materia.data desc limit $limit");

        foreach($query->rows as $key=>$value)
        {

            $materias[$value['jornalId']][$value['materia_id']] = $value;
        }
        //2012-10-10 00:00:00
        //DATE_SUB(CURDATE(), INTERVAL 2 DAY)
        return $materias;
    }
	
	public function getMateriasHome($materia_id=null,$limit=5) {

		$query = $this->db->query("select *,DATE_FORMAT(materia.data, '%d') as d,materia.id as materia_id, jornais.id as jornal_id from materia
		inner join jornais  on materia.jornalId = jornais.id
		where materia.data >= '2012-10-10 00:00:00' and materia.id != '$materia_id' order by materia.data desc limit $limit");

        foreach($query->rows as $key=>$value)
        {

            $materias[$value['jornalId']][$value['materia_id']] = $value;
        }
        //2012-10-10 00:00:00
	    //DATE_SUB(CURDATE(), INTERVAL 2 DAY)
		return $materias;
	}
	
	public function getMateriasEssaSemana($materia_id=null,$limit=5) {
			
		$dataInicio = @date("Y-m-d", mktime(0, 0, 0, date("m"),date("d")-15,date("Y")));

		$dataFinal = @date("Y-m-d", mktime(0, 0, 0, date("m"),date("d")-7,date("Y"))); 
	
		$query = $this->db->query("select 
		materia.titulo as titulo, 
		materia.id as id, 
		SUBSTRING(materia.texto,1,200) as texto,
		DATE_FORMAT(materia.data, '%d') as d, 
		materia.id as materia_id from materia 
		inner join jornais  on materia.jornalId = jornais.id
		where materia.data between '$dataInicio' and '$dataFinal' order by materia.data desc limit $limit");
	
		return $query->rows;
	}
	
	
	
	public function getTotalMateriaByJornalId($product_id,$sort = 'p.sort_order', $order = 'ASC', $start = 0, $limit = 20) {
	
	$query = $this->db->query("select count(*) as total from materia 
	inner join jornais on jornais.id = $product_id");
	
	return $query->row['total']; 
	
	} 
	
	public function getMateriaByJornalId($product_id,$sort = 'p.sort_order', $order = 'ASC', $start = 0, $limit = 20) {
	
		$sort = "YEAR(materia.`data`)";
		$order = "desc";
		$is_stock = "";
	
		$sql = "select *,materia.id as materia_id from materia 
		inner join jornais on jornais.id = $product_id ";
	
			$sort_data = array(
			'pd.name',
			'p.sort_order',
			'special',
			'rating',
			'p.price',
			'p.model',
			'YEAR(materia.`data`)'
		);

        //$sql .= "where YEAR(materia.data) = '2012' and MONTH(materia.data) = '10'";

		if (in_array($sort, $sort_data)) {
			if ($sort == 'pd.name' || $sort == 'p.model') {
				$sql .= " ORDER BY $is_stock LCASE(" . $sort . ")";
			} else {
				$sql .= " ORDER BY $is_stock " . $sort;
			}
		} else {
			$sql .= " ORDER BY $is_stock p.sort_order";    
		}
			
		if ($order == 'DESC') {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if ($start < 0) {
			$start = 0;
		}
		
		$sql .= " LIMIT " . (int)$start . "," . (int)$limit;

	$query = $this->db->query($sql);
	
	return $query->rows;
	
	}
	
	public function getAbsurdos() {
	
	$query = $this->db->query("select * from absurdo 
	left join absurdo_categoria on absurdo_categoria.language_id = '" . (int)$this->config->get('config_language_id') . "'
	inner join absurdo_description on absurdo_description.language_id = '" . (int)$this->config->get('config_language_id') . "' and 
	absurdo_description.absurdoId = absurdo.id");
	
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
	
	public function getFrases()
	{
		$resultxxx = $mysqli->query("select * from materia limit 1");
		{
			while ($row = $resultxxx->fetch_object()) {
			 
				$names = $this->getNames($row->texto);
				
				$frases[$row->id]['texto'] = $row->texto;
				$frases[$row->id]['nomes'] = $names['nomes'];
				$frases[$row->id]['siglas'] = $names['siglas'];
				
				$frases[$row->id] = $this->insertTags($frases[$row->id]);                        
			}
		}
		
		return $frases;
	}
	
	public  function insertTags($dados)
	{
	
		foreach($dados['nomes'] as $key=>$value)
		{
		
		    $value = $dados['nomes'][$key]['nome'];

			$sql = "select * from politicos where politicos.nome like '%".$value."%' or politicos.apelido like '%".$value."%'";

			$result = $this->db->query($sql);

			if($result->num_rows > 0)
			{
				$dados['nomes'][$key]['politicoId'] = $result->row['id'];
			}
			else
			{
				$result = $this->db->query("select * from poderes where poderes.nome like '%$value%'");
				if($result->num_rows>0)
				{
					$dados['nomes'][$key]['poderesId'] = $result->row['id'];
				}
				else
				{
					$result = $this->db->query("select * from governadores where governadores.nome like '%$value%'");
					if($result->num_rows>0)
					{
						$dados['nomes'][$key]['governadoresId'] = $result->row['id'];
					}
				}
			}
		}
				
		foreach($dados['siglas'] as $key=>$value)
		{
		
		$value = trim($dados['siglas'][$key]['nome']);

		$result = $this->db->query("select * from partido where partido.partidoNome = '".$value."' limit 1");
		
			if($result->num_rows>0)
			{
				$dados['siglas'][$key]['partidoId'] = $result->row['partidoId'];
                $dados['siglas'][$key]['desc'] = $result->row['partidoDescricao'];
			}
			else
			{

				$sql = "select * from siglas where siglas.sigla like '%".$value."%'";    

				$result = $this->db->query($sql);
						
				if($result->num_rows > 0)
				{
					$dados['siglas'][$key]['id'] = $result->row['id'];
                    $dados['siglas'][$key]['desc'] = $result->row['explicacao'];
				}
			}
		}

		return $dados;
	}
	
	
}
?>