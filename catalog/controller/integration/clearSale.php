<?
class ControllerIntegrationClearSale extends Controller {
    private $error = array();
     
      public function index() {
    
        if (($this->request->server['REQUEST_METHOD'] == 'POST')){
            
        $this->load->model('integration/clearSale'); 
        
        $this->model_integration_clearsale->insert($this->request->post);   
            
        } 
}
?>