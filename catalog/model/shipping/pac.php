<?php
class ModelShippingPAC extends Model {
	
	private $valor_max = 10000; // valor máximo, em reais, que o PAC suporta
	
	private $altura_max = 60; // todas as medidas em cm
	private $largura_max = 60;
	private $comprimento_max = 60;
	
	private $altura_min = 1;
	private $largura_min = 1;
	private $comprimento_min = 1;
	private $soma_dim_max = 150; // medida máxima das somas da altura, largura, comprimento
	
	private $peso_max = 30; // em kg
	private $peso_min = 0.001;
	
	private $volume_max = 130000; // cm3
	
	private $mao_propria = '';
	private $aviso_recebimento = ''; 
	private $declarar_valor = '';
	private $valor_adicional = 0;

	function getQuote($address) {
		
		$this->load->language('shipping/pac');
		
		if ($this->config->get('pac_status')) {
			
			$sql = "SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pac_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')";
			
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pac_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
      		if (!$this->config->get('pac_geo_zone_id')) {
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

			$codigo_erro = $this->validarRegrasPAC($produtos);
			
			if($codigo_erro == 0){
			
				$this->mao_propria = $this->config->get('pac_mao_propria');
				$this->aviso_recebimento = $this->config->get('pac_aviso_recebimento');
				$this->declarar_valor = $this->config->get('pac_declarar_valor');	
				$this->valor_adicional = (is_numeric($this->config->get('pac_adicional'))) ? $this->config->get('pac_adicional') : 0 ;		
				
				$cepOrigem = $this->config->get('pac_postcode');
				$cepDestino = $address['postcode'];			
				
				$pesoCart = $this->getMaiorPeso($this->cart->getWeight(), $this->getPesoVolumeCart($produtos));
				$volumeCart = $this->getVolumeCart($produtos);

				$total_compra = ($this->declarar_valor == 's') ? $this->cart->getTotal() : 0;
				
				if($pesoCart < $this->peso_min){
					$pesoCart = $this->peso_min;
				}				
				
				// a soma do volume e peso está dentro do que é permitido pelos correios
				// o maior peso é usado no cálculo, assim as dimensões não fazem diferença.
				if($volumeCart <= $this->volume_max && $pesoCart <= $this->peso_max){
					$shipping = $this->calcula_pac($cepOrigem, $cepDestino, $pesoCart, $total_compra, $this->comprimento_min, $this->largura_min, $this->altura_min,$address['zone_code']);
					$resultado = $shipping['valor'];
				}
				// o volume ultrapassa o permitido
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
							
							$c = $this->getDimensaoEmCm($produto['length_class'], $produto['length']);
							$l = $this->getDimensaoEmCm($produto['length_class'], $produto['width']);
							$a = $this->getDimensaoEmCm($produto['length_class'], $produto['height']);
							
							$shipping = $this->calcula_pac($cepOrigem, $cepDestino, $peso, $valor, $c, $l, $a,$address['zone_code']);
							
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
					$titulo_pac = $this->language->get('text_pac_title_erro_sistema') ;
					$descricao_pac = $this->language->get('text_pac_erro_busca_valor');
					$resultado = 0;
				}
				else {
					if($shipping['errofrete'] != 0) {
						if($shipping['errofrete'] == '-3') {
							$titulo_pac = $this->language->get('text_pac_title_erro_cep') ;
						}
						else{
							$titulo_pac = $this->language->get('text_pac_title_erro_sistema') ;
						}
						$descricao_pac = $this->language->get('text_pac_erro_busca_valor');					
						$resultado = 0;							
					} 
					else {
						$shipping['prazoentrega'] = $shipping['prazoentrega'];
						$titulo_pac =  sprintf($this->language->get('text_pac_title'), $shipping['prazoentrega']);
						$descricao_pac = $this->language->get('text_pac_description');		
					}
				}
				$resultado += ($resultado * ($this->valor_adicional/100));
				
				$quote_data = array();
				$quote_data['pac'] = array(
					'id'           => 'pac.pac',
					'title'        => $descricao_pac,
					'cost'         => $resultado,
					'tax_class_id' => $this->config->get('pac_tax_class_id'),
					'text'         => $this->currency->format($this->tax->calculate($resultado, $this->config->get('pac_tax_class_id'), $this->config->get('config_tax')))
				);
				$method_data = array(
					'id'         => 'pac',
					'title'      => $titulo_pac,
					'quote'      => $quote_data,
					'sort_order' => $this->config->get('pac_sort_order'),
					'error'      => FALSE
				);
			}
		}
		return $method_data;
	}
	
