<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Loading all the sass file altogether, and compile the string as sass
 */
class SassCompiler extends Clips\Libraries\Sass {

	public $resolutions;

	public function widget($name) {
		if(is_array($name)) {
			foreach($name as $n) {
				$this->widget($n);
			}
		}
		else {
			if(isset($this->theme)) {
				$this->addSass('/themes/'.$this->theme.'/widgets/'.$name);
			}
		}
	}

	public function common($name) {
		if(is_array($name)) {
			foreach($name as $n) {
				$this->common($n);
			}
		}
		else
			$this->addSass('common/'.$name);
	}

	public function lib($name, $version = '1.0.0') {
		$this->addIncludePath(dirname(__FILE__).'/css/lib/'.$name.'-'.$version);
	}
}
