<?php
	class ThemeVariables_Precompiler {
		public function prefix($compiler) {
			if(!isset($compiler->theme)) {
				$compiler->theme = 'default';
			}

			$compiler->addSass('themes/'.$compiler->theme.'/variables', 0);
		}
	}
