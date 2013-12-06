<?php
class ModelPoliticoPolitico extends Model {

    public function getRank($rank) {
        if($rank == "verbas")
        {
            $query = $this->db->query("select * from politicos
            inner join partido on partido.partidoId = politicos.partidoId
            where badgeVerbas != '0'
            order by badgeVerbas asc limit 100");
        }
        elseif($rank == "processos")
        {
            $query = $this->db->query("select * from politicos
            inner join partido on partido.partidoId = politicos.partidoId
            where badgeProcessos != ''
            order by badgeProcessos asc limit 100");
        }
        elseif($rank == "bens")
        {
            $query = $this->db->query("select * from politicos
            inner join partido on partido.partidoId = politicos.partidoId
            where badgeBens != ''
            order by badgeBens asc limit 100");
        }
        elseif($rank == "like")
        {
            $query = $this->db->query("select * from politicos
            inner join partido on partido.partidoId = politicos.partidoId
            order by `like` desc limit 100");
        }
        elseif($rank == "deslike")
        {
            $query = $this->db->query("select * from politicos
            inner join partido on partido.partidoId = politicos.partidoId
            order by `deslike` desc limit 100");
        }
        elseif($rank == "corrupcao")
        {
            $query = $this->db->query("select count(*) as valor,partido.partidoNome,politicos.nome,politicos.apelido,idSystem as id, politicos.avatar,politicos.politicoCargoRelevante,politicos.politicoOutrosDados  from corrupcao_personagens
            inner join politicos on politicos.id = idSystem
            inner join partido on partido.partidoId = politicos.partidoId
            where idSystem != '' and tipo = 'politico'
            group by idSystem order by valor desc limit 100");
        }
        elseif($rank == "transparencia")
        {
            $query = $this->db->query("select * from transparencia inner join uf on uf.uf_codigo = transparencia.idUf order by rank desc");
        }


        return $query->rows;
    }

	public function getPoliticosLandPage() {

        $query = $this->db->query("select rank.`data`, casa.casaNome,casa.casaId, rank.rank as posicao, rank_description.rankDescription as rank, politicos.* from politicos
inner join rank on politicos.id = rank.idPolitico
inner join rank_description on rank.idRank = rank_description.id
inner join casa on casa.casaId = rank.idCasa
where rank.idCasa = '2' and rank.rank < '5'
group by politicos.id,rank.id
order by rank.`data` desc,rank.rank ASC limit 15");

        foreach($query->rows as $key=>$value)
        {

            $retorno['Senado Federal'][$value['rank']][$value['id']] = $value;
        }

        $query = $this->db->query("select rank.`data`, casa.casaNome,casa.casaId, rank.rank as posicao, rank_description.rankDescription as rank, politicos.* from politicos
inner join rank on politicos.id = rank.idPolitico
inner join rank_description on rank.idRank = rank_description.id
inner join casa on casa.casaId = rank.idCasa
where rank.idCasa = '1' and rank.rank <= '5'
group by politicos.id
order by rank.`data` desc,rank.rank ASC limit 15");

        foreach($query->rows as $key=>$value)
        {

            $retorno['Câmara dos Deputados'][$value['rank']][$value['id']] = $value;
        }


        $query = $this->db->query("select casa.casaNome as casaNome,  rank.`data`,casa.casaId, rank.rank as posicao, rank_description.rankDescription as rank, politicos.* from politicos
inner join rank on politicos.id = rank.idPolitico
inner join rank_description on rank.idRank = rank_description.id
inner join casa on casa.casaId = rank.idCasa
where casa.casaUf = '".estado_sigla."' and rank.rank <= '5'
group by politicos.id
order by rank.`data` desc,rank.rank ASC limit 15");

        foreach($query->rows as $key=>$value)
        {

            $retorno[$value['casaNome']][$value['rank']][$value['id']] = $value;
        }

        /*

		$query = $this->db->query("select * from politicos
		where badgeVerbas != '0'
		order by badgeVerbas asc limit 5");
		
		$retorno['verbas'] = $query->rows;
		
		$query = $this->db->query("select * from politicos
		where badgeProcessos != ''
		order by badgeProcessos asc limit 5");
		
		$retorno['processos'] = $query->rows;
		
		$query = $this->db->query("select * from politicos
		where badgeBens != ''
		order by badgeBens asc limit 5");
		
		$retorno['bens'] = $query->rows;
		
		$query = $this->db->query("select * from politicos

		order by `like` desc limit 5");
		
		$retorno['like'] = $query->rows;
		
		$query = $this->db->query("select * from politicos 
		order by `deslike` desc limit 5");
		
		$retorno['deslike'] = $query->rows;

        $query = $this->db->query("select count(*) as valor,politicos.apelido,corrupcao_personagens.nome,idSystem as id,politicos.avatar as avatar
        from corrupcao_personagens
        inner join politicos on politicos.id = corrupcao_personagens.idSystem
		where idSystem != '' and tipo = 'politico'
		group by idSystem order by valor desc limit 5");

        $retorno['corrupcao'] = $query->rows;
		
		//$query = $this->db->query("select * from casa where casaId IN ('1','2','3','29','30') order by rand() limit 1");
		
		$retorno['casa'] = $query->rows;

        */
	
		return $retorno;
	}

    public function getPoliticosLandPageEstado() {

        $query = $this->db->query("select * from politicos
		where badgeVerbas != '0'
		order by badgeVerbas asc limit 10");

        $retorno['verbas'] = $query->rows;

        $query = $this->db->query("select * from politicos
		where badgeProcessos != ''
		order by badgeProcessos asc limit 5");

        $retorno['processos'] = $query->rows;

        $query = $this->db->query("select * from politicos
		where badgeBens != ''
		order by badgeBens asc limit 5");

        $retorno['bens'] = $query->rows;

        $query = $this->db->query("select * from politicos

		order by `like` desc limit 5");

        $retorno['like'] = $query->rows;

        $query = $this->db->query("select * from politicos
		order by `deslike` desc limit 5");

        $retorno['deslike'] = $query->rows;

        $query = $this->db->query("select count(*) as valor,corrupcao_personagens.nome,idSystem as id,politicos.avatar as avatar
        from corrupcao_personagens
        inner join politicos on politicos.id = corrupcao_personagens.idSystem
		where idSystem != '' and tipo = 'politico'
		group by idSystem order by valor desc limit 5");

        $retorno['corrupcao'] = $query->rows;

        $query = $this->db->query("select * from casa where casaId IN ('1','2','3','29','30') order by rand() limit 1");

        $retorno['casa'] = $query->rows;

        return $retorno;
    }

    public function getVotos($product_id) {

        $query = $this->db->query("select * from voto_to_politico
		inner join voto on voto.id = voto_to_politico.idVoto
		where voto_to_politico.idPolitico = '".$product_id."'");

        return $query->rows;

    }

	public function getPolitico($product_id) {
	
	$query = $this->db->query("select * from politicos
		inner join partido on partido.partidoId = politicos.partidoId
		inner join casa on casa.casaId = politicos.casaId
		inner join uf on uf.uf_codigo = politicos.ufId
		left join politico_to_bancada on politicos.id = politico_to_bancada.politicoId
		where politicos.id = '".$product_id."'");

	return $query->rows;
	
	}

    public function getPoliticoBancada($product_id) {

        $query = $this->db->query("select * from politico_to_bancada where politicoId = '".$product_id."'");
        return (array)$query->rows;

    }

    public function getBancada() {

        $query = $this->db->query("
        select * from bancada
        INNER JOIN bancada_descricao on bancada_descricao.id_language = '" . (int)$this->config->get('config_language_id') . "' and bancada.id = bancada_descricao.id_bancada");

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
	
	public function getCasaBadges($id) {
	
		$sql = utf8_encode("
		select * from casa_description where 
		(descricao = 'Projetos de lei e outras matérias' or
		descricao='Assiduidade (plenário)'
		or descricao='Assiduidade (comissões)'
		or descricao='Uso de verbas \"indenizatórias\"'
		or descricao='Viagens') and idCasa = '$id' and (valor = 'Não' or valor = 'Precário')");
	
		$query = $this->db->query($sql); 

		/*Projetos de lei e outras mat�rias Sim
		Assiduidade (plen�rio) Prec�rio
		Assiduidade (comiss�es) N�o
		Uso de verbas "indenizat�rias" Sim
		Viagens N�o     */
		
		return $query->rows; 
	
	}
	
	public function getPoliticos($nome=null,$partidoId=null,$casaId=null,$ufId=null,$sort = 'politicos.nome', $order = 'ASC', $start = 0, $limit = 20, $bancada=null) {

    $nomeAdd = "1=1";
	$casaAdd = "";
	$partidoAdd = "";  
	$ufAdd = "";
    $bancadaAdd = "";
        $and = "";

    if(!is_null($nome))
    {
        $nomeAdd = " politicos.nome like '%".$nome."%' or politicos.apelido like '%".$nome."%' ";
    }
	
	if(!is_null($partidoId))
	{
		$partidoAdd = "and partido.partidoId  = '".$partidoId."' ";
	}
	
	if(!is_null($casaId))
	{
		$casaAdd = " and politicos.casaId = '".$casaId."'";
	}
	
	if(!is_null($ufId))
	{
		$ufAdd = " and politicos.ufId = '".$ufId."'";
	}

    if(!is_null($bancada))
    {
        $bancadaAdd = " politico_to_bancada.idGrupo = '".$bancada."'";
        $and = "and";
    }

	$sql = "select * from politicos  
		inner join partido on partido.partidoId = politicos.partidoId $partidoAdd
		inner join casa on casa.casaId = politicos.casaId $casaAdd
		inner join uf on uf.uf_codigo = politicos.ufId $ufAdd";

    if(!is_null($bancada))
    $sql .= "inner join politico_to_bancada on politico_to_bancada.politicoId = politicos.id";

	$sql .= " where $nomeAdd $and $bancadaAdd and status = '1' ORDER BY $sort";
	
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

    //print $sql;
	
	return $query->rows;
	
	}
	
	public function getTotalPoliticos($nome=null,$partidoId=null,$casaId=null,$ufId=null,$sort = 'politicos.nome', $order = 'ASC') {
	
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

        $sql .= " where politicos.nome like '%".$nome."%' or politicos.apelido like '%".$nome."%' and status = '1'  ORDER BY $sort";
	
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

       // debug($query->rows);
	
	return $query->rows;
	
	}
	
	public function getPoliticoVerbas($product_id,$ano=null,$casa) {
        if($casa == "1" or $casa == "2")
        {
	
	$sql = "select sum(verba) as verba, ano, mes from verbas
		    where verbas.idPolitico ='$product_id' and (ano = '2011'or ano = '2012' or ano = '2013') group by ano, mes order by ano,mes";

        /*    $sql = "select ano,SUM(verbas_por_ano.verba) as  verba,'1' as mes,descricao
        from verbas_por_ano
       where verbas_por_ano.idPolitico = '".$product_id."'
        group by ano,descricao";*/

        }
        else
        {

            $sql = "select ano,SUM(verbas_por_ano.verba) as  verba,'1' as mes,descricao
        from verbas_por_ano
       where verbas_por_ano.idPolitico = '".$product_id."'
        group by ano,descricao";
        }

        $query = $this->db->query($sql);


	return $query->rows;
	
	}

    public function getPoliticoVerbasAPI($product_id,$ano=null,$casa) {
        if($casa == "1" or $casa == "2")
        {

            $sql = "select verba, ano, mes,descricao from verbas
		    where verbas.idPolitico ='$product_id' and (ano = '2011'or ano = '2012' or ano = '2013') order by ano,mes";

            $query = $this->db->query($sql);
        }
        else
        {

            $sql = "select ano, verba,'1' as mes,descricao
        from verbas_por_ano
       where verbas_por_ano.idPolitico = '".$product_id."'";

            $query = $this->db->query($sql);

        }

        return $query->rows;

    }

    public function getPoliticoMediaVerbas($casa) {

        if($casa != "1" and $casa != "2")
        {

            $sql = "select ano,(SUM(verbas_por_ano.verba)/count(distinct verbas_por_ano.idPolitico)) as verba,count(*)as total
        from verbas_por_ano
        inner join politicos on politicos.casaId = '".$casa."' and verbas_por_ano.idPolitico = politicos.id and (ano = '2011'or ano = '2012' or ano = '2013')
        group by ano";

        }
        else
        {

            $sql = "select ano,mes,(SUM(verbas.verba)/count(distinct verbas.idPolitico)) as verba,count(*)as total
        from verbas
        inner join politicos on politicos.casaId = '".$casa."' and verbas.idPolitico = politicos.id and (ano = '2011'or ano = '2012' or ano = '2013')
        group by ano,mes";

        }

        $query = $this->db->query($sql);

        return $query->rows;

    }


    public function getMediaVerbasDivulgacao() {

        $sql = "select ano,SUM(verbas.verba) as soma,politicos.casaId,casa.casaNome,(SUM(verbas.verba)/count(distinct verbas.idPolitico)) as verba,count(*)as total
        from verbas
        inner join politicos on verbas.idPolitico = politicos.id and (ano = '2011'or ano = '2012' or ano = '2013')
        inner join casa on politicos.casaId = casa.casaId
        where verbas.descricao like '%divulgação%' or  verbas.descricao like '%propaganda%' group by ano";

        $query = $this->db->query($sql);

        debug($query->rows);

        return $query->rows;

    }

    public function mediaVerbas() {

        $sql = "select sum(verbas.verba)as total, verbas.descricao,verbas.ano from verbas
        inner join politicos on politicos.id = verbas.idPolitico
        inner join casa on casa.casaId = politicos.casaId
        where  (politicos.casaId = '1' or  politicos.casaId = '2')  and (verbas.ano = '2010' or verbas.ano = '2011' or verbas.ano= '2012' or verbas.ano = '2013')
        group by ano,verbas.descricao";

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
	MATCH(texto,titulo,autor) AGAINST (".$product_id."  IN BOOLEAN MODE) as score
	FROM materia 
	INNER JOIN jornais on materia.jornalId = jornais.id  
	WHERE 
	MATCH(texto,titulo,autor) AGAINST (".$product_id."  IN BOOLEAN MODE) $add $addPartido
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
	inner join corrupcao_personagens on corrupcao_personagens.corrupcaoId = corrupcao.id and corrupcao_personagens.idSystem = '$product_id' and tipo ='politico' and revisado = '1'"); 
	
	//print_r($query->rows);
	
	return $query->rows;
	
	}

    public function getPoliticoAssiduidade($product_id) {

        $sql = "select * from assiduidade
		where assiduidade.idPolitico ='".$product_id."'";

        $query = $this->db->query($sql);

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

    public function getFotos($id) {

    $query = $this->db->query("select * from album inner join album_foto on album_foto.albumId = album.id where album.politicoId = '".$id."' and album.tipo = 'p' order by album_foto.ordem");

        if($query->num_rows == 0){
            $query = $this->db->query("select avatar as filename from politicos where id = '".$id."'");
        }

    return $query->rows;

    }

    public function getPoliticoTransparencia($uf) {

            $transparencia = $this->cache->get('politico.transparencia.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $uf);

            if (!$transparencia) {

                $query = $this->db->query("select * from transparencia where idUf = '".$uf."'");

                $transparencia = $query->rows;

                $this->cache->set('politico.transparencia.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $uf, $transparencia);
            }

            return $transparencia;
        }
    }
?>