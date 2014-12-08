<?php defined("BASEPATH") or exit("No direct script access allowed");

function smarty_function_example($params, $template) {
	return create_tag('h1', $params, array(), 'Hello from Example Widget');
}
