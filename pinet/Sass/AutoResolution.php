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
	   	$compiler->prefix .= ' @function site_url($url) {
			@return "'.site_url('/').'" + $url;
		}';
	   
	   	$compiler->prefix .= '@function base_path($path) {
	        @return "'.FCPATH.' + $path";
		}';
	   $compiler->prefix .= '$screen_width: 0;
	$alias_width: 0;
	$next-screen-width: 0;
	';

		$resolutions = $this->getResolutions($compiler);
		$this->appendVariables($resolutions, $compiler);
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
			// $compiler->suffix .= '@media screen and (min-width: '.$screen_width.'px) {'."\n";
			// $compiler->suffix .= '$screen-width:'. $screen_width.';';
		 // 	$compiler->suffix .= '$alias-width:'.$alias_width.';';
			$compiler->suffix = clips_out('media', array(
				'media'=> '@media screen and (min-width: '.$screen_width.'px) {', 
				'variables'=>array(array('variable'=>'$screen-width:'.$screen_width), array('variable'=>'$alias-width:'. $alias_width))
			));
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
			$compiler->suffix .= '@media screen and (min-width: '.$screen_width.'px) and (max-width: '.($next_screen_width - 1).'px)  {'."\n";
			$compiler->suffix .= '$screen-width:'. $screen_width.';';
		 	$compiler->suffix .= '$alias-width:'.$alias_width.';';
		 	$compiler->suffix .= '$next-screen-width:'.$next_screen_width.';';
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
			$compiler->suffix .= '@media screen and (min-width: '.$screen_width.'px) and (max-width: '.($next_screen_width - 1).'px)  {'."\n";
			$compiler->suffix .= '$screen-width:'. $screen_width.';';
		 	$compiler->suffix .= '$alias-width:'.$alias_width.';';
		 	$compiler->suffix .= '$next-screen-width:'.$next_screen_width.';';
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

	        $firstkey = key($resolutions);
	        $firstres = $resolutions[$firstkey];
	        if (is_numeric($firstkey) && is_string($firstres) && !is_numeric($firstres) ) {
	             $compiler->prefix .= "\n".'$init-min-screen-width: '.$firstkey.';';
	             $compiler->prefix .= "\n".'$min-screen-width: '.$firstkey.';';
	        }
	        else {
	             $compiler->prefix .= "\n".'$init-min-screen-width: '.$firstres.';';
	             $compiler->prefix .= "\n".'$min-screen-width: '.$firstres.';';
	        }

	        $lastkey = array_pop(array_keys($resolutions));;
	        $lastres = $resolutions[$lastkey];
	        if (is_numeric($lastkey) && is_string($lastres) && !is_numeric($lastres) ) {
	             $compiler->prefix .= "\n".'$init-max-screen-width: '.$lastkey.';';
	             $compiler->prefix .= "\n".'$max-screen-width: '.$lastkey.';';
	        }
	        else {
	             $compiler->prefix .= "\n".'$init-max-screen-width: '.$lastres.';';
	             $compiler->prefix .= "\n".'$max-screen-width: '.$lastres.';';
	        }

	        $compiler->prefix .= "\n".'$pinet-resolutions: (';
	        foreach ($resolutions as $k => $rs) {
	             if (is_numeric($k) && is_string($rs) && !is_numeric($rs) ) {
	                  $compiler->prefix .=  '('.$k.':'.$rs.')';
	             } else if (is_string($k) && !is_numeric($k)) {
	                  $compiler->prefix .=  '('.$rs.':'.$k.')';
	             }
	             else {
	                  $compiler->prefix .= '('.$rs.')';
	             }
	             if($rs != end($resolutions)) {
	                  $compiler->prefix .= ",";
	             }
	        }
	        $compiler->prefix .= ');';

	        $compiler->prefix .= "\n".'$pinet-no-alias-resolutions: (';
	        foreach ($resolutions as $k => $rs) {
	             if (is_numeric($k) && is_string($rs) && !is_numeric($rs) ) {
	                  $compiler->prefix .=  $k;
	             } else if (is_string($k) && !is_numeric($k)) {
	                  $compiler->prefix .=  $rs;
	             }
	             else {
	                  $compiler->prefix .= $rs;
	             }
	             if($rs != end($resolutions)) {
	                  $compiler->prefix .= ",";
	             }
	        }
	        $compiler->prefix .= ');';
	   }
	}

	protected function getResolutions($compiler) {
		if (isset($compiler->resolutions)) {
			return $compiler->resolutions;
		}
		else if (get_ci_config('resolutions')) {
			return get_ci_config('resolutions');
		} 
		else if (clips_config('resolutions')) {
			return clips_config('resolutions');
		}
		else {
			trigger_error('you must need resolutions, you can put in clips_config or ci_config or complier');
			return false;
		}
	}

}