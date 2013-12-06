<?php
class ControllerModuleDeadcowSEO extends Controller {
    private $error = array();

    public function install() {
        // enable the module and set default settings
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('deadcow_seo', array('deadcow_seo_status' => 1,
                                                                      'deadcow_seo_categories_template' => '[category_name]',
                                                                      'deadcow_seo_products_template' => '[product_name]-[model_name]',
                                                                      'deadcow_seo_manufacturers_template' => '[manufacturer_name]',
                                                                      'deadcow_seo_meta_template' => '[product_name],[categories_names], [manufacturer_name], [store_name]',
                                                                      'deadcow_seo_meta_template_description' => '[product_name],[categories_names], [manufacturer_name], [store_name]',
                                                                      'deadcow_seo_meta_template_cat' => '[product_name],[categories_names], [manufacturer_name], [store_name]',
                                                                      'deadcow_seo_meta_template_cat_description' => '[product_name],[categories_names], [manufacturer_name], [store_name]',
                                                                      'deadcow_seo_yahoo_id' => '',
                                                                      'deadcow_seo_yahoo_checkbox' => 0
                                                                 ));
    }

    public function index() {
        $this->load->language('module/deadcow_seo');
        $this->document->title = $this->language->get('heading_title');
        $this->load->model('setting/setting');
        $this->load->model('module/deadcow_seo');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            if (isset($this->request->post['categories'])) {
                $this->model_module_deadcow_seo->generateCategories($this->request->post['categories_template']);
            }
            if (isset($this->request->post['products'])) {
                $this->model_module_deadcow_seo->generateProducts($this->request->post['products_template']);
            }
            if (isset($this->request->post['manufacturers'])) {
                $this->model_module_deadcow_seo->generateManufacturers($this->request->post['manufacturers_template']);
            }
            if (isset($this->request->post['meta_keywords'])) {
                if (!isset($this->request->post['yahoo_checkbox'])) {
                    
                    $template['meta_template'] = $this->request->post['meta_template'];
                    $template['meta_template_description'] = $this->request->post['meta_template_description'];
                    
                    $this->model_module_deadcow_seo->generateMetaKeywords($template);
                    
                    
                } else if (trim($this->request->post['yahoo_id']) != '') {
                    $this->model_module_deadcow_seo->generateMetaKeywords($this->request->post['meta_template'], trim($this->request->post['yahoo_id']));
                } else {
                    $this->error['warning'] = $this->language->get('enter_yahoo_id');
                }
            }
            
            if (isset($this->request->post['meta_keywords_cat'])) {
                    $template['meta_template_cat'] = $this->request->post['meta_template_cat'];
                    $template['meta_template_cat_description'] = $this->request->post['meta_template_cat_description'];
                    $this->model_module_deadcow_seo->generateMetaKeywordsCat($template);
            }
            

            $this->model_setting_setting->editSetting('deadcow_seo', array('deadcow_seo_categories_template' => $this->request->post['categories_template'],
                                                                          'deadcow_seo_products_template' => $this->request->post['products_template'],
                                                                          'deadcow_seo_manufacturers_template' => $this->request->post['manufacturers_template'],
                                                                          'deadcow_seo_meta_template' => $this->request->post['meta_template'],
                                                                          'deadcow_seo_meta_template_description' => $this->request->post['meta_template_description'],  
                                                                          'deadcow_seo_meta_template_cat' => $this->request->post['meta_template_cat'],
                                                                          'deadcow_seo_meta_template_cat_description' => $this->request->post['meta_template_cat_description'],  
                                                                          'deadcow_seo_yahoo_id' => $this->request->post['yahoo_id'],
                                                                          'deadcow_seo_yahoo_checkbox' => isset($this->request->post['yahoo_checkbox']) ? 1 : 0
                                                                     ));
                                                                     
   
            if (isset($this->error['warning'])) {
                $this->data['error_warning'] = $this->error['warning'];
            } else {
                $this->data['success'] = $this->language->get('text_success');
            }

        }
        $this->data['warning_clear'] = $this->language->get('warning_clear');
        $this->data['back'] = $this->language->get('back');
        $this->data['categories'] = $this->language->get('categories');
        $this->data['products'] = $this->language->get('products');
        $this->data['manufacturers'] = $this->language->get('manufacturers');
        $this->data['meta_keywords'] = $this->language->get('meta_keywords');
        $this->data['generate'] = $this->language->get('generate');
        $this->data['append_model'] = $this->language->get('append_model');
        $this->data['template'] = $this->language->get('template');
        $this->data['available_category_tags'] = $this->language->get('available_category_tags');
        $this->data['available_product_tags'] = $this->language->get('available_product_tags');
        $this->data['available_manufacturer_tags'] = $this->language->get('available_manufacturer_tags');
        $this->data['available_meta_tags'] = $this->language->get('available_meta_tags');
        $this->data['your_yahoo_id'] = $this->language->get('your_yahoo_id');
        $this->data['get_yahoo_id'] = $this->language->get('get_yahoo_id');
        $this->data['add_from_yahoo'] = $this->language->get('add_from_yahoo');
        $this->data['curl_not_enabled'] = $this->language->get('curl_not_enabled');

