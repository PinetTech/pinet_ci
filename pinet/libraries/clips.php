<?php in_array(__FILE__, get_included_files()) or exit("No direct sript access allowed");

class Clips extends Clips\Engine {
	public function __construct($name = CLIPS_MAIN_ENV) {
		get_clips_tool();
		parent::__construct($name);
	}
}
