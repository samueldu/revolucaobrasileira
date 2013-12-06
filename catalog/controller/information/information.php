<?php 
class ControllerInformationInformation extends Controller {
	public function index() {  
    	$this->language->load('information/information');
		
		$this->load->model('catalog/information');
		
		$this->document->breadcrumbs = array();
		
      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	);
		
		if (isset($this->request->get['information_id'])) {
			$information_id = $this->request->get['information_id'];
		} else {
			$information_id = 0;
		}
		
		$information_info = $this->model_catalog_information->getInformation($information_id);
   		
		if ($information_info) {
	  		$this->document->title = $information_info['title']; 

      		$this->document->breadcrumbs[] = array(
        		'href'      => HTTP_SERVER . 'index.php?route=information/information&information_id=' . $this->request->get['information_id'],
        		'text'      => $information_info['title'],
        		'separator' => $this->language->get('text_separator')
      		);		
						
      		$this->data['heading_title'] = $information_info['title'];
      		
      		$this->data['button_continue'] = $this->language->get('button_continue');
			
			$this->data['description'] = html_entity_decode($information_info['description']);
      		
			$this->data['continue'] = HTTP_SERVER . 'index.php?route=common/home';
			
			if(TEMPLATE != "armazem")
			{
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/information/information.tpl';
				} else {
					$this->template = 'default/template/information/information.tpl';
				}
				
			
			}
			elseif($information_id != "11" and TEMPLATE == "armazem")
			{
				
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/information/information.tpl';
				} else {
					$this->template = 'default/template/information/information.tpl';
				}
			
			}
			elseif($information_id == "11" and TEMPLATE == "armazem")
			{				
							
				if($this->request->post)
				{

					$message = "";
					
					foreach($this->request->post as $key=>$value)
					{
						if($key != "enviar")
						$message .= $key. " : ".$value."<BR>";
					}
						$mail = new Mail();
						$mail->protocol = $this->config->get('config_mail_protocol');
						$mail->parameter = $this->config->get('config_mail_parameter');
						$mail->hostname = $this->config->get('config_smtp_host');
						$mail->username = $this->config->get('config_smtp_username');
						$mail->password = $this->config->get('config_smtp_password');
						$mail->port = $this->config->get('config_smtp_port');
						$mail->timeout = $this->config->get('config_smtp_timeout');				
						$mail->setTo("contato@modaarmazem.com.br");
						$mail->setFrom($this->config->get('config_email')); 
	  					$mail->setSender($this->config->get('config_name'));
	  					$mail->setTemplate("franquias");
	  					$mail->setSubject('Contato franquia');
						$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
						$mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));   
      					$mail->send();
      					$this->data['enviado'] = 1;
				}
				
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/franquias.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/information/franquias.tpl';
				} else {
				$this->template = 'default/template/information/information.tpl';
				}
			}
			
			$this->children = array(
				'common/column_right',
				'common/footer',
				'common/column_left',
				'common/header'
			);		
			
	  		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	} else {
      		$this->document->breadcrumbs[] = array(
        		'href'      => HTTP_SERVER . 'index.php?route=information/information&information_id=' . $this->request->get['information_id'],
        		'text'      => $this->language->get('text_error'),
        		'separator' => $this->language->get('text_separator')
      		);
				
	  		$this->document->title = $this->language->get('text_error');
			
      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = HTTP_SERVER . 'index.php?route=common/home';

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_right',
				'common/footer',
				'common/column_left',
				'common/header'
			);
		
	  		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	}
  	}
	
	public function loadInfo() {
		$this->load->model('catalog/information');
		if (isset($this->request->get['information_id'])) {
			$information_id = $this->request->get['information_id'];
		} else {
			if (isset($this->request->get['create'])) {
				$information_id = $this->config->get('config_account_id');
			} else {
				$information_id = $this->config->get('config_checkout_id');
			}
		}      
		$information_info = $this->model_catalog_information->getInformation($information_id);
		
		if($this->request->get['information_id'] == 4)
		{
			$output = '
			 <a href="javascript:dimOffx();" class="fechar"><img src="'.HTTP_IMAGE.'fechar.png" alt="Fechar" style="margin: -60px 0pt 0pt -20px; position: absolute;" /></a>
	<h3><b>'.$information_info['title'].'</b></h3><BR>';			
			$output .= html_entity_decode($information_info['description']);
		}
		else
	{

		$output = '
			<div id="content" style="margin: 0pt; padding: 0pt;">
			  <div class="top">
			    <div class="left"></div>
			    <div class="right"></div>
			    <div class="center">
			      <h1>'.$information_info['title'].'</h1>
			    </div>
			  </div>
			  <div class="middle">
			    <p>'.html_entity_decode($information_info['description']).'</p>
			  </div>
			  <div class="bottom">
			    <div class="left"></div>
			    <div class="right"></div>
			    <div class="center"></div>
			  </div>
			</div>';
		}

		$this->response->setOutput($output, $this->config->get('config_compression'));
	}
	
	  	public function validate() {
	
			$pattern = '/^[A-Z0-9._%-+]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i';
			if ((strlen(utf8_decode($this->request->post['email'])) > 96) || (!preg_match($pattern, $this->request->post['email']))) {
      		$this->error['email'] = $this->language->get('error_email');
    		}
    		
    		if (!$this->error) {
      		return TRUE;
    		} else {
      		return FALSE;
    		}
		}
}
?>