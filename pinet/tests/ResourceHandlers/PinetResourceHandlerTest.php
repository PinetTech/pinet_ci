<?php defined('BASEPATH') or exit('No direct script access allowed');

class PinetResourceHandlerTest extends Pinet\TestCase {
	public function testPinetResourceHandler() {
		$r = new Clips\Resource("pinet://ResourceHandlers/PinetResourceHandler.php");
		$this->assertNotNull($r->contents());
	}
}
