<?php defined("BASEPATH") or exit("No direct script access allowed");

class Security_Engine {
	private $CI;
	const CLIPS_SECURITY_ENV = "SECURITY";

	public function __construct() { 
		$this->CI = &get_instance();
		$this->CI->load->model('security_model');
		$this->CI->load->helper(array('session'));
		$this->CI->load->helper(get_ci_config('security_helper'), array());
		$this->CI->load->library(array('session'));
		$this->clips = $this->CI->clips;
		$this->clips->createEnv(Security_Engine::CLIPS_SECURITY_ENV);
	}

	public function validate($obj) {
		return $this->clips->runWithEnv(Security_Engine::CLIPS_SECURITY_ENV, function($clips, $obj){
			$clips->clear();
			$clips->template(array('Pinet_User', 'Pinet_Anonymous_User', 'Pinet_Group', 'Action', 'FormField'));
			$clips->load('ci://config/rules/user.rules');
			$clips->load('ci://config/rules/security.rules');
			if(is_string($obj)) {
				$obj = array('Column', $obj);
			}
			$clips->assertFacts($obj);
			$clips->run();
			$operation = $clips->queryFacts('operation');
			if($operation) {
				return $operation[0][0];
			}
			return 'deny'; // Deny as default
		}, $obj);
	}
}