        if (isset($this->request->post['categories_template'])) {
            $this->data['categories_template'] = $this->request->post['categories_template'];
        } else {
            $this->data['categories_template'] = $this->config->get('deadcow_seo_categories_template');
        }
        if (isset($this->request->post['products_template'])) {
            $this->data['products_template'] = $this->request->post['products_template'];
        } else {
            $this->data['products_template'] = $this->config->get('deadcow_seo_products_template');
        }
        if (isset($this->request->post['manufacturers_template'])) {
            $this->data['manufacturers_template'] = $this->request->post['manufacturers_template'];
        } else {
            $this->data['manufacturers_template'] = $this->config->get('deadcow_seo_manufacturers_template');
        }
        if (isset($this->request->post['meta_template'])) {
            $this->data['meta_template'] = $this->request->post['meta_template'];
        } else {
            $this->data['meta_template'] = $this->config->get('deadcow_seo_meta_template');
        }
        
        if (isset($this->request->post['meta_template_description'])) {
            $this->data['meta_template_description'] = $this->request->post['meta_template_description'];
        } else {
            $this->data['meta_template_description'] = $this->config->get('deadcow_seo_meta_template_description');
        }
        
        if (isset($this->request->post['meta_template_cat_description'])) {
            $this->data['meta_template_cat_description'] = $this->request->post['meta_template_cat_description'];
        } else {
            $this->data['meta_template_cat_description'] = $this->config->get('deadcow_seo_meta_template_cat_description');
        }
               
        if (isset($this->request->post['meta_template_cat'])) {
            $this->data['meta_template_cat'] = $this->request->post['meta_template_cat'];
        } else {
            $this->data['meta_template_cat'] = $this->config->get('deadcow_seo_meta_template_cat');
        }

        if (isset($this->request->post['yahoo_id'])) {
            $this->data['yahoo_id'] = $this->request->post['yahoo_id'];
        } else {
            $this->data['yahoo_id'] = $this->config->get('deadcow_seo_yahoo_id');
        }
        $this->data['yahoo_checkbox'] = isset($this->request->post['yahoo_checkbox']) ? 1 : 0;
        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array('href' => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'], 'text' => $this->language->get('text_home'), 'separator' => FALSE);
        $this->document->breadcrumbs[] = array('href' => HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token'], 'text' => $this->language->get('text_module'), 'separator' => ' :: ');
        $this->document->breadcrumbs[] = array('href' => HTTPS_SERVER . 'index.php?route=module/deadcow_seo&token=' . $this->session->data['token'], 'text' => $this->language->get('heading_title'), 'separator' => ' :: ');
        $this->data['action'] = HTTPS_SERVER . 'index.php?route=module/deadcow_seo&token=' . $this->session->data['token'];
        $this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token'];
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->template = 'module/deadcow_seo.tpl';
        $this->children = array('common/header', 'common/footer');
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/deadcow_seo')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
} 