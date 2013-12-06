<?php
class ModelConteudoCorrupcao extends Model {

    public function getRankCorrupcao()
    {
            $query = $this->db->query("
            select SUM(peso) as valor, politico_to_bancada.idGrupo as idBancada, uf.uf_sigla as estado, politico_to_bancada.grupo as bancada, politicos.nome,politicos.id as id,politicos.apelido,politicos.avatar,idSystem as id, partido.partidoNome,politicos.politicoCargoRelevante,politicos.politicoOutrosDados,politicos.badgeProcessos as processos,politicos.badgeBens as bens
            from corrupcao_personagens
            inner join politicos on politicos.id = corrupcao_personagens.idSystem
            inner join partido on partido.partidoId = politicos.partidoId
		    inner join casa on casa.casaId = politicos.casaId
		    inner join uf on uf.uf_codigo = politicos.ufId
		    inner join corrupcao on corrupcao_personagens.corrupcaoId = corrupcao.id
		    left join politico_to_bancada on politico_to_bancada.politicoId = politicos.id
            where idSystem != '' and tipo = 'politico'
            group by idSystem order by valor desc limit 50");

            $corrupcao = $query->rows;

            foreach($corrupcao as $key=>$value)
            {
                $select = $this->db->query("select
                                            corrupcao.id,
                                            corrupcao.data,
                                            corrupcao_description.corrupcaoTitulo,
                                            corrupcao.peso
                                            from corrupcao
                                            inner join corrupcao_description on corrupcao_description.corrupcaoId = corrupcao.id and corrupcao_description.language_id = '" . (int)$this->config->get('config_language_id') . "'
                                            inner join corrupcao_personagens on corrupcao_personagens.idSystem = '".$value['id']."' and corrupcao.id = corrupcao_personagens.corrupcaoId");

                $return[$key] = $corrupcao[$key];
                $return[$key]['casos'] = $select->rows;

            }

        //debug($return);

        return $return;
    }

    public function getRankFrases()
    {
        $query = $this->db->query("SELECT * from (select * from frases as f order by deslike limit 10) T ORDER BY RAND() LIMIT 3");

        return $query->rows;
    }

	public function getCorrupcaobyId($product_id) {
	
        $query = $this->db->query("select
        corrupcao.id,
        corrupcao.data,
        corrupcao_description.corrupcaoTitulo,
        corrupcao_description.corrupcaoDescription
        from corrupcao
        inner join corrupcao_description on corrupcao_description.corrupcaoId = corrupcao.id and corrupcao_description.language_id = '" . (int)$this->config->get('config_language_id') . "'
        where corrupcao.id = '".$product_id."'");

        //print_r($query);

        $corrupcao['descricao'] = $query->rows;

        $descricao = $this->db->query("
        SELECT partido.partidoNome  FROM " . DB_PREFIX ."partido
        inner join partido_to_corrupcao on partido_to_corrupcao.partidoId = partido.partidoId and partido_to_corrupcao.corrupcaoId = '" . $product_id . "'");

        foreach($descricao->rows as $key=>$value)
        $corrupcao['partidos'][] = $value;

        $politicos = $this->db->query("
        SELECT politicos.nome  FROM " . DB_PREFIX ."politicos
        inner join politico_to_corrupcao on politico_to_corrupcao.politicoId = politicos.id and politico_to_corrupcao.corrupcaoId = '" . $product_id . "'");

        foreach($politicos->rows as $key=>$value)
        $corrupcao['politicos'][] = $value;

        return $corrupcao;
	
	}
	
	public function getCorrupcao($product_id=null,$ordem="recentes") {

        if($ordem=="recentes")
            $orderBy = "corrupcao.data desc";
        elseif($ordem=="antigos")
            $orderBy = "corrupcao.data asc";
        elseif($ordem=="graves")
            $orderBy = "corrupcao.peso desc";
        elseif($ordem=="leves")
            $orderBy = "corrupcao.peso asc";
	
	if($product_id != null)
	{
	$sqlAdd = "where corrupcao.id = '".$product_id."'";
	}
	else
	{
	$sqlAdd ="";
	}
	
	$query = $this->db->query("select 
	corrupcao.id,
	DATE_FORMAT(corrupcao.data, '%d/%m/%Y') as data,

	corrupcao_description.corrupcaoTitulo as titulo,
	corrupcao.`like` as `like`,   
	corrupcao_description.corrupcaoDescription as descricao,
	corrupcao_description.corrupcaoDesdobramento as desdobramento,  
	governo.governo
	from corrupcao 
	inner join corrupcao_description on corrupcao_description.corrupcaoId = corrupcao.id and corrupcao_description.language_id = '" . (int)$this->config->get('config_language_id') . "'
	inner join governo on  corrupcao.governoId = governo.id
	$sqlAdd
	order by $orderBy");
	
	$corrupcao = $query->rows;

	foreach($corrupcao as $key=>$value)
	{
		$descricao = $this->db->query("
		SELECT frase, explicacao, `like`,`deslike` FROM " . DB_PREFIX ."frases where corrupcaoId = '".$corrupcao[$key]['id']."'");
		
		foreach($descricao->rows as $keyx=>$valuex)
			$corrupcao[$key]['frases'][] = $valuex;
			
		$descricaox = $this->db->query("
		SELECT corrupcao_personagens.nome, oquefez, funcao, qqueaconteceu, corrupcao_personagens.`like`, idSystem, tipo, revisado, politicos.avatar as avatar
		FROM " . DB_PREFIX ."corrupcao_personagens
		left join " . DB_PREFIX ."politicos on " . DB_PREFIX ."corrupcao_personagens.idSystem = " . DB_PREFIX ."politicos.id
		where corrupcaoId = '".$corrupcao[$key]['id']."'");
		
		foreach($descricaox->rows as $keyz=>$valuez)
		{
			if($valuez['revisado'] == 1)
			{
				if($valuez['tipo'] == "politico")
				{
					$valuez['link'] = "politico/politico?politicoid=".$valuez['idSystem'];
				}
				elseif($valuez['tipo'] == "poderes")
				{
					$valuez['link'] = "politico/poderes?poderesId=".$valuez['idSystem'];
				}
                elseif($valuez['tipo'] == "governadores")
                {
                    $valuez['link'] = "politico/governadores?governadorId=".$valuez['idSystem'];
                }
			}
			$corrupcao[$key]['personagens'][] = $valuez;			
		}
	}
								
	return $corrupcao;
	
	}

    public function getCorrupcaoLandPage($product_id=null,$ordem='recentes') {

        if($ordem=="recentes")
            $orderBy = "corrupcao.data desc";
        elseif($ordem=="antigos")
            $orderBy = "corrupcao.data asc";
        elseif($ordem=="graves")
            $orderBy = "corrupcao.peso asc";
        elseif($ordem=="leves")
            $orderBy = "corrupcao.peso desc";



        if($product_id != null)
        {
            $sqlAdd = "where corrupcao.id = '".$product_id."'";
        }
        else
        {
            $sqlAdd ="";
        }

        $query = $this->db->query("select
	corrupcao.id,
	DATE_FORMAT(corrupcao.data, '%d/%m/%Y') as data,
	corrupcao_description.corrupcaoTitulo as titulo,
	corrupcao.`like` as `like`,
	corrupcao_description.corrupcaoDescription as descricao,
	corrupcao_description.corrupcaoDesdobramento as desdobramento,
	governo.governo
	from corrupcao
	inner join corrupcao_description on corrupcao_description.corrupcaoId = corrupcao.id and corrupcao_description.language_id = '" . (int)$this->config->get('config_language_id') . "'
	inner join governo on  corrupcao.governoId = governo.id
	$sqlAdd
	order by $orderBy limit 3");
    

        $corrupcao = $query->rows;

        return $corrupcao;

    }

    public function getCorrupcaoSemelhantes($product_id,$limit=3) {

        if($product_id != null)
        {
            $sqlAdd = "where corrupcao.id = '".$product_id."'";
        }
        else
        {
            $sqlAdd ="";
        }

        $query = $this->db->query("select
	corrupcao.id,
	DATE_FORMAT(corrupcao.data, '%d/%m/%Y') as data,
	corrupcao_description.corrupcaoTitulo as titulo,
	corrupcao.`like` as `like`,
	LEFT(corrupcao_description.corrupcaoDescription,250) as descricao,
	corrupcao_description.corrupcaoDesdobramento as desdobramento,
	governo.governo
	from corrupcao
	inner join corrupcao_description on corrupcao_description.corrupcaoId = corrupcao.id and corrupcao_description.language_id = '" . (int)$this->config->get('config_language_id') . "'
	inner join governo on  corrupcao.governoId = governo.id
	order by rand() limit $limit ");

        $corrupcao = $query->rows;

/*
        foreach($corrupcao as $key=>$value)
        {


            $descricao = $this->db->query("
		SELECT frase, explicacao, `like`,`deslike` FROM " . DB_PREFIX ."frases where corrupcaoId = '".$corrupcao[$key]['id']."'");

            foreach($descricao->rows as $keyx=>$valuex)
                $corrupcao[$key]['frases'][] = $valuex;

            $descricaox = $this->db->query("
		SELECT nome, oquefez, funcao, qqueaconteceu, `like`, idSystem, tipo, revisado FROM " . DB_PREFIX ."corrupcao_personagens where corrupcaoId = '".$corrupcao[$key]['id']."'");

            foreach($descricaox->rows as $keyz=>$valuez)
            {
                if($valuez['revisado'] == 1)
                {
                    if($valuez['tipo'] == "politico")
                    {
                        $valuez['link'] = "politico/politico?politicoid=".$valuez['idSystem'];
                    }
                    elseif($valuez['tipo'] == "poderes")
                    {
                        $valuez['link'] = "politico/poderes?poderesId=".$valuez['idSystem'];
                    }
                }
                $corrupcao[$key]['personagens'][] = $valuez;
            }
        }
        */


        return $corrupcao;

    }
	
	public function getCorrupcoes() {
	
	$query = $this->db->query("select * from absurdo 
	left join absurdo_categoria on absurdo_categoria.language_id = '" . (int)$this->config->get('config_language_id') . "'
	inner join absurdo_description on absurdo_description.language_id = '" . (int)$this->config->get('config_language_id') . "' and 
	absurdo_description.absurdoId = absurdo.id");


	
	return $query->rows;
	
	}
	
	public function getGovernos() {
	
	$query = $this->db->query("select * from governo");
	
	return $query->rows;
	
	}
}
?>