<?php
class ModelShippingEsedex extends Model {
	
	private $valor_max = 10000; // valor máximo, em reais, que o sedex suporta
	private $valor_min = 10.50; // // valor mínimo, em reais, que o sedex suporta
	
	private $altura_max = 60; // todas as medidas em cm
	private $largura_max = 60;
	private $comprimento_max = 60;
	
	private $altura_min = 1;
	private $largura_min = 1;
	private $comprimento_min = 1;
	private $soma_dim_max = 150; // medida máxima das somas da altura, largura, comprimento
	
	private $peso_max = 30; // em kg
	private $peso_min = 0.300;
	
	private $mao_propria = ''; 
	private $aviso_recebimento = ''; 
	private $declarar_valor = ''; 
	private $valor_adicional = 0;	
	
	function getQuote($address) {
		
		$this->load->language('shipping/esedex');
		
		if ($this->config->get('esedex_status')) {
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('esedex_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
      		if (!$this->config->get('esedex_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
        		$status = TRUE;
      		} else {
        		$status = FALSE;
      		}
		} 
		else {
			$status = FALSE;
		}
		
		$method_data = array();
		
		if ($status) {

			$produtos = $this->cart->getProducts();

			$codigo_erro = $this->validarRegrasSedex($produtos);

			if($codigo_erro == 0){
				
				$this->mao_propria = $this->config->get('esedex_mao_propria');
				$this->aviso_recebimento = $this->config->get('esedex_aviso_recebimento');
				$this->declarar_valor = $this->config->get('esedex_declarar_valor');	
				$this->valor_adicional = (is_numeric($this->config->get('esedex_adicional'))) ? $this->config->get('esedex_adicional') : 0 ;
			
				$cepOrigem = $this->config->get('esedex_postcode');
				$cepDestino = $address['postcode'];			
				
				$pesoCart = $this->cart->getWeight();
				
				$total_compra = ($this->declarar_valor == 's') ? $this->cart->getTotal() : 0;
				// somente Sedex
				$total_compra = ($total_compra > 0 && $total_compra < $this->valor_min) ? $this->valor_min : $total_compra;
								
				if($pesoCart < $this->peso_min){
					$pesoCart = $this->peso_min;
				}
				
				// peso do carrinho dentro do permitido pelos correios
				// as dimensões para Sedex não são necessárias
				if($pesoCart <= $this->peso_max){
					$shipping = $this->calcula_sedex($cepOrigem, $cepDestino, $pesoCart, $total_compra, 0, 0, 0,$address['zone_code']);
					$resultado = $shipping['valor'];
				}
				// o peso ultrapassa o permitido
				// é calculado o frete para cada produto no carrinho				
				else {
					$resultado = 0;
					foreach ($produtos as $produto) {
						
						$qtde = 0;
						while($qtde < $produto['quantity']){
							$peso = $this->getPesoEmKg($produto['weight_class'], $produto['weight']);
							
							if($peso < $this->peso_min){
								$peso = $this->peso_min;
							}							
							
							$valor = $this->tax->calculate($produto['price'], $produto['tax_class_id'], $this->config->get('config_tax'));
							$valor = number_format($valor, '2', '.', '');
							
							$valor = ($this->declarar_valor == 's') ? $valor : 0;
							// somente Sedex
							$valor = ($valor > 0 && $valor < $this->valor_min) ? $this->valor_min : $valor;
														
							$shipping = $this->calcula_sedex($cepOrigem, $cepDestino, $peso, $valor, 0, 0, 0,$address['zone_code']);
							
							// se ocorreu erro no cálculo de um produto, abandona o cálculo
							if($shipping['errofrete'] != 0){
								$resultado = 0;
								break 2; // sai do while e do foreach
							}							
							
							$resultado = $resultado + $shipping['valor'];
							
							$qtde++;
			            }						
					}
				} 

				if ( $shipping['errofrete'] == 0 && ( $shipping['valor'] == 0 || $shipping['prazoentrega'] == 0 ) )	{
					$titulo_sedex = $this->language->get('text_sedex_title_erro_sistema') ;
					$descricao_sedex = $this->language->get('text_sedex_erro_busca_valor');
					$resultado = 0;
				} 
				else {
					if($shipping['errofrete'] != 0) {
						if($shipping['errofrete'] == '-3') {
							$titulo_sedex = $this->language->get('text_sedex_title_erro_cep') ;
						}
						else{
							$titulo_sedex = $this->language->get('text_sedex_title_erro_sistema');
						}
						$descricao_sedex = $this->language->get('text_sedex_erro_busca_valor');					
						$resultado = 0;							
					} 
					else {
						$shipping['prazoentrega'] = $shipping['prazoentrega'];
						$titulo_sedex = sprintf($this->language->get('text_sedex_title'), $shipping['prazoentrega']);
						$descricao_sedex = $this->language->get('text_sedex_description');		
					}
				}
				$resultado += ($resultado * ($this->valor_adicional/100));
				
				$quote_data = array();
				$quote_data['esedex'] = array(
					'id'           => 'esedex.esedex',
					'title'        => $descricao_sedex,
					'cost'         => $resultado,
					'tax_class_id' => $this->config->get('esedex_tax_class_id'),
					'text'         => $this->currency->format($this->tax->calculate($resultado, $this->config->get('esedex_tax_class_id'), $this->config->get('config_tax')))
				);
				$method_data = array(
					'id'         => 'esedex',
					'title'      => $titulo_sedex,
					'quote'      => $quote_data,
					'sort_order' => $this->config->get('esedex_sort_order'),
					'error'      => FALSE
				);
			}
		}
		return $method_data;
	}
	
	public function calcula_sedex($cepOrigem, $cepDestino, $peso, $valor, $comp, $larg,$alt,$addr){
		
		$errofrete = "";
		$MsgErroFrete = "";
				
		if($peso <= 300) {
			$pesoCalcula = '300';
		}
		elseif($peso > 300 and $peso <= 500){ 
			$pesoCalcula = '500';
		}
		elseif($peso > 500 and $peso <= 750){ 
			$pesoCalcula = '750';
		}
		elseif($peso > 750 and $peso <= 1000){ 
			$pesoCalcula = '1000';
		}
		elseif($peso > 1000 and $peso <= 2000){ 
			$pesoCalcula = '2000';
		}
		elseif($peso > 2000 and $peso <= 3000){ 
			$pesoCalcula = '3000';
		}
		elseif($peso > 3000 and $peso <= 4000){ 
			$pesoCalcula = '4000';
		}
		elseif($peso > 4000 and $peso <= 5000){ 
			$pesoCalcula = '5000';
		}
		elseif($peso > 5000 and $peso <= 6000){ 
			$pesoCalcula = '6000';
		}
		elseif($peso > 6000 and $peso <= 7000){ 
			$pesoCalcula = '7000';
		}
		elseif($peso > 7000 and $peso <= 8000){ 
			$pesoCalcula = '8000';
		}
		elseif($peso > 8000 and $peso <= 9000){ 
			$pesoCalcula = '9000';
		}
		elseif($peso > 9000 and $peso <= 10000){ 
			$pesoCalcula = '10000';
		}
		elseif($peso > 10000 and $peso <= 11000){ 
			$pesoCalcula = '11000';
		}
		elseif($peso > 11000 and $peso <= 12000){ 
			$pesoCalcula = '12000';
		}
		elseif($peso > 12000 and $peso <= 13000){ 
			$pesoCalcula = '13000';
		}
		elseif($peso > 13000 and $peso <= 14000){ 
			$pesoCalcula = '14000';
		}
		elseif($peso > 14000 and $peso <= 15000){ 
			$pesoCalcula = '15000';
		}
		elseif($peso > 15000 and $peso <= 16000){ 
			$pesoCalcula = '16000';
		}
		elseif($peso > 16000 and $peso <= 17000){ 
			$pesoCalcula = '17000';
		}		
		elseif($peso > 17000 and $peso <= 18000){ 
			$pesoCalcula = '18000';
		}		
		elseif($peso > 18000 and $peso <= 19000){ 
			$pesoCalcula = '19000';
		}
		elseif($peso > 19000 and $peso <= 20000){ 
			$pesoCalcula = '20000';
		}
		elseif($peso > 20000 and $peso <= 21000){ 
			$pesoCalcula = '21000';
		}
		elseif($peso > 21000 and $peso <= 22000){ 
			$pesoCalcula = '22000';
		}
		elseif($peso > 22000 and $peso <= 23000){ 
			$pesoCalcula = '23000';
		}
		elseif($peso > 23000 and $peso <= 24000){ 
			$pesoCalcula = '24000';
		}
		elseif($peso > 24000 and $peso <= 25000){ 
			$pesoCalcula = '25000';
		}
		elseif($peso > 25000 and $peso <= 26000){ 
			$pesoCalcula = '26000';
		}
		elseif($peso > 26000 and $peso <= 27000){ 
			$pesoCalcula = '27000';
		}
		elseif($peso > 27000 and $peso <= 28000){ 
			$pesoCalcula = '28000';
		}
		elseif($peso > 28000 and $peso <= 29000){ 
			$pesoCalcula = '29000';
		}
		elseif($peso > 29000 and $peso <= 30000){ 
			$pesoCalcula = '30000';
		}
	
		if($this->config->get('esedex_capital_interior') == "1")
		{		
			$zona = "interior";
			
			if(($cepDestino >= "01000000" and $cepDestino <= "05999999") // sao paulo
			or ($cepDestino >= "20000000" and $cepDestino <= "23799999") // rio de janeiro
			or ($cepDestino >= "29000000" and $cepDestino <= "29099000") // vitoria 
			or ($cepDestino >= "30000000" and $cepDestino <= "31999999") // bh
			or ($cepDestino >= "40000000" and $cepDestino <= "41999999") // salvador
			or ($cepDestino >= "49000000" and $cepDestino <= "49099999") // Aracaju
			or ($cepDestino >= "50000000" and $cepDestino <= "52999999") // Recife
			or ($cepDestino >= "57000000" and $cepDestino <= "57099999") // macio
			or ($cepDestino >= "58000000" and $cepDestino <= "58099999") // Jo�o Pessoa
			or ($cepDestino >= "59000000" and $cepDestino <= "59099999") // Natal
			or ($cepDestino >= "60000000" and $cepDestino <= "60999999") // Fortaleza		
			or ($cepDestino >= "64000000" and $cepDestino <= "64099999") // Teresina
			or ($cepDestino >= "65000000" and $cepDestino <= "65099999") // S�o Luiz
			or ($cepDestino >= "66000000" and $cepDestino <= "66999999") // Bel�m
			or ($cepDestino >= "68900000" and $cepDestino <= "68914999") // Macap�
			or ($cepDestino >= "69000000" and $cepDestino <= "69099999") // Manaus
			or ($cepDestino >= "69300000" and $cepDestino <= "69339999") // Boa Vista
			or ($cepDestino >= "69900000" and $cepDestino <= "69920999") // Rio Branco
			or ($cepDestino >= "70700000" and $cepDestino <= "70999999") // Bras�lia
			or ($cepDestino >= "74000000" and $cepDestino <= "74799999") // Goi�nia
			or ($cepDestino >= "77000000" and $cepDestino <= "77270999") // Palmas
			or ($cepDestino >= "78000000" and $cepDestino <= "78109999") // Cuiab�
			or ($cepDestino >= "78900000" and $cepDestino <= "78930999") // Porto Velho
			or ($cepDestino >= "79000000" and $cepDestino <= "79129999") // Campo Grande
			or ($cepDestino >= "80000000" and $cepDestino <= "82999999") // Curitiba
			or ($cepDestino >= "88000000" and $cepDestino <= "88099999") // florianopolis
			or ($cepDestino >= "90000000" and $cepDestino <= "91999999")){ // Porto Alegre
			
			$zona = "capital";
			
			}
		}
		else
		{
			$zona = "";
		}
		
		$sql = "SELECT nome FROM " . DB_PREFIX . "fretes_zona WHERE estados like '%".$addr."%' and (area = '$zona' or area = '') and frete = 'esedex'";
		
		//print $sql;
		
		$query = $this->db->query($sql);
      	
      	$estadoCalcula = "";
      	
      	if($query->rows)
      	{
      		$estadoCalcula = $query->row['nome'];
		}
		else
		{
			$errofrete = "1";
      		$MsgErroFrete = "Impossivel entregar via e-sedex. Entre em contato com a loja para entender o que houve.";
      	}
      			
		$sql = "SELECT ".$estadoCalcula." as total FROM " . DB_PREFIX . "frete_esedex WHERE peso = '".$pesoCalcula."'";
		
		
      	$query = $this->db->query($sql);
      	
      	if(!$query->num_rows)
      	{
      		$errofrete = "1";
      		$MsgErroFrete = "Impossivel entregar via sedex. Entre em contato com a loja para entender o que houve.";
      	}
      	
      /*	if($this->cart->getSubTotal() >= $this->config->get('esedex_free_shipping'))
      	{
      		$query->row['total'] = "0.00";
      	}
      	*/

     	
      	return $dadosfrete = array(
			"valor" =>  str_replace(',', '.', $query->row['total']),
			"prazoentrega" => '1 a 3 dias',
			"errofrete" => $errofrete,
			"MsgErroFrete" => $MsgErroFrete);
		
	}
	
	
	private function getDimensaoEmCm($unidade, $dimensao){
		if($unidade == 'mm'){
			return $dimensao / 10;
		}
		return $dimensao;
	}
	
	private function getPesoEmKg($unidade, $peso){
		if($unidade == 'g'){
			return $peso / 1000;
		}
		return $peso;
	}	
	
	private function validarRegrasSedex($produtos){

		$codigo_erro = 0;
		
		// verifica se algum produto não atende os requisitos de envio via sedex
		foreach ($produtos as $produto){

			// dimensões vazias
			if(!$this->validarDimensoes($produto['height'], $produto['width'], $produto['length'], $produto['weight'] )){
				$codigo_erro = 1;
				break;
			}
			$altura = $this->getDimensaoEmCm($produto['length_class'], $produto['height']);
			$largura = $this->getDimensaoEmCm($produto['length_class'], $produto['width']);
			$comprimento = $this->getDimensaoEmCm($produto['length_class'], $produto['length']);
			$peso = $this->getPesoEmKg($produto['weight_class'], $produto['weight']);
			
			// ultrapassa os limites permitidos
			if( $altura > $this->altura_max || $largura > $this->largura_max || $comprimento > $this->comprimento_max ){
				$codigo_erro = 2;
				break;
			}
			// não tem as dimensões mínimas exigidas
			else if( $altura < $this->altura_min || $largura < $this->largura_min || $comprimento < $this->comprimento_min ){
				$codigo_erro = 3;
				break;
			}
			// soma das dimensões ultrapassa o limite permitido				
			else if( ($altura + $largura + $comprimento) > $this->soma_dim_max) {
				$codigo_erro = 4;
				break;
			}
			// peso ultrapassa o permitido
			else if($peso > $this->peso_max){
				$codigo_erro = 5;
				break;
			}
			// altura não pode ser maior que o comprimento
			else if( ($altura > $comprimento)) {
				$codigo_erro = 6;
				break;
			}
			// valor do produto ultrapassa o permitido
			else if($this->tax->calculate($produto['price'], $produto['tax_class_id'], $this->config->get('config_tax')) > $this->valor_max){
				$codigo_erro = 7;
				break;
			}				
			else{}				
		}

		return $codigo_erro;
	}
  	private function validarDimensoes($altura, $largura, $comprimento, $peso){
	  	if(	$altura == '' || $largura == '' || $comprimento == '' || $peso = '' ||
			$altura == 0 || $largura == 0 || $comprimento == 0 || $peso = 0){
			
			return false;
		}
		return true;
  	}	
}
?>