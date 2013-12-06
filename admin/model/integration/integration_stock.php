<?php 
class ModelIntegrationIntegrationStock extends Model {
	
	private $wsdl = '';
	private $namespace = '';
	private $client = '';
	
	public function getData($client,$note){
		try {
			$this->wsdl ='http://201.48.211.33:8080/chbweb/servlet/awsnfiscal?wsdl';
			$this->namespace="urn:xmethods-BNPriceCheck";
			$this->client = new soapclient($this->wsdl);
			$param = array("Ft07codemp"=>17,"Sistema"=>'GWSYSTEM',"Cliente"=>$client,"Modelo"=>'EP',"Nota"=>$note);
			$return = $this->client->Execute($param);
			echo "OI";
			$return = (array) $return;
			return $return;
		}catch (SoapFault $exception){
			echo "<pre>";
			echo $exception;
			echo "</pre>";
		}catch(Exception $exception){
			echo "<pre>";
			echo $exception;
			echo "</pre>";
		}
	}
}
?>