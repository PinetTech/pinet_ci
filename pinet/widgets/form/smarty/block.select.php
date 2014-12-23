<?php defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('smarty_function_input')) {
	require_once(dirname(__FILE__).'/function.function.input.php');
}

function smarty_block_select($params, $content, $template, &$repeat) {
	if($repeat) // Skip the first time
		return;

	$attr = get_attr($params, $template);
	$field = get_field($params, $template);

	$CI = &get_instance();
	if(isset($field->model)) {
		$CI->load->model($field->model);
		$options = widget_select_get_options($template, $params, $field, $CI->{$field->model});
	}
	else {
		$options = get_default($params, 'options', array());
	}

	$parent_vars = $template->parent->tpl_vars;
	$form_data = get_form_data($parent_vars);
	$selected = get_default($params, 'selected', array());
	$extra = _parse_form_attributes($attr, array());
	if(count($selected) == 0)
		$selected = $attr['value'];
	return form_dropdown($attr['name'], $options, $selected, $extra);
}

function widget_select_get_options($template, $params, $field, $model = null) {
	$ret = get_default($params, 'options', array(-1 =>  '-- Please Select --'));
	if(isset($model)) {
		$value_col = 'value';
		if(isset($field->value_col)) {
			$value_col = $field->value_col.' as value';
		}
		$model->select('id', $value_col);
		$query = true;
		if(isset($field->filters) && is_object($field->filters)) {
			foreach($field->filters as $k => $v) {
				if(is_object($v)) { // This is dynamic filter
					$parent_vars = $template->parent->tpl_vars;
					$form_data = get_form_data($parent_vars);
					$f = $v->field;
					ci_log('The dynamic field is %s, and value is %s and key is %s', $f, $form_data->$f, $k);
					if(isset($form_data) && isset($form_data->$f)) {
						$model->where($k, $form_data->$f);
					}
					else {
						$query = false;
					}
				}
				else {
					$model->where($k, $v);
				}
			}
		}

		if($query)
			$ret = array_reduce($model->get_all(), function($carry, $item) {$carry[$item['id']] = $item['value'];
				return $carry;}, $ret);
	}
	return $ret;
}
