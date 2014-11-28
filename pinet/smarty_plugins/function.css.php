<?php defined('BASEPATH') or exit('No direct script access allowed');

function smarty_function_css($params, $template) {
	$CI = &get_instance();
	foreach($CI->cssFiles as $css) {
		echo $css->render();
	}

	if(isset($CI->sasscompiler)) {
		ci_log('The compiler is ', $CI->sasscompiler);
		echo "<style>\n";
		echo $CI->sasscompiler->compile();
		echo "</style>\n";
	}
}
