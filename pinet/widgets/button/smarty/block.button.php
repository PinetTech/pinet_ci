<?php defined('BASEPATH') or exit('No direct script access allowed');

function smarty_block_button($params, $content = '', $template, &$repeat) {
	if($repeat) {
		return;
	}

	$tag = get_default($params, 'tag', 'button');

	if(isset($params['tag'])) {
		unset($params['tag']);
	}

	$show = get_default($params, 'show', 'default');

	if($tag == 'input' && !isset($params['type']))
		$params['type'] = 'button';

	$params['class'] = make_classes('btn', 'btn-'.$show, get_default($params, 'class', null));

	if($tag == 'input' && !isset($params['value'])) {
		$params['value'] = $content;
	}

	$params['role'] = 'button';

	if(!isset($params['title'])) {
		$params['title'] = strip_tags($content);
	}

	if($tag == 'input')
		return create_tag('input', $params, array());
	return create_tag($tag, $params, array(), $content);
}