	public function calcula_pac($cepOrigem, $cepDestino, $peso, $valor, $comp, $larg, $alt,$addr){
			
		if($peso <= 300) {
			$pesoCalcula = '300';
		}
		elseif($peso >= 300 and $peso < 1000){ 
			$pesoCalcula = '1000';
		}
		
		$zonas = array('z1' => "SC",
					   'z2' => "PR/RS/SP",
					   'z3' => "DF/ES/GO/MG/MS/RJ",
					   'z4' => "MT/BA/SE/TO",
					   'z5' => "AC/AL/AM/AP/MA/PB/PA/PE/PI/CE/RN/RR/RO");
		
		$estadoCalcula = "";
				
		foreach($zonas as $keyCalcula=>$valueCalcula)
		{
			$valorAna = "";
			$valorAna = $zonas[$keyCalcula];

			if(substr_count($valorAna,$addr) > 0)
			{
				$estadoCalcula = $keyCalcula;
			}
		}
		
		$sql = "SELECT ".$estadoCalcula." as total FROM " . DB_PREFIX . "frete_pac WHERE peso = '".$pesoCalcula."'";
		
      	$query = $this->db->query($sql);
      	
      	if(!$query->num_rows)
      	{
      		$errofrete = "1";
      		$MsgErroFrete = "Impossivel entregar via pac. Entre em contato com a loja para entender o que houve.";
      	}
     	
      	return $dadosfrete = array(
			"valor" =>  str_replace(',', '.', $query->row['total']),
			"prazoentrega" => '3 a 10 dias',
			"errofrete" => '0',
			"MsgErroFrete" => '');
      	
		/*
		
		$peso = str_replace('.', ',', $peso);
		$valor = str_replace('.', ',', $valor);
		$valor = number_format((float)$valor, 2, ',' , '.');
		$cepOrigem = str_replace('-', '', $cepOrigem);
		$cepDestino = str_replace('-', '', $cepDestino);
		$comp = str_replace('.', ',', $comp);
		$larg = str_replace('.', ',', $larg);
		$alt = str_replace('.', ',', $alt);
		
		$urlCorreios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
		$urlCorreios .=	"nCdEmpresa=";
		$urlCorreios .=	"&sDsSenha=";
		$urlCorreios .=	"&sCepOrigem=%s";
		$urlCorreios .=	"&sCepDestino=%s";
		$urlCorreios .=	"&nVlPeso=%s";
		$urlCorreios .=	"&nCdFormato=1";
		$urlCorreios .=	"&nVlComprimento=%s";
		$urlCorreios .=	"&nVlLargura=%s";
		$urlCorreios .=	"&nVlAltura=%s";
		$urlCorreios .=	"&sCdMaoPropria=".$this->mao_propria;;
		$urlCorreios .=	"&nVlValorDeclarado=%s";
		$urlCorreios .=	"&sCdAvisoRecebimento=".$this->aviso_recebimento;;
		$urlCorreios .=	"&nCdServico=41106";
		$urlCorreios .=	"&nVlDiametro=0";
		$urlCorreios .=	"&StrRetorno=xml";
		
		$urlCorreios = sprintf($urlCorreios, $cepOrigem, $cepDestino, $peso, $comp, $larg, $alt, $valor);

		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $urlCorreios);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
		
		if (!ini_get('safe_mode')) {
			set_time_limit(10); 
		} 
		$file_contents = curl_exec($ch);
		curl_close($ch);		
		
		if ($file_contents == false) {
			return false;
		}
		$carrega = explode("\n", $file_contents);
		$conteudo = trim(str_replace(array("\n", chr(13)), "", implode($carrega, "")));
		
		if(strlen($conteudo) < 1) {
			return false;
		}
		$retornoXmlCorreios = simplexml_load_string($conteudo);
		(!empty($retornoXmlCorreios->cServico->Valor))?$pacXmlValor=(string)$retornoXmlCorreios->cServico->Valor:$pacXmlValor="0.0";
		(!empty($retornoXmlCorreios->cServico->Erro))?$pacXmlErro=(string)$retornoXmlCorreios->cServico->Erro:$pacXmlErro=0;
		(!empty($retornoXmlCorreios->cServico->PrazoEntrega))?$pacXmlPrazoEntrega=(string)$retornoXmlCorreios->cServico->PrazoEntrega:$pacXmlPrazoEntrega="0";
		(!empty($retornoXmlCorreios->cServico->MsgErro))?$pacXmlMsgErro=(string)$retornoXmlCorreios->cServico->MsgErro:$pacXmlMsgErro="";		
		
		
		*/
	}
	
