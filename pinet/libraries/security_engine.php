<?php defined("BASEPATH") or exit("No direct script access allowed");

class SecurityDataTableColumn {
	public $name;
	public $data;
	public $type;

	public function __construct($obj) {
		if(is_string($obj))
			$obj = array('name' => $obj);
		$this->name = get_default($obj, 'name', null);
		$this->data = get_default($obj, 'data', null);
		$this->type = get_default($obj, 'type', null);
	}
}

class Security_Engine {
	private $CI;
	const CLIPS_SECURITY_ENV = "SECURITY";
	public $classes = array('Pinet_User', 'Pinet_Anonymous_User', 'Pinet_Group', 'Action', 'FormField', 'SecurityDataTableColumn');

	public function __construct() { 
		$this->CI = &get_instance();
		$this->CI->load->model('security_model');
		$this->CI->load->helper(array('session'));
		$sh = get_ci_config('security_helper');
		if($sh)
			$this->CI->load->helper($sh, array());
		$this->CI->load->library(array('session'));
		$this->clips = $this->CI->clips;
		$this->clips->createEnv(Security_Engine::CLIPS_SECURITY_ENV);
		$this->logger = $this->CI->tool->getLogger(get_class($this));
	}

	public function validate($obj) {
		return $this->clips->runWithEnv(Security_Engine::CLIPS_SECURITY_ENV, function($clips, $obj){
			$clips->clear();
			$c = array();
			foreach($this->classes as $class) {
				if(class_exists($class))
					$c []= $class;
			}
			$clips->template($c);
			$clips->load('ci://config/rules/user.rules');
			$clips->load('ci://config/rules/security.rules');
			if(is_string($obj) || is_object($obj) && get_class($obj) == 'DataTableColumn') {
				$obj = new SecurityDataTableColumn($obj);
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
