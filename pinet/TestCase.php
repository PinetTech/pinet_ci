<?php namespace Pinet; in_array(__FILE__, get_included_files()) or exit("No direct sript access allowed");

class TestCase extends \PHPUnit_Framework_TestCase {
	public function setUp() {
		$mute = (getenv('MUTE_PHPUNIT'));
		$ref = new \ReflectionClass($this);
		$func = $this->getName();
		if(!$mute && $func != 'testStub')
			echo "\n----------".$ref->name." | ".$func."----------\n";
		$this->CI =& get_instance();
		$this->tool = &get_clips_tool();
		$this->doSetUp();
	}

	public function helper($name) {
		$this->CI->load->helper($name);
	}

	public function library($name, $alias = null) {
		if(is_array($name)) {
			$ret = array();
			foreach($name as $n) {
				$ret []= $this->library($n);
			}
			return $ret;
		}

		$this->CI->load->library($name);
		if($alias) {
			$this->$alias = $this->CI->$name;
		}
		else {
			$this->$name = $this->CI->$name;
		}

		return $this->CI->$name;
	}
	public function model($name, $alias = null) {
		if(is_array($name)) {
			$ret = array();
			foreach($name as $n) {
				$ret []= $this->model($n);
			}
			return $ret;
		}

		$this->CI->load->model($name);
		if($alias) {
			$this->$alias = $this->CI->$name;
		}
		else {
			$this->$name = $this->CI->$name;
		}

		return $this->CI->$name;
	}

	public function url($url) {
		return site_url($url);
	}

	public function tearDown() {
		$ref = new \ReflectionClass($this);
		$this->doTearDown();
		$func = $this->getName();
		$mute = (getenv('MUTE_PHPUNIT'));
		if(!$mute && $func != 'testStub')
			echo "\n==========".$ref->name." | ".$func."==========\n";
		if (ob_get_length() == 0 ) {
			ob_start();
    }
	}

	public function testStub() {
	}

	public function doSetUp() {
	}

	public function doTearDown() {
	}
}
