<?php
class ControllerAccountNewfb extends Controller
{
    private $error = array();

    public function index()
    {

        error_reporting(~0);
        ini_set('display_errors', 1);

        $params = null;

        if ($this->customer->isLogged()) {
            $this->redirect(HTTPS_SERVER . 'index.php?route=account/account');
        }

        require_once(DIR_SYSTEM . 'vendor/newfb/facebook.php');

        $facebook = new Facebook(array(
            'appId' => $this->config->get('fbconnect_apikey'),
            'secret' => $this->config->get('fbconnect_apisecret'),
            'cookie' => true
        ));

        if (!isset($_COOKIE["facebookAccessToken"])) {

            if (isset($this->request->get["code"])) {

                $urlFace = "https://graph.facebook.com/oauth/access_token?" . "client_id=" . $this->config->get('fbconnect_apikey') . "&redirect_uri=" . urlencode(BASE_URL . "account/newfb") . "&client_secret=" . $this->config->get('fbconnect_apisecret') . "&code=" . $this->request->get['code'];

                $response = parse_str(file_get_contents("https://graph.facebook.com/oauth/access_token?" . "client_id=" . $this->config->get('fbconnect_apikey') . "&redirect_uri=" . urlencode(BASE_URL . "account/newfb") . "&client_secret=" . $this->config->get('fbconnect_apisecret') . "&code=" . $this->request->get['code']), $params);

                $graph_url = "https://graph.facebook.com/me?access_token=" . $params['access_token'];

                $user = json_decode(file_get_contents($graph_url), true);

                if (isset($user["username"])) {

                    setcookie("facebookAccessToken", $params['access_token']);

                    $email_query = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "customer WHERE facebook_id = '".$user['id']."'");

                    if ($email_query->num_rows) {
                        if ($this->customer->login(null, null, null, $user['id'])) {
                            $this->redirect(HTTPS_SERVER . 'index.php?route=account/account');
                        }
                    } else {

                        $config_customer_approval = $this->config->get('config_customer_approval');
                        $this->config->set('config_customer_approval', 0);

                        $add_data = array();
                        $add_data['email'] = $user['email'];
                        $add_data['password'] = "";
                        $add_data['firstname'] = isset($user['first_name']) ? $user['first_name'] : '';
                        $add_data['lastname'] = isset($user['last_name']) ? $user['last_name'] : '';
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
                        $add_data['facebook_id'] = $user['id'];
                        $add_data['twitter_id'] = "";

                        $this->load->model('account/customer');

                        $this->model_account_customer->addCustomer($add_data);

                        if ($this->customer->login(null,null,null,$user['id'])) {
                            $this->redirect(HTTPS_SERVER . 'index.php?route=account/account');
                        }
                    }
                }

            } else {
                print "dados do face nao encontrados";
                exit;

            }

            //print_R($fbuser_profile);

            $this->redirect(HTTPS_SERVER . 'index.php?route=account/account');

        }
        else
        {
            $graph_url = "https://graph.facebook.com/me?access_token=" . $_COOKIE["facebookAccessToken"];

            $user = json_decode(file_get_contents($graph_url), true);

            if ($this->customer->login(null,null,null,$user['id'])) {
                #ja tem acess token
                $this->redirect(HTTPS_SERVER . 'index.php?route=account/account');
            }
        }
    }
}
?>