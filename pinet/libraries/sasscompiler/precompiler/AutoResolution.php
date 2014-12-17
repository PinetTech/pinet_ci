<?php
	class AutoResolution_Precompiler {

		public function suffix($compiler) {
			if(!isset($compiler->resolutions))
				return;

			foreach($compiler->resolutions as $k => $r) {
				$compiler->suffix .= '@media screen and (min-width: '.$r.'px){'."\n";
				 if (is_numeric($k) && is_string($r) && !is_numeric($r) ) {
				 	$compiler->suffix .= '$screen-width:'. $k.';';
				 	$compiler->suffix .= '$alias-width:'.$r.';';
				 	$screen_width = $k;
				 	$alias_width =$r;
				 }
				 else if (is_numeric($k) && is_numeric($r)) {
					$compiler->suffix .= '$screen-width:'. $r.';';
				 	$compiler->suffix .= '$alias-width:0;';
				 	$screen_width = $r;
				 	$alias_width = 0;
				 }
				 else if (is_string($k) && !is_numeric($k)) {
				 	$compiler->suffix .= '$screen-width:'. $r.';';
				 	$compiler->suffix .= '$alias-width:'.$k.';';
				 	$screen_width = $r;
				 	$alias_width =$k;
				 }
				 else {
				 	$compiler->suffix .= '$screen-width:'. $k.';';
				 	$compiler->suffix .= '$alias-width:0;';
				 	$screen_width = $k;
				 	$alias_width =0;
				 }
				foreach($compiler->sasses as $s) {
					$s = str_replace('.scss', '', $s);
					$basename = basename($s);
					$name = str_replace('/', '_', $s);
					if($basename != $name) {
						$this->addConstruct($basename, $compiler, $screen_width.','.$alias_width);
					}
					$this->addConstruct($name, $compiler, $screen_width.','.$alias_width);
				}
				$compiler->suffix .= '}'."\n";
			}
		}

		protected function addConstruct($name, $compiler, $args) {
			$the_name = 'responsive_'.$name;
			if(strpos($compiler->content, $the_name) !== FALSE) {
					$compiler->suffix .= "\t".'@include '.$the_name.'('.$args.');'."\n";
			}
		}
	}
