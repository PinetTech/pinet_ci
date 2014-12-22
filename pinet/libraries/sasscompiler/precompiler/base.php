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
';

// two support config
// $config['resolutions'] = array(320, 480, 640);
// $config['resolutions'] = array(320=>'device1', 480, 640);
// $config['resolutions'] = array('device1'=>320, 480, 640);


               if (isset($compiler->resolutions) && is_array($compiler->resolutions)) {
                    reset($compiler->resolutions);
                    $firstkey = key($compiler->resolutions);
                    $firstres = $compiler->resolutions[$firstkey];
                    if (is_numeric($firstkey) && is_string($firstres) && !is_numeric($firstres) ) {
                         $compiler->prefix .= "\n".'$min-screen-width: '.$firstkey.';';
                    }
                    else {
                         $compiler->prefix .= "\n".'$min-screen-width: '.$firstres.';';
                    }

                    $compiler->prefix .= "\n".'$pinet-resolutions: (';
                    foreach ($compiler->resolutions as $k => $rs) {
                         if (is_numeric($k) && is_string($rs) && !is_numeric($rs) ) {
                              $compiler->prefix .=  '('.$k.':'.$rs.')';
                         } else if (is_string($k) && !is_numeric($k)) {
                              $compiler->prefix .=  '('.$rs.':'.$k.')';
                         }
                         else {
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