	private function getPesoVolumeCart($produtos){
		
		$pesoCubicoTotal = 0;
		
		foreach ($produtos as $produto){
		    
			$qtde = 0;
			
			$itemAltura = $this->getDimensaoEmCm($produto['length_class'], $produto['height']);
            $itemLargura = $this->getDimensaoEmCm($produto['length_class'], $produto['width']);
            $itemComprimento = $this->getDimensaoEmCm($produto['length_class'], $produto['length']);

            while($qtde < $produto['quantity']){
                $itemPesoCubico = ($itemAltura * $itemLargura * $itemComprimento) / 4800;
                $pesoCubicoTotal += $itemPesoCubico;
                $qtde ++;
            }			
		}
		return number_format($pesoCubicoTotal, 2, '.', '');
	}
	
	private function getVolumeCart($produtos){
		
		$volumeTotal = 0;
		
		foreach ($produtos as $produto){
		    
			$qtde = 0;

			$itemAltura = $this->getDimensaoEmCm($produto['length_class'], $produto['height']);
            $itemLargura = $this->getDimensaoEmCm($produto['length_class'], $produto['width']);
            $itemComprimento = $this->getDimensaoEmCm($produto['length_class'], $produto['length']);

            while($qtde < $produto['quantity']){
                $itemVolume = ($itemAltura * $itemLargura * $itemComprimento);
                $volumeTotal += $itemVolume;
                $qtde ++;
            }			
		}
		return number_format($volumeTotal, 2, '.', '');
	}	
	
	private function getPesoVolumeProduto($altura, $largura, $comprimento){
		$pesoCubico = ($altura * $largura * $comprimento)/4800;
		return number_format($pesoCubico, 2, '.', '');		
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
	
	private function validarRegrasPAC($produtos){

		$codigo_erro = 0;
		
		// verifica se algum produto não atende os requisitos de envio via PAC
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
			else if($this->getMaiorPeso($peso, $this->getPesoVolumeProduto($altura, $largura, $comprimento)) > $this->peso_max){
				$codigo_erro = 5;
				break;
			}
			// altura não pode ser maior que o comprimento
			else if( ($altura > $comprimento)) {
				$codigo_erro = 6;
				break;
			}
			// ultrapassa o volume permitido
			else if(($altura * $largura * $comprimento) > $this->volume_max) {
				$codigo_erro = 7;
				break;					
			}
			// valor do produto ultrapassa o permitido
			else if($this->tax->calculate($produto['price'], $produto['tax_class_id'], $this->config->get('config_tax')) > $this->valor_max){
				$codigo_erro = 8;
				break;
			}				
			else{}				
		}

		return $codigo_erro;
	}
	private function getMaiorPeso($pesoNormal, $pesoVolume){
		if($pesoNormal > $pesoVolume){
			return $pesoNormal;
		}
		return $pesoVolume;
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