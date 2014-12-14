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
               $compiler->prefix .= '$screen_width: 0;
$alias_width: 0;

@function strip-units($val) {
     @return ($val / ($val * 0 + 1));
}

@function res($n) {
     @return $n / strip-units($max_screen_width) * $screen_width;
}
';

               if (isset($compiler->resolutions) && is_array($compiler->resolutions)) {
                    $compiler->prefix .= "\n".'$pinet_resolutions: (';
                    foreach ($compiler->resolutions as $k => $rs) {
                         if (is_string($k)) {
                              $compiler->prefix .=  '('.$k.':'.$rs.')';
                         }else {
                              $compiler->prefix .= '('.$rs.')';
                         }
                         if($rs != end($compiler->resolutions)) {
                              $compiler->prefix .= ",";
                         }
                    }
                    $compiler->prefix .= ');';
               }
          }
     }
