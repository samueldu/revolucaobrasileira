<?php
class ModelPoliticoPoderes extends Model {

	public function getPoder($product_id) {
	
	$query = $this->db->query("select * from poderes
		where poderes.id = '".$product_id."'");
	
	return $query->rows;
	
	}
	
	public function getCasas() {
	
	$query = $this->db->query("select * from casa");
	
	return $query->rows;
	
	}
	
	public function getCasaDados($product_id) {
	
	$query = $this->db->query("select *,casa.casaNome from casa 
	inner join casa_description on casa_description.idCasa = '".$product_id."' and casa.casaId = '".$product_id."'");
	
	return $query->rows;
	
	}
	
	public function getCasaBadges($id)
	{
	
		$sql = utf8_encode("
		select * from casa_description where 
		(descricao = 'Projetos de lei e outras matérias' or 
		descricao='Assiduidade (plenário)'
		or descricao='Assiduidade (comissões)'
		or descricao='Uso de verbas \"indenizatórias\"'
		or descricao='Viagens') and idCasa = '$id' and (valor = 'Não' or valor = 'Precário')");
	
		$query = $this->db->query($sql); 

		/*Projetos de lei e outras matérias Sim
		Assiduidade (plenário) Precário
		Assiduidade (comissões) Não
		Uso de verbas "indenizatórias" Sim
		Viagens Não     */
		
		return $query->rows; 
	
	}
	
	public function getPoliticos($partidoId=null,$casaId=null,$ufId=null,$sort = 'politicos.nome', $order = 'ASC', $start = 0, $limit = 20) {
	
	$casaAdd = "";
	$partidoAdd = "";  
	$ufAdd = "";   
	
	if(!is_null($partidoId))
	{
		$partidoAdd = " and partido.partidoId  = '".$partidoId."' ";
	}
	
	if(!is_null($casaId))
	{
		$casaAdd = " and politicos.casaId = '".$casaId."'";
	}
	
	if(!is_null($ufId))
	{
		$ufAdd = " and politicos.ufId = '".$ufId."'";
	}
	
	$sql = "select * from politicos 
		inner join partido on partido.partidoId = politicos.partidoId $partidoAdd
		inner join casa on casa.casaId = politicos.casaId $casaAdd
		inner join uf on uf.uf_codigo = politicos.ufId $ufAdd";

	$sql .= " ORDER BY $sort";    
	
	if ($order == 'DESC') {
		$sql .= " DESC";
	} else {
		$sql .= " ASC";
	}

	if ($start < 0) {
	$start = 0;
	}
		
	$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
	
	//print $sql;
	
	$query = $this->db->query($sql);
	
	return $query->rows;
	
	}
	
	public function getTotalPoliticos($partidoId=null,$casaId=null,$ufId=null,$sort = 'politicos.nome', $order = 'ASC') {
	
	$casaAdd = "";
	$partidoAdd = "";  
	$ufAdd = "";   
	
	if(!is_null($partidoId))
	{
		$partidoAdd = " and partido.partidoId  = '".$partidoId."' ";
	}
	
	if(!is_null($casaId))
	{
		$casaAdd = " and politicos.casaId = '".$casaId."'";
	}
	
	if(!is_null($ufId))
	{
		$ufAdd = " and politicos.ufId = '".$ufId."'";
	}
	
	$sql = "select * from politicos 
		inner join partido on partido.partidoId = politicos.partidoId $partidoAdd
		inner join casa on casa.casaId = politicos.casaId $casaAdd
		inner join uf on uf.uf_codigo = politicos.ufId $ufAdd";

	$sql .= " ORDER BY $sort";    
	
	if ($order == 'DESC') {
		$sql .= " DESC";
	} else {
		$sql .= " ASC";
	}
	
	$query = $this->db->query($sql);
	
	return $query->num_rows;
	
	}
	
	public function getPoliticoPartido($product_id) {
	
	$sql = "select * from partido
		where partido.partidoId = '".$product_id."'";

	$query = $this->db->query($sql);
	
	return $query->rows;
	
	}
	
	public function getPoliticoBens($product_id,$ano) {
	
	$sql = "select * from bens
		where bens.idPolitico = '".$product_id."' and ano = '$ano' ORDER BY `like` desc, valor desc";

	$query = $this->db->query($sql);
	
	return $query->rows;
	
	}
	
	public function getPoliticoProcessos($product_id) {
	
	$sql = "select * from processos
		where processos.idPolitico = '".$product_id."'";

	$query = $this->db->query($sql);
	
	return $query->rows;
	
	}
	
	public function getPoliticoVerbas($product_id,$ano) {
	
	$sql = "select * from verbas
		where verbas.idPolitico ='$product_id' and ano = '$ano' order by verba desc";

	$query = $this->db->query($sql);
	
	return $query->rows;
	
	}
	
	public function getPoliticoMaterias($product_id,$ano=null,$partidoId=null,$tentativa=1) {
	
	$nomeBack = trim($product_id);
	
	$palavras = explode(" ",$product_id);
	
	$nome = '\'+"'.$palavras[0].'"';
	
	if(isset($palavras[1]))
	{
		foreach($palavras as $key=>$value)
		{
			if($key > 0)
			$nome .= ' +"'.$palavras[$key].'"'; 
			
		}
		
		$nome .= '\'';    
		
	
	}
	else
	{
		$nome .= '\'';	
	}
	
	$add = "";
	
	if(!is_null($ano))
	$add = "and YEAR(data) = '".$ano."'";
	
	$addPartido = ""; 
	
	if(!is_null($partidoId))
	$addPartido = "inner join materia_partido on materia_partido.idPartido = '".$partidoId."'";
	
	$product_id = $nome;
	
	$sql = "SELECT materia.data,
	materia.titulo,
	materia.id,
	jornais.nome, 
	MATCH(texto,titulo,autor) AGAINST (".$product_id.") as score
	FROM materia 
	INNER JOIN jornais on materia.jornalId = jornais.id  
	WHERE 
	MATCH(texto,titulo,autor) AGAINST (".$product_id.") $add $addPartido
	order by score desc limit 10";
	 
	$query = $this->db->query($sql);
	
	//print $query->num_rows ;
	
	if($query->num_rows == 0){
	
		$tentativa = $tentativa+1;
		if($tentativa > 3)
		$this->getPoliticoMaterias($nomeBack,$ano-1);
		else
		return false;
	}
	else
	{
	return $query->rows;
	}
	
	}
	
	public function getPoliticoCorrupcao($product_id) {
	
	//print $product_id;
	
	$query = $this->db->query("select * from corrupcao 
	inner join corrupcao_description on corrupcao_description.language_id = '" . (int)$this->config->get('config_language_id') . "' and 
	corrupcao_description.corrupcaoId = corrupcao.id
	inner join politico_to_corrupcao on politico_to_corrupcao.corrupcaoId = corrupcao.id and politico_to_corrupcao.politicoId = '$product_id'"); 
	
	//print_r($query->rows);
	
	return $query->rows;
	
	}
	
	public function getPoliticoFrases($product_id) {
	
	//print $product_id;
	
	$query = $this->db->query("select * from frases
	left join corrupcao on corrupcao.id = frases.corrupcaoId  
	where frases.politicoId = '$product_id' order by frases.`like`"); 
	
	//print_r($query->rows);
	
	return $query->rows;
	
	}
	
	public function getPartidos() {
	
	$query = $this->db->query("select * from partido"); 
	
	return $query->rows;
	
	}
}
?>