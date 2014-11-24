<?php defined('BASEPATH') or exit('No direct script access allowed');

function smarty_block_link($params, $content = '', $template, &$repeat) {
	if($repeat)
		return;
	$uri = get_default($params, 'uri', '');
	unset($params['uri']);
	return anchor($uri, $content, $params);
}
