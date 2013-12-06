<?php
class ControllerAccountTwconnect extends Controller {
	private $error = array();

  	public function index() {

		if ($this->customer->isLogged()) {
	  		$this->redirect('account/account');
    		}

		$this->language->load('module/fbconnect');

        require_once(DIR_SYSTEM . 'vendor/twitter/twitteroauth.php');

        $twitteroauth = new TwitterOAuth("XVDYcwUI0SL74udtjBP9A", "YZ46nwxrbALqfrjhOUUcC1abHPIJULBNom7neJaOI");
// Requesting authentication tokens, the parameter is the URL we will be redirected to
        $request_token = $twitteroauth->getRequestToken(BASE_URL.'account/gettwitterdata');

// Saving them into the session

        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

// If everything goes well..
        if ($twitteroauth->http_code == 200) {
            // Let's generate the URL and redirect
            $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
            header('Location: ' . $url);
        } else {
            // It's a bad idea to kill the script, but we've got to know when there's an error.
            die('Something wrong happened.');
        }
          //$this->redirect(HTTPS_SERVER . 'index.php?route=account/account');

	}

	private function get_password($str) {
		$password = $this->config->get('fbconnect_pwdsecret') ? $this->config->get('fbconnect_pwdsecret') : '';
		//$password.=substr($this->config->get('fbconnect_apisecret'),0,3).substr($str,0,3).substr($this->config->get('fbconnect_apisecret'),-3).substr($str,-3);
		return strtolower($password);
	}

	private function clean_decode($data) {
    		if (is_array($data)) {
	  		foreach ($data as $key => $value) {
				unset($data[$key]);
				$data[$this->clean_decode($key)] = $this->clean_decode($value);
	  		}
		} else {
	  		$data = htmlspecialchars_decode($data, ENT_COMPAT);
		}

		return $data;
	}
}
?>