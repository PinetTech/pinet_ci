<?php defined("BASEPATH") or exit("No direct script access allowed");

class Welcome extends Pinet_Controller {

    public $title = 'iBox Registration';
    public $messages = 'welcome';

    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
    }

    public function index(){

    }

    public function switch_lang(){
        $url = '';
        if($this->session->userdata('need_to_redirect_url')){
            $url = $this->session->userdata('need_to_redirect_url');
            $this->session->unset_userdata('need_to_redirect_url');
        }
        $this->setLang($this->input->post('language'));
        redirect($url);
    }

    public function registration() {
        $this->jqBootstrapValidation();
        $this->load->library('session');
        $this->session->set_userdata('need_to_redirect_url', current_url());
        $this->init_responsive();
        $this->less('home/registration_css');
        $form_data = new stdClass();
        $serial = exec('/usr/local/bin/pinet serial read');
        $pinet_url = exec('/usr/local/bin/pinet url read');
        $pinet_url .= substr($pinet_url, -1, 1) == '/' ? 'ibox/register' : '/ibox/register';
        $form_data->serial = $serial;
        $this->render('home/registration', array('form_data'=>$form_data, 'pineturl'=>$pinet_url));
    }
 }
