<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Modes {

	private $modes;
	private $freeModes;

	public function __construct() {

		// collect mode controllers
		$files = array();
		foreach (glob(site_path . "classes/controllers/mode_*.php") as $filename) {
			array_push($files, $filename);
		}

		// collect titles and mode names
		$this->modes = array();
		$this->freeModes = array();
		foreach ($files as $filename) {
			// load mode controller file
			include_once "$filename";
			// get mode name
			preg_match('/mode_.+(?=\.php)/i', $filename, $matches);
			$mode = $matches[0];
			// get controller class name
			$className = "controller_" . $mode;
			// get mode title by static method of controller
			$title = call_user_func(array($className, 'title'));
			$this->modes[$title] = $mode;
			// get mode access rights by static method of controller
			$limited = call_user_func(array($className, 'limited'));
			if (!$limited)
				$this->freeModes[$title] = $mode;
		}
	}

	public function getModes() {
		return $this->modes;
	}

	public function getFreeModes() {
		return $this->freeModes;
	}

}
?>
