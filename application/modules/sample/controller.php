<?php defined("BASEPATH") or exit("No direct script access allowed");

class Sample_Module extends Pinet_Module {
	public function __construct() {
		parent::__construct();
		$this->library('mesh_page');
	}

	public function getTheme() {
		return 'sample';
	}

	public function index() {
		echo 'Hello';
	}

	public function mesh() {
		$this->mesh_page->render('jack', array('i' => 100));
	}

	public function sass() {
		$widget = array();
		$actions = array(
			new Action('r', '/', '/'),
			new Action('s', '/', '/'),
			new Action('s', '/', '/')
		);
		$items = array(
			array('uri'=>'/', 'label'=>'g'),
			array('uri'=>'/', 'label'=>'e'),
			array('uri'=>'/', 'label'=>'s')
		);
		// $this->widget(array('bootstrap'));
		// $w = $this->widget(array('button'));
		// $this->widget(array('grid'));
		// $this->widget(array('jquery_ui_common', 'form'));
		array_push($widget, 'html');
		array_push($widget, 'grid');
		array_push($widget, 'button');
		$tpl = 'html';
		$this->widget($widget);
		$this->CI->scss('test');
		$this->render('hello', array('i' => 100, 'items'=> $items, 'actions'=>$actions));
	}

	public function test() {
		$w = $this->widget(array('sample','example'));
		$this->render('hello', array('i' => 100));
	}
}
