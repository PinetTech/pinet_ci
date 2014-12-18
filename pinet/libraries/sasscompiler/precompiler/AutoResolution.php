<?php
	class AutoResolution_Precompiler {

		public function suffix($compiler) {
			if(!isset($compiler->resolutions))
				return;

			$this->addBeforeResponsive($compiler);
			foreach($compiler->resolutions as $k => $r) {
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

				$this->addBeforeResolution($compiler, $screen_width);
				$compiler->suffix .= '@media screen and (min-width: '.$screen_width.'px){'."\n";
				$compiler->suffix .= '$screen-width:'. $screen_width.';';
			 	$compiler->suffix .= '$alias-width:'.$alias_width.';';
				foreach($compiler->sasses as $s) {
					$s = str_replace('.scss', '', $s);
					$basename = basename($s);
					$name = str_replace('/', '_', $s);
					if($basename == $name) {
						$this->addConstruct($basename, $compiler, $screen_width.','.$alias_width);
					}else {
						$this->addConstruct($name, $compiler, $screen_width.','.$alias_width);
					}
				}
				$compiler->suffix .= '}'."\n";
				$this->addAfterResolution($compiler, $screen_width);
			}
			$this->addAfterResponsive($compiler);
		}

		protected function addConstruct($name, $compiler, $args) {
			$the_name = 'responsive_'.$name;
			if(strpos($compiler->content, $the_name) !== FALSE) {
					$compiler->suffix .= "\t".'@include '.$the_name.'('.$args.');'."\n";
			}
		}

		protected function addBeforeResolution($compiler, $res) {
			$the_name = 'before_responsive_'.$res;
			if(strpos($compiler->content, $the_name) !== FALSE) {
				$compiler->suffix .= "\t".'@include '.$the_name.'();'."\n";
			}
		}

		protected function addAfterResolution($compiler, $res) {
			$the_name = 'after_responsive_'.$res;
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

	}
