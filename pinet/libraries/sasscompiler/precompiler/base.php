<?php
	class Base_Precompiler {
		public function prefix($compiler) {
			$compiler->prefix .= ' @function site_url($url) {
	@return "'.site_url('/').'" + $url;
}
';
			$compiler->prefix .= '@function base_path($path) {
				@return "'.FCPATH.' + $path";
}
';
			// if (isset($compiler->resolutions) && is_array($compiler->resolutions)) {
			// 	$compiler->prefix .= '$_resolutions: (';
			// 	foreach ($compiler->resolutions as $k => $rs) {
			// 		$compiler->prefix .= ''.$rs;
			// 		if($k < count($compiler->resolutions) - 1 ) {
			// 			$compiler->prefix .= ",";
			// 		}		
			// 	}	
			// 	$compiler->prefix .= ');';
			// }
		}
	}
