<?php
class ControllerAccountGettwitterdata extends Controller {
    private $error = array();

    public function index() {

        require_once(DIR_SYSTEM . 'vendor/twitter/twitteroauth.php');

       // if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
            // We've got everything we need
            $twitteroauth = new TwitterOAuth("XVDYcwUI0SL74udtjBP9A", "YZ46nwxrbALqfrjhOUUcC1abHPIJULBNom7neJaOI", $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
        // Let's request the access token
            $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
        // Save it in a session var
            $_SESSION['access_token'] = $access_token;
        // Let's get the user's info
            $user_info = $twitteroauth->get('account/verify_credentials');
        // Print user's info
            if (isset($user_info->error)) {
                // Something's wrong, go back to square 1
                header('Location: login-twitter.php');
            } else {
               $twitter_otoken=$_SESSION['oauth_token'];
               $twitter_otoken_secret=$_SESSION['oauth_token_secret'];
                $email='';
                $uid = $user_info->id;
                $name = $user_info->name;
                $username = $user_info->screen_name;

                $this->load->model('account/customer');

                $password = '';

                $email_query = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "customer WHERE twitter_id = '" . $uid . "'");

                if($email_query->num_rows){
                     if($this->customer->login($email, $password,$uid)){
                        $this->redirect(HTTPS_SERVER . 'index.php?route=account/account');
                    }
                }
                else
                {
                    $config_customer_approval = $this->config->get('config_customer_approval');
                    $this->config->set('config_customer_approval',0);

                    $add_data=array();
                    $add_data['email'] = $email;
                    $add_data['password'] = $password;
                    $add_data['firstname'] = $name;
                    $add_data['lastname'] = $username;
                    $add_data['fax'] = '';
                    $add_data['telephone'] = '';
                    $add_data['company'] = '';
                    $add_data['address_1'] = '';
                    $add_data['address_2'] = '';
                    $add_data['city'] = '';
                    $add_data['postcode'] = '';
                    $add_data['country_id'] = 0;
                    $add_data['zone_id'] = 0;
                    $add_data['dataNasc'] = 0;
                    $add_data['address_3'] = 0;
                    $add_data['bairro'] = 0;
                    $add_data['newsletter'] = 0;
                    $add_data['cpfCnpj'] = 0;
                    $add_data['rg'] = 0;
                    $add_data['sexo'] = 0;
                    $add_data['twitter_id'] = $uid;

                    $this->model_account_customer->addCustomer($add_data);
                    $this->config->set('config_customer_approval',$config_customer_approval);

                    if($this->customer->login($email, $password,$uid)){
                        $this->redirect(HTTPS_SERVER . 'index.php?route=account/success');
                    }
                }
            }
       // } else {
            // Something's missing, go back to square 1
        //    header('Location: login-twitter.php');
        //}
    }
}
?>
