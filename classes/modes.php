<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Modes {

	private $allModes;
	private $freeModes;
	private $limitedModes;
	private $availableModes;

	public function __construct($user) {

		// collect mode controllers
		$files = array();
		foreach (glob(site_path . "classes/controllers/mode_*.php") as $filename) {
			array_push($files, $filename);
		}

		// collect titles and mode names
		$this->allModes = array();
		$this->freeModes = array();
		$this->limitedModes = array();
		$this->availableModes = array();

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
			else
				$this->limitedModes[$title] = $mode;
		}

		// exclude modes not available for this user
		$modesAvailableToUser = array();
		if ($user->isLogged()) {
			$modesAvailableToUser = $user->filterAvailableModes($this->modes);
		}
		$this->availableModes = array_merge($this->freeModes, $modesAvailableToUser);
	}

	public function getModes() {
		return $this->modes;
	}

	public function getFreeModes() {
		return $this->freeModes;
	}

	public function getLimitedModes() {
		return $this->limitedModes;
	}

	public function getAvailableModes() {
		return $this->availableModes;
	}

}
?>
