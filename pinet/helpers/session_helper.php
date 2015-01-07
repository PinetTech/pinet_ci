<?php defined('BASEPATH') or exit('No direct script access allowed');

function cookie_set($args) {
	$CI = &get_instance();
	if($CI->input->is_cli_request()) // Skip the breadscrum for cli request
		return false;
	return call_user_func_array('set_cookie', $args);
}

function session_get($name) {
	$CI = &get_instance();
	if(isset($CI->session))
		return $CI->session->userdata($name);
	return false;
}

function session_del($name) {
	$CI = &get_instance();
	if(isset($CI->session)) {
		return $CI->session->unset_userdata($name);
	}
	return false;
}

function session_set($name, $value) {
	$CI = &get_instance();
	if(isset($CI->session))
		return $CI->session->set_userdata($name, $value);
	return false;
}
