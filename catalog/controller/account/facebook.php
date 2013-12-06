<body onload="window.open('', '_self', '');">
<?
class ControllerAccountFacebook extends Controller {	
	public function index() {
		
		$urlSite  = HTTPS_SERVER;
		$url = $urlSite."account/facebook/";
		
		if(!isset($this->session->data['amigos']))
		{

		$buffer = "";
		$urlEnvia = 'https://graph.facebook.com/oauth/access_token?client_id='.$this->config->get('config_face_comm_app').'&redirect_uri='.$url.'&client_secret='.$this->config->get('config_face_comm_secret').'&code='.$_GET['code'];
		
		//print $urlEnvia; 
		
		$cUrl = curl_init();         
		curl_setopt($cUrl, CURLOPT_URL, $urlEnvia); 
		curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($cUrl, CURLOPT_TIMEOUT, '3'); 
		curl_setopt($cUrl, CURLOPT_PROXY, $buffer); 
		$pageContent = trim(curl_exec($cUrl)); 
		curl_close($cUrl); 
		$arr = explode("&",$pageContent);
		$var = explode("=",$arr[0]);
		
		//print_r($pageContent);

		$this->session->data['facebook_token'] = $var[1];	
		
		$url = 'https://graph.facebook.com/me/friends?access_token='.$var[1];

		$cUrl = curl_init();         
		curl_setopt($cUrl, CURLOPT_URL, $url); 
		curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($cUrl, CURLOPT_TIMEOUT, '3'); 
		curl_setopt($cUrl, CURLOPT_PROXY, $buffer); 
		$pageContent = trim(curl_exec($cUrl)); 
		curl_close($cUrl);          
		$this->session->data['amigos'] = json_decode($pageContent); 
		$_SESSION['amigos'] = json_decode($pageContent); 
		}
  
	}
		
	public function compartilha(){
			
	if(isset($this->request->get['action']) and ($this->request->get['action'] == "compartilha"))
		{	
			
			if(!isset($this->request->post['name']))
			$this->request->post['name'] = $this->request->get['name'];
			
			$explode = explode(",",$this->request->post['name']);
				
			foreach($explode as $key=>$value)
			{
				foreach($_SESSION['amigos']->data as $faceKey)
				{
					if($faceKey->id == $value)
					{
						$arrayPosta[$faceKey->id] = $faceKey->name;
					} 
				}
			}
		}
		
		$this->postaWall($arrayPosta);
	}
			
	public function postaWall($ids)
	{

		require(DIR_SYSTEM.'library/facebook/src/facebook.php');

		// Create our Application instance (replace this with your appId and secret).
		/*
		$facebook = new Facebook(array(
		  'appId'  => '182679918453386',
		  'secret' => '42cb96ab47671729f6ae3a94c1e0257f',
		));
		*/
		
		$facebook = new Facebook(array(
		  'appId'  => $this->config->get('config_face_comm_app'),
		  'secret' => $this->config->get('config_face_comm_secret'),
		));

		
		foreach($ids as $key=>$value)
		{	
			$facebook->api("/".$key."/feed", "post", array(
			'access_token' => $this->session->data['facebook_token'], 
			"message"=>HTTP_SERVER,
			"name"=>$value,
			"link"=>HTTP_SERVER,
			"description"=>"Visite o site da Armazem",
			"picture"=>"http://rlv.zcache.com/music_pirate_piracy_anti_riaa_icon_card-p137014261316431105q0yk_400.jpg",
			"caption"=>"Pirata",
			'actions' => json_encode(array('name' => 'Confira','link' => HTTP_SERVER))));
			
		}
	}
}

/*
class ControllerAccountFacebook extends Controller {	
	public function index() {

		print $_GET['code'];
			$token = $this->get_token($_GET['code']);
			
			print $token;

			$this->get_friends($token);
	}

	public function get_friends($token)
	{
		//print $token;
		$buffer = '';
		$url = 'https://graph.facebook.com/me/friends?access_token='.$token;
		$cUrl = curl_init();         
		curl_setopt($cUrl, CURLOPT_URL, $url); 
		curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($cUrl, CURLOPT_TIMEOUT, '3'); 
		curl_setopt($cUrl, CURLOPT_PROXY, $buffer); 
		$pageContent = trim(curl_exec($cUrl)); 
		print_r($pageContent);
		curl_close($cUrl);          
		$_SESSION['amigos'] = json_decode($pageContent);   
	}
	
	
	public function get_token($code)
	{
		$params=array('client_id'=>'182679918453386', 
		'client_secret'=>'42cb96ab47671729f6ae3a94c1e0257f',
		'redirect_uri'=>'http://www.lojavilla.com.br/loja/account/facebook/',
		'code'=>$code);
		$url = "https://graph.facebook.com/oauth/access_token";
		$access_token = $this->callFb($url, $params);
		print_r($access_token);
		$access_token = substr($access_token, strpos($access_token, "=")+1, strlen($access_token));
		$_SESSION['facebook_token'] = $access_token;
		return $_SESSION['facebook_token'];
	}
	
	public function callFb($url, $params)
	{
	    $ch = curl_init();
	    curl_setopt_array($ch, array(
	        CURLOPT_URL => $url,
	        CURLOPT_POSTFIELDS => http_build_query($params),
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_VERBOSE => true
	    ));

	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
	}
}
*/