<?php
class ModelConteudoDocumentarios extends Model {

    public function getDoc($documentario_id = null,$categoria = null,$limit = 10)
    {

        $add = "";

        if(!is_null($documentario_id))
        {
            $add .= "and documentario.id = '".$documentario_id."'";
            $addCat = "inner join documentario_to_categoria on documentario_to_categoria.idDoc = '".$documentario_id."'";
        }
        else
        {
        $addCat = "inner join documentario_to_categoria on documentario_to_categoria.idCat = '".$categoria."' and  documentario_to_categoria.idDoc = documentario.id";
        }

        $sql = "select
        documentario.id,
        documentario.documentario_nome,
        documentario_description.descricao,
        documentario_to_categoria.idCat as categoria_id,
        documentario_description.descricao_short
        from documentario
        inner join documentario_description on documentario.id = documentario_description.idDoc
        $addCat
        where documentario.`status` = '1' $add limit $limit";

        $query = $this->db->query($sql);

        require_once(DIR_SYSTEM.'library/autoEmbed/AutoEmbed.class.php');

        $AE = new AutoEmbed();

        foreach($query->rows as $key=>$value)
        {

            $i = 0;


            $corrupcao[$value['id']] = $value;

            $queryx = $this->db->query("select video.url, video.id as videoid, nome from video where video.origem = 'doc' and video.idOrigem = '".$value['id']."'");

            foreach($queryx->rows as $keyx=>$valuex)
            {

                $i = $i+1;

                if (!$AE->parseUrl($valuex['url'])) {
                    print "No embeddable video found (or supported";
                }
                else
                {
                    $corrupcao[$value['id']]['videos'][$i]['thumb'] = $AE->getImageURL();
                    $corrupcao[$value['id']]['videos'][$i]['nome'] = $valuex['nome'];
                    $corrupcao[$value['id']]['videos'][$i]['embed'] = $AE->getEmbedCode();
                }
             }
        }
        return $corrupcao;
    }

    public function getDocCat() {

        $query = $this->db->query("select * from documentario_categoria order by nome asc");

        return $query->rows;

    }

    public function getDocRel($id,$categoria)
    {
        $query = $this->db->query("select
        documentario.id,
        documentario.documentario_nome,
        documentario_description.descricao,
        documentario_description.descricao_short
        from documentario
        inner join documentario_description on documentario.id = documentario_description.idDoc
        inner join documentario_to_categoria on documentario_to_categoria.idCat = '".$categoria."' and documentario_to_categoria.idDoc = documentario.id
        where documentario.id NOT IN ($id)
        order by rand() limit 5");

        if($query->num_rows > 0)
        {

        require_once(DIR_SYSTEM.'library/autoEmbed/AutoEmbed.class.php');

        $AE = new AutoEmbed();

        foreach($query->rows as $key=>$value)
        {

            $i = 0;

            $corrupcao[$value['id']] = $value;

            $queryx = $this->db->query("select video.url, nome from video where video.origem = 'doc' and video.idOrigem = '".$value['id']."'");


            foreach($queryx->rows as $keyx=>$valuex)
            {

                $i = $i+1;

                if (!$AE->parseUrl($valuex['url'])) {
                     print "No embeddable video found (or supported";
                }
                else
                {
                    $corrupcao[$value['id']]['videos'][$i]['thumb'] = $AE->getImageURL();
                    $corrupcao[$value['id']]['videos'][$i]['nome'] = $valuex['nome'];
                    $corrupcao[$value['id']]['videos'][$i]['embed'] = $AE->getEmbedCode();
                }
            }
        }

        return $corrupcao;
        }
    }

	public function getCorrupcaobyId($product_id) {
	
	$query = $this->db->query("select 
	corrupcao.id,
	corrupcao.date,
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
	
	public function getCorrupcao() {
	
	$query = $this->db->query("select 
	corrupcao.id,
	corrupcao.data,
	corrupcao_description.corrupcaoTitulo,
	corrupcao_description.corrupcaoDescription
	from corrupcao 
	inner join corrupcao_description on corrupcao_description.corrupcaoId = corrupcao.id and corrupcao_description.language_id = '" . (int)$this->config->get('config_language_id') . "'"); 
			
	return $corrupcao;
	
	}
	
	
	
	
	public function getCorrupcoes() {
	
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
	
}
?>