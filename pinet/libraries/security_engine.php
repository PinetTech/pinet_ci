<?php defined("BASEPATH") or exit("No direct script access allowed");

class Security_Engine {
	private $CI;

	public function __construct() { 
		$this->CI = &get_instance();
		$this->CI->load->model('security_model');
		$this->CI->load->helper(array('session'));
		$this->CI->load->helper(get_ci_config('security_helper'), array());
		$this->CI->load->library(array('clips', 'session'));
		$this->clips = $this->CI->clips;
	}

	public function validate($obj) {
		$this->clips->clear();
		if(is_string($obj)) {
			$obj = array('Column', $obj);
		}
		$this->clips->template(array('Pinet_User', 'Pinet_Anonymous_User', 'Pinet_Group'));
		$this->clips->assertFacts($obj);
		$this->loadRules();
		$this->clips->run();
		$this->clips->facts();
		$operation = $this->clips->queryFacts('operation');
		if($operation) {
			return $operation[0][0];
		}
		return 'deny'; // Deny as default
	}

	protected function loadRules() {
		$this->clips->load('ci://config/rules/user.rules');
		$this->clips->load('ci://config/rules/security.rules');
	}
}
