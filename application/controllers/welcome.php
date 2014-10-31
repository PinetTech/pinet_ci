<?php defined("BASEPATH") or exit("No direct script access allowed");

class Welcome extends Pinet_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){

    }

    public function registration() {
        $this->jqBootstrapValidation();
        $this->load->library('session');
        $this->session->set_userdata('need_to_redirect_url', current_url());
        $this->init_responsive();
        $this->less('home/registration_css');
        $this->render('home/registration');
    }
 }
