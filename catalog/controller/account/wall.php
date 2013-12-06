<?php 
class ControllerAccountWall extends Controller { 
	public function index() {

        /*
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=account/account';
	  
			$this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
		} 

        */
		$this->data['id_wall'] = $this->request->get['id_wall'];
		$this->data['origem'] = $this->request->get['origem'];    
		$this->data['id'] = $this->customer->getId(); 
		
		$this->load->model('account/wall');
		
		$this->data['name'] = $this->model_account_wall->getWallName($this->data['id_wall']);

        $this->data['friendship'] = array();

        $this->data['friendship'] = $this->model_account_wall->getFriendship($this->data['id_wall']);

        if(!isset($this->data['friendship']['confirm']))
            $this->data['friendship']['confirm'] = 0;

        $this->language->load('account/account');

		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=common/home',
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		); 

		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=account/account',
			'text'      => $this->language->get('text_account'),
			'separator' => $this->language->get('text_separator')
		);

		$this->document->title = $this->language->get('heading_title');

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_my_account'] = $this->language->get('text_my_account');
		$this->data['text_my_orders'] = $this->language->get('text_my_orders');
		$this->data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_password'] = $this->language->get('text_password');
		$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_history'] = $this->language->get('text_history');
		$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		### My Wish List - Start ###
		$this->data['text_mywishlist'] = $this->language->get('text_mywishlist');
		### My Wish List - End ###
        
        $this->load->model('account/wall');
        
        if($this->data['id_wall'] == $this->customer->getId())
        { 
        $this->data['pendingFriends'] = $this->model_account_wall->getPendingFriends($this->data['id']);    
        $this->data['myPendingFriends'] = $this->model_account_wall->getMyPendingFriends($this->data['id']);      
        }
        
        $this->data['friends'] = $this->model_account_wall->getFriends($this->data['id_wall']);
        
        foreach($this->data['friends'] as $key=>$value)
        {
            $this->data['friends'][$key]['avatar'] = $this->getAvatar($this->data['friends'][$key]);
            
            if(($this->data['friends'][$key]['toid'] == $this->data['id_wall']) and $this->data['friends'][$key]['confirm'] == "0")
            {
                unset($this->data['friends'][$key]);
            }
            elseif($this->data['friends'][$key]['fromid'] == $this->data['id_wall'] and $this->data['friends'][$key]['confirm'] == "0")
            {
                unset($this->data['friends'][$key]);
            }
            
        }
        
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['information'] = HTTPS_SERVER . 'index.php?route=account/edit';
		$this->data['password'] = HTTPS_SERVER . 'index.php?route=account/password';
		$this->data['address'] = HTTPS_SERVER . 'index.php?route=account/address';
		$this->data['history'] = HTTPS_SERVER . 'index.php?route=account/history';
		$this->data['download'] = HTTPS_SERVER . 'index.php?route=account/download';
		$this->data['newsletter'] = HTTPS_SERVER . 'index.php?route=account/newsletter';
		### My Wish List - Start ###
		$this->data['mywishlist'] = HTTPS_SERVER . 'index.php?route=account/mywishlist';
		### My Wish List - End ###           
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/wall.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/wall.tpl';
		} else {
			$this->template = 'default/template/account/wall.tpl';
		}
		
		$this->children = array(
			'common/column_right',
			'common/footer',
			'common/column_left',
			'common/header'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));		
	}
    
    public function getAvatar($row)
    {
        if(isset($row['facebook_id']))
        $imageUser = "https://graph.facebook.com/".$row['facebook_id']."/picture?width=50&height=50";
        
        return $imageUser;
    
        
    }
}
?>
