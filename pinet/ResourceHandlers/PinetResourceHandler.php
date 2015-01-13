<?php namespace Pinet\ResourceHandlers; in_array(__FILE__, get_included_files()) or exit("No direct sript access allowed");

class PinetResourceHandler extends \Clips\BaseResourceHandler {
	protected function getFile($uri) {
		$p = str_replace("pinet://", "", $uri);

		foreach(array(APPPATH, 'pinet/') as $pre) {
			$path = FCPATH.$pre.$p;
			if(file_exists($path))
				return $path;
		}
		return null;
	}

	public function openStream($uri) {
		$file = $this->getFile($uri);
		if($file)
			return fopen($file);
		return null;
	}

	public function contents($uri) {
		$file = $this->getFile($uri);
		if($file)
			return file_get_contents($file);
		return null;
	}
}
