<?
Class ModelCheckoutRisk extends Model {

    public function enviaClearSaleTg($idPedido)
    {
    
    	$memory = xmlwriter_open_memory();
		xmlwriter_start_document($memory,'1.0','UTF-8');
		xmlwriter_end_dtd($memory);
		xmlwriter_start_element ($memory,'ClearSale'); // <html>
		xmlwriter_start_element ($memory,'Orders'); // <html>		
   		
		$sql = "SELECT `order`.order_id as id,
				DATE_FORMAT(`order`.date_added , '%Y-%m-%dT%H:%i:%S') as data,				
				'B2C' as B2B_B2C,
				(SELECT order_total.`value` as frete from order_total where order_total.title=CONCAT(`order`.shipping_method,':') and order_total.order_id = `order`.order_id) as frete,
				(SELECT order_total.`value` as subTotal from order_total where order_total.title='Sub-total:' and order_total.order_id = `order`.order_id) as subTotal,
				(SELECT order_total.`value` as total from order_total where order_total.title='Total:' and order_total.order_id = `order`.order_id) as total,
				'ate 10 dias apos a confirmacao do pagamento' as prazo,
				SUM(order_product.quantity) as qtde,
				`order`.ip,
				'msgPresente' as msgPresente,
				'obs' as observacoes,
				'Loja Virtual' as origem,
				'1' as pagamentos
				FROM `order`
				Inner Join order_product On `order`.order_id = order_product.order_id
				Inner Join order_total On order_total.order_id = `order`.order_id 
				where `order`.order_id = '$idPedido'
				Group By `order`.order_id  limit 1";

		$pedido = $this->db->query($sql);

		xmlwriter_start_element($memory,"Order"); 	//<Order>

		$xmlClearSale = '<ClearSale>';
		$xmlClearSale .= '	<Orders>';
		$xmlClearSale .= '		<Order>';														// ORDER
		$xmlClearSale .= '			<ID>'.$idPedido.'</ID>';
		$xmlClearSale .= '			<Date>'.$pedido->row['data'].'</Date>';
		$xmlClearSale .= '			<Email>onlinestore@carmensteffens.com.br</Email>';
		//$xmlClearSale .= '			<ChannelID>'.$valores->channelId.'</ChannelID>';
		$xmlClearSale .= '			<B2B_B2C>'.$pedido->row['B2B_B2C'].'</B2B_B2C>';
		$xmlClearSale .= '     		<ShippingPrice>'.number_format($pedido->row['frete'], 2, ".", "").'</ShippingPrice>';
		$xmlClearSale .= '			<TotalItens>'.number_format($pedido->row['subTotal'], 2, ".", "").'</TotalItens>';
		$xmlClearSale .= '			<TotalOrder>'.number_format($pedido->row['total'], 2, ".", "").'</TotalOrder>';
		$xmlClearSale .= '			<DeliveryTimeCD>'.$pedido->row['prazo'].'</DeliveryTimeCD>';
		$xmlClearSale .= '			<QtyItems>'.$pedido->row['qtde'].'</QtyItems>';
		$xmlClearSale .= '			<QtyPaymentTypes>'.$pedido->row['pagamentos'].'</QtyPaymentTypes>';
		//$xmlClearSale .= '			<IP>'.$pedido->ip.'</IP>';
		//$xmlClearSale .= '			<GiftMessage>'.$valores->msgPresente.'</GiftMessage>';
		//$xmlClearSale .= ' 			<Obs>'.$valores->observacoes.'</Obs>';
		//$xmlClearSale .= ' 			<Status>'.$pedido->status.'</Status>';
		$xmlClearSale .= ' 			<Origin>'.$pedido->row['origem'].'</Origin>';

		// COLLECTION DATA
		$sql = "SELECT `order`.customer_id as idCliente,
					IF(count(`order`.cpfCnpj) = '15', 1, 2) as pessoaTipo,
					`order`.cpfCnpj as documento1,
					`order`.rg as documento2,
					 CONCAT(`order`.firstname,' ',`order`.lastname) as nome,
					 DATE_FORMAT(`order`.dataNasc, '%Y-%m-%dT01:00:00') as dataNasc,
					`order`.email as email,
					`order`.shipping_address_1 as rua,
					`order`.shipping_address_2 as numero,
					`order`.shipping_address_3 as complemento,
					`order`.shipping_bairro as bairro,
					`order`.shipping_city as cidade,
					`order`.shipping_postcode as cep,
					`order`.shipping_zone as estado,
					`order`.shipping_country as pais,
					'' as referencia,
					'3' as fone1Tipo,
					'55' as fone1DDI,
					SUBSTR(`order`.telephone, 2, 2) as fone1DDD,
					SUBSTR(`order`.telephone, 7) as fone1Numero,
					'' as fone1Extensao
			   FROM `order`
			  Where `order`.order_id = '$idPedido'
		   Group By `order`.order_id";
		   
		$cobranca = $this->db->query($sql);    

		$xmlClearSale .= '			<CollectionData>';											// COLLECTION DATA
		$xmlClearSale .= '				<ID>'.$cobranca->row['idCliente'].'</ID>';
		$xmlClearSale .= '				<Type>'.$cobranca->row['pessoaTipo'].'</Type>';
		$xmlClearSale .= '				<LegalDocument1>'.$cobranca->row['documento1'].'</LegalDocument1>';
		$xmlClearSale .= '				<LegalDocument2>'.$cobranca->row['documento2'].'</LegalDocument2>';
		$xmlClearSale .= '				<Name>'.utf8_encode($cobranca->row['nome']).'</Name>';
		$xmlClearSale .= '				<BirthDate>'.$cobranca->row['dataNasc'].'</BirthDate>';
		$xmlClearSale .= '				<Email>'.$cobranca->row['email'].'</Email>';
		$xmlClearSale .= '				<Genre>M</Genre>';
		
		// ADDRESS
		$xmlClearSale .= '				<Address>';												// ADDRESS
		$xmlClearSale .= '					<Street>'.utf8_encode($cobranca->row['rua']).'</Street>';
		$xmlClearSale .= '					<Number>'.trim($cobranca->row['numero']).'</Number>';
		$xmlClearSale .= '					<Comp>'.$cobranca->row['complemento'].'</Comp>';
		$xmlClearSale .= '					<County>'.utf8_encode($cobranca->row['bairro']).'</County>';
		$xmlClearSale .= '					<City>'.utf8_encode($cobranca->row['cidade']).'</City>';
		$xmlClearSale .= '					<State>'.$cobranca->row['estado'].'</State>';
		$xmlClearSale .= '					<Country>'.html_entity_decode($cobranca->row['pais']).'</Country>';
		$xmlClearSale .= '					<ZipCode>'.$cobranca->row['cep'].'</ZipCode>';
		$xmlClearSale .= '					<Reference>mercado</Reference>';
		$xmlClearSale .= '				</Address>';

		// PHONES
		$xmlClearSale .= '				<Phones>';												// PHONES
		$xmlClearSale .= '					<Phone>';
		$xmlClearSale .= '						<Type>'.$cobranca->row['fone1Tipo'].'</Type>';
		$xmlClearSale .= '						<DDI>'.$cobranca->row['fone1DDI'].'</DDI>';
		$xmlClearSale .= '						<DDD>'.$cobranca->row['fone1DDD'].'</DDD>';
		$xmlClearSale .= '						<Number>'.str_replace("-", "", $cobranca->row['fone1Numero']).'</Number>';
		//$xmlClearSale .= '						<Extension></Extension>';
		$xmlClearSale .= '					</Phone>';
		$xmlClearSale .= '				</Phones>';
		$xmlClearSale .= '			</CollectionData>';
		
		// SHIPPING DATA
		$entrega = $cobranca;
		
		$xmlClearSale .= '			<ShippingData>';											// SHIPPING DATA
		$xmlClearSale .= '				<ID>'.$entrega->row['idCliente'].'</ID>';
		$xmlClearSale .= '				<Type>'.$entrega->row['pessoaTipo'].'</Type>';
		$xmlClearSale .= '				<LegalDocument1>'.$entrega->row['documento1'].'</LegalDocument1>';
		$xmlClearSale .= '				<LegalDocument2>'.$entrega->row['documento2'].'</LegalDocument2>';
		$xmlClearSale .= '				<Name>'.utf8_encode($entrega->row['nome']).'</Name>';
		$xmlClearSale .= '				<BirthDate>'.$entrega->row['dataNasc'].'</BirthDate>';
		$xmlClearSale .= '				<Email>'.$cobranca->row['email'].'</Email>';
		//$xmlClearSale .= '				<Genre>'.$entrega->row['sexo.'</Genre>';
		
		// ADDRESS SHIPPING DATA
		$xmlClearSale .= '				<Address>';		
		$xmlClearSale .= '					<Street>'.utf8_encode($entrega->row['rua']).'</Street>';
		$xmlClearSale .= '					<Number>'.$entrega->row['numero'].'</Number>';
		$xmlClearSale .= '					<Comp>'.$entrega->row['complemento'].'</Comp>';
		$xmlClearSale .= '					<County>'.utf8_encode($entrega->row['bairro']).'</County>';
		$xmlClearSale .= '					<City>'.utf8_encode($entrega->row['cidade']).'</City>';
		$xmlClearSale .= '					<State>'.$entrega->row['estado'].'</State>';
		$xmlClearSale .= '					<Country>'.$entrega->row['pais'].'</Country>';
		$xmlClearSale .= '					<ZipCode>'.$entrega->row['cep'].'</ZipCode>';
		//$xmlClearSale .= '					<Reference></Reference>';
		$xmlClearSale .= '				</Address>';

		// PHONES SHIPPING DATA
		$xmlClearSale .= '				<Phones>';												// PHONES
		$xmlClearSale .= '					<Phone>';
		$xmlClearSale .= '						<Type>'.$entrega->row['fone1Tipo'].'</Type>';
		$xmlClearSale .= '						<DDI>'.$entrega->row['fone1DDI'].'</DDI>';
		$xmlClearSale .= '						<DDD>'.$entrega->row['fone1DDD'].'</DDD>';
		$xmlClearSale .= '						<Number>'.str_replace("-", "", $entrega->row['fone1Numero']).'</Number>';
		$xmlClearSale .= '						<Extension></Extension>';
		$xmlClearSale .= '					</Phone>';
		$xmlClearSale .= '				</Phones>';
		$xmlClearSale .= '			</ShippingData>';

		// PAYMENTS SHIPPING

    	// COLLECTION DATA
		$sql = "SELECT ipagare_meios.id as idForma, ipagare_meios.tipo as tipoPagamento, ipagare_meios.nome as nomePagamento, ipagare_formas.valor as nmParcelas, ipagare_card.card_validate
    FROM ipagare_meios 
    inner JOIN ipagare_order ON ipagare_meios.id = ipagare_order.meio
		inner join ipagare_formas on ipagare_order.forma = ipagare_formas.codigo
		left join ipagare_card on ipagare_card.order_id = ipagare_order.id
    WHERE ipagare_order.`order` = '$idPedido'";
		   
		$pagamento = $this->db->query($sql); 
		
		$tipoPagamento = $pagamento->row['tipoPagamento'];

		if($tipoPagamento == "cartao")
		{
			$pagamento->row['tipo'] = 1;
			
			if($pagamento->row['idForma'] == 1)
			$pagamento->row['idForma'] = 1;
			elseif($pagamento->row['idForma'] == 2)
			$pagamento->row['idForma'] = 2;
			
			if(substr_count($pagamento->row['nomePagamento'],"Visa"))
			$pagamento->row['idForma'] = 3;  
			
			if(substr_count($pagamento->row['nomePagamento'],"American Express"))
			$pagamento->row['idForma'] = 5;  
			
		}		
		elseif($tipoPagamento == "boleto")
		{
			$pagamento->row['tipo'] = 2;
		}
		elseif($tipoPagamento == "sps")
		{
			$pagamento->row['tipo'] = 6;
		}
		                                                      
		$xmlClearSale .= '			<Payments>';												// PAYMENTS
		$xmlClearSale .= '				<Payment>';
		$xmlClearSale .= '					<Sequential>1</Sequential>';
		$xmlClearSale .= '					<Date>'.$pedido->row['data'].'</Date>';
		$xmlClearSale .= '					<Amount>'.number_format($pedido->row['total'], 2, ".", "").'</Amount>';
		$xmlClearSale .= '					<PaymentTypeID>'.$pagamento->row['tipo'].'</PaymentTypeID>';
		$xmlClearSale .= '					<QtyInstallments>'.$pagamento->row['nmParcelas'].'</QtyInstallments>';
   
		if($pagamento->row['tipo'] == 1) {
  			$xmlClearSale .= '					<CardNumber></CardNumber>';
			$xmlClearSale .= '     				<CardBin></CardBin>';
			$xmlClearSale .= '     				<CardType>'.$pagamento->row['idForma'].'</CardType>';
			$xmlClearSale .= '					<CardExpirationDate>'.$pagamento->row['card_validate'].'</CardExpirationDate>';
		}
		$xmlClearSale .= '					<Name>'.(utf8_encode($cobranca->row['nome'])).'</Name>';
		$xmlClearSale .= '					<LegalDocument>'.($cobranca->row['documento1']).'</LegalDocument>';

		// ADDRESS PAYMENTS
		$xmlClearSale .= '					<Address>';											// ADDRESS
		$xmlClearSale .= '					<Street>'.utf8_encode(html_entity_decode($entrega->row['rua'])).'</Street>';
		$xmlClearSale .= '					<Number>'.$entrega->row['numero'].'</Number>';
		$xmlClearSale .= '					<Comp>'.$entrega->row['complemento'].'</Comp>';
		$xmlClearSale .= '					<County>'.utf8_encode($entrega->row['bairro']).'</County>';
		$xmlClearSale .= '					<City>'.utf8_encode($entrega->row['cidade']).'</City>';
		$xmlClearSale .= '					<State>'.$entrega->row['estado'].'</State>';
		$xmlClearSale .= '					<Country>'.$entrega->row['pais'].'</Country>';
		$xmlClearSale .= '					<ZipCode>'.$entrega->row['cep'].'</ZipCode>';		
		$xmlClearSale .= '					</Address>';
		$xmlClearSale .= '				</Payment>';			
		$xmlClearSale .= '			</Payments>';
		
		// ITENS
		$xmlClearSale .= '			<Items>';												
		//	Tratamento da TAG <Items>
		xmlwriter_start_element($memory,"Items");
		
		
		$sql = "    select    order_product.model as codigo,
					order_product.`name` as nome,
					order_product.price as vlUnidade,
					order_product.quantity as qtItens,
					0 as embrulhoPresente,
					product.manufacturer_id as marcaId,
					manufacturer_description.`name` as marcaNome
					from order_product
					left join product on product.product_id = order_product.product_id 
					left join manufacturer_description on manufacturer_description.manufacturer_id = product.manufacturer_id 
					where order_product.order_id = '$idPedido'";
		
		$produtos  = $this->db->query($sql); 		
		//echo '<pre>';print_r($produtos);echo '</pre>';

			foreach($produtos->rows as $produto){
				$xmlClearSale .= '				<Item>';										// ITEM
				$xmlClearSale .= '					<ID>'.$produto['codigo'].'</ID>';
				$xmlClearSale .= '					<Name>'.str_replace('"','',str_replace('&','e',$produto['nome'])).'</Name>';
				$xmlClearSale .= '					<ItemValue>'.number_format($produto['vlUnidade'], 2, ".", "").'</ItemValue>';
				//$xmlClearSale .= '					<Generic></Generic>';
				$xmlClearSale .= '					<Qty>'.$produto['qtItens'].'</Qty>';					
				$xmlClearSale .= '					<GiftTypeID>'.$produto['embrulhoPresente'].'</GiftTypeID>';
				$xmlClearSale .= '					<CategoryID>'.$produto['marcaId'].'</CategoryID>';
				$xmlClearSale .= '          		<CategoryName>'.$produto['marcaNome'].'</CategoryName>';				
				$xmlClearSale .= '        		</Item>';
			}
		
		$xmlClearSale .= '			</Items>';

		$xmlClearSale .= '		</Order>';
		$xmlClearSale .= '	</Orders>';
		$xmlClearSale .= '</ClearSale>';
		
		$xml = fopen('xmlClearSale.xml','w+');
		fwrite($xml, $xmlClearSale);
		fclose($xml);
		return $xmlClearSale;
    
	}
	
	public function gravaScore($idPedido,$score,$status)
	{
		$sql = "INSERT INTO clearSale(idPedido, score, status) values('".$idPedido."', '".$score."', '".$status."');";   
		$produtos  = $this->db->query($sql); 	  
	}
}
?>