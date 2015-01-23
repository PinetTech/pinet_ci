<?php namespace Pinet\Sass; in_array(__FILE__, get_included_files()) or exit("No direct sript access allowed");

/**
 *	Author: andy
 *	Date: 三  1/14 11:22:25 2015
 * 
 * 	Three support resolutions type
 *	$resolutions = array(320, 480, 640);
 *	$resolutions = array(320=>'device1', 480, 640);
 *	$resolutions = array('device1'=>320, 480, 640);
 */

class AutoResolution extends \Clips\Libraries\Sass\SassPlugin {

	public function prefix($compiler) {
		$this->appendVariables($this->getResolutions($compiler),
		   	$compiler);
	}

	public function suffix($compiler) {
		$resolutions = $this->getResolutions($compiler);

		$this->addBeforeResponsive($compiler);
		foreach($resolutions as $k => $r) {
			 if (is_numeric($k) && is_string($r) && !is_numeric($r) ) {
			 	$screen_width = $k;
			 	$alias_width =$r;
			 }
			 else if (is_numeric($k) && is_numeric($r)) {
			 	$screen_width = $r;
			 	$alias_width = 0;
			 }
			 else if (is_string($k) && !is_numeric($k)) {
			 	$screen_width = $r;
			 	$alias_width =$k;
			 }
			 else {
			 	$screen_width = $k;
			 	$alias_width =0;
			 }

			$next_value = get_array_next($resolutions, $r);
			if (is_string($next_value[1])) {
				$next_screen_width = $next_value[0];
			}
			else {
				$next_screen_width = $next_value[1];
			}

			if (!$next_screen_width) {
				$next_screen_width = 2881;
			}

			$this->addBeforeResolution($compiler, $screen_width);
			$compiler->suffix .= clips_out('media', array(
				'media'=> '@media screen and (min-width: '.$screen_width.'px) {', 
				'variables'=>array(array('variable'=>'$screen-width:'.$screen_width), array('variable'=>'$alias-width:'. $alias_width))
			), false);
		 	$this->addPrependResolution($compiler, $screen_width);
			foreach($compiler->sasses as $s) {
				$s = str_replace('.scss', '', $s);
				$basename = basename($s);
				$name = str_replace('/', '_', $s);
				if($basename == $name) {
					$this->addConstruct($basename, $compiler, $screen_width.','.$alias_width);
				}else {
					$names = explode('/', $s);
					$index = array_search('scss', $names);
					if ($index) {
						array_splice($names, 0, $index+1);
						$name = implode('_', $names);
					}
					$this->addConstruct($name, $compiler, $screen_width.','.$alias_width);
				}
			}
			$this->addAppendResolution($compiler, $screen_width);
			$compiler->suffix .= '}'."\n";
			// $compiler->suffix .= '@media screen and (min-width: '.$screen_width.'px) and (max-width: '.($next_screen_width - 1).'px)  {'."\n";
			// $compiler->suffix .= '$screen-width:'. $screen_width.';';
			// $compiler->suffix .= '$alias-width:'.$alias_width.';';
			// $compiler->suffix .= '$next-screen-width:'.$next_screen_width.';';
			$compiler->suffix .= clips_out('media', array(
				'media'=> '@media screen and (min-width: '.$screen_width.'px) and (max-width: '.($next_screen_width - 1).'px) {', 
				'variables'=>array(
					array('variable'=>'$screen-width:'.$screen_width), 
					array('variable'=>'$alias-width:'. $alias_width)),
					array('variable'=>'$next-screen-width:'.$next_screen_width)
			), false);
		 	// $this->addPrependResolution($compiler, $screen_width);
			foreach($compiler->sasses as $s) {
				$s = str_replace('.scss', '', $s);
				$basename = basename($s);
				$name = str_replace('/', '_', $s);
				if($basename == $name) {
					$this->addSection($basename, $compiler, $screen_width.','.$alias_width.','.$next_screen_width);
				}else {
					$names = explode('/', $s);
					$index = array_search('scss', $names);
					if ($index) {
						array_splice($names, 0, $index+1);
						$name = implode('_', $names);
					}
					$this->addSection($name, $compiler, $screen_width.','.$alias_width.','.$next_screen_width);
				}
			}
			$compiler->suffix .= '}'."\n";
			// $compiler->suffix .= '@media screen and (min-width: '.$screen_width.'px) and (max-width: '.($next_screen_width - 1).'px)  {'."\n";
			// $compiler->suffix .= '$screen-width:'. $screen_width.';';
			// $compiler->suffix .= '$alias-width:'.$alias_width.';';
			// $compiler->suffix .= '$next-screen-width:'.$next_screen_width.';';
			$compiler->suffix .= clips_out('media', array(
				'media'=> '@media screen and (min-width: '.$screen_width.'px) and (max-width: '.($next_screen_width - 1).'px) {', 
				'variables'=>array(
					array('variable'=>'$screen-width:'.$screen_width), 
					array('variable'=>'$alias-width:'. $alias_width)),
					array('variable'=>'$next-screen-width:'.$next_screen_width)
			), false);
	 		$lasts = end($compiler->sasses);
			$lasts = str_replace('.scss', '', $lasts);
			$basename = basename($lasts);
			$name = str_replace('/', '_', $lasts);
			if($basename == $name) {
				$this->addModule($basename, $compiler, $screen_width.','.$alias_width.','.$next_screen_width);
			}else {
				$names = explode('/', $s);
				$index = array_search('scss', $names);
				if ($index) {
					array_splice($names, 0, $index+1);
					$name = implode('_', $names);
				}
				$this->addModule($name, $compiler, $screen_width.','.$alias_width.','.$next_screen_width);
			}
			$compiler->suffix .= '}'."\n";
			// $this->addAfterResolution($compiler, $screen_width);
		}
		$this->addAfterResponsive($compiler);
	}

	protected function addConstruct($name, $compiler, $args) {
		$the_name = 'responsive_'.$name;
		if(strpos($compiler->content, $the_name) !== FALSE) {
				$compiler->suffix .= "\t".'@include '.$the_name.'('.$args.');'."\n";
		}
	}

	protected function addModule($name, $compiler, $args) {
		$the_name = 'module_'.$name;
		if(strpos($compiler->content, $the_name) !== FALSE) {
				$compiler->suffix .= "\t".'@include '.$the_name.'('.$args.');'."\n";
		}
	}

	protected function addSection($name, $compiler, $args) {
		$the_name = 'section_'.$name;
		if(strpos($compiler->content, $the_name) !== FALSE) {
				$compiler->suffix .= "\t".'@include '.$the_name.'('.$args.');'."\n";
		}
	}

	protected function addPrependResolution($compiler, $res) {
		$the_name = 'prepend_resolution_'.$res;
		if(strpos($compiler->content, $the_name) !== FALSE) {
			$compiler->suffix .= "\t".'@include '.$the_name.'();'."\n";
		}
	}

	protected function addAppendResolution($compiler, $res) {
		$the_name = 'append_resolution_'.$res;
		if(strpos($compiler->content, $the_name) !== FALSE) {
			$compiler->suffix .= "\t".'@include '.$the_name.'();'."\n";
		}
	}

	protected function addBeforeResolution($compiler, $res) {
		$the_name = 'before_resolution_'.$res;
		if(strpos($compiler->content, $the_name) !== FALSE) {
			$compiler->suffix .= "\t".'@include '.$the_name.'();'."\n";
		}
	}

	protected function addAfterResolution($compiler, $res) {
		$the_name = 'after_resolution_'.$res;
		if(strpos($compiler->content, $the_name) !== FALSE) {
			$compiler->suffix .= "\t".'@include '.$the_name.'();'."\n";
		}
	}

	protected function addBeforeResponsive($compiler) {
		$the_name = 'before_responsive';
		if(strpos($compiler->content, $the_name) !== FALSE) {
			$compiler->suffix .= "\t".'@include '.$the_name.'();'."\n";
		}
	}

	protected function addAfterResponsive($compiler) {
		$the_name = 'after_responsive';
		if(strpos($compiler->content, $the_name) !== FALSE) {
			$compiler->suffix .= "\t".'@include '.$the_name.'();'."\n";
		}
	}

	protected function appendVariables($resolutions, $compiler) {
		if (is_array($resolutions)) {
			$result = array();
			$max = 0;
			$min = 0;

			foreach($resolutions as $k => $v) {
				$arr = null;
				if(is_string($k)) {
					$arr = array('alias' => $k, 'value' => $v);
				}
				else {
					if(is_string($v)) {
						$arr = array('alias' => $v, 'value' => $k);
					}
					else {
						$arr = array('alias' => 0, 'value' => $v);
					}
				}
				$result []= $arr;
				if($min > $arr['value'])
					$min = $arr['value'];

				if($max < $arr['value'])
					$max = $arr['value'];
			}

			$str = 'string://$min-screen-width: {{min}};
	$max-screen-width: {{max}};
	$init-min-screen-width: {{min}};
	$init-max-screen-width: {{max}};
	
	$pinet-resolutions: (
{{#resolutions}}
{{#alias}}
	({{alias}}:{{value}})
{{/alias}}
{{^alias}}
	{{value}}
{{/alias}},
{{/resolutions}}
	);
	$pinet-no-alias-resolutions: (
{{#resolutions}}
	{{value}},
{{/resolutions}}
	);
';
			$compiler->prefix .= clips_out($str, array(
				'min' => $min,
				'max' => $max,
				'resolutions' => $result
			));
		}
	}

	protected function getResolutions($compiler) {
		foreach(array('get_default', 'get_ci_config', 'clips_config') as $func) {
			$res = null;
			if($func == 'get_default') {
				$res = get_default($compiler, 'resolutions', null);
			}
			else {
				$res = call_user_func_array($func, array('resolutions', null));
			}
			if($res)
				return $res;
		}
		trigger_error('you must need resolutions, you can put in clips_config or ci_config or complier');
		return false;
	}
}
