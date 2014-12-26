<?php defined('BASEPATH') or exit('No direct script access allowed');

function smarty_function_css($params, $template) {
	$CI = &get_instance();
	foreach($CI->cssFiles as $css) {
		echo $css->render();
	}

	if(isset($CI->sasscompiler)) {
		$meta = get_controller_meta();
		$name = $meta->controller.'-'.$meta->method.'.css';
		$dir = 'cache/css/';

		if(!file_exists(FCPATH.APPPATH.$dir)) {
			mkdir(FCPATH.APPPATH.$dir, 0755, true);
		}

		$file_name = FCPATH.APPPATH.$dir.$name;
		if(!file_exists($file_name) || get_ci_config('debug_sass')) {
			ci_log('The compiler is ', $CI->sasscompiler);
			file_put_contents($file_name, $CI->sasscompiler->compile());
		}
		return '<link rel="stylesheet" href="'.site_url(APPPATH.$dir.$name).'">';
	}
}
