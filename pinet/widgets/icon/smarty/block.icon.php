<?php defined("BASEPATH") or exit("No direct script access allowed");

function smarty_block_icon($params, $content = '', $template, &$repeat) {
	if($repeat) {
		return;
	}

	if(!$params['type']) {
		trigger_error('The widget '.$name.' is existed!!!');
		return -1;
	}

	$type = get_default($params, 'type');

	$tag = get_default($params, 'tag', 'i');

	if(isset($params['tag'])) {
		unset($params['tag']);
	}

	$params['class'] = make_classes('glyphicon', 'glyphicon-'.$type, get_default($params, 'class', null));
	return create_tag($tag, $params, array(), $content);
}
