<?php

/*
 * Check, find and load controller.
 */

Class Router {

	private $registry;
	private $path;
	private $args = array();

	function __construct($registry) {
		$this->registry = $registry;
	}

	function setPath($path) {

		$path = trim($path, '\\');
		$path .= DIRSEP;
		if (is_dir($path) == false) {
			throw new Exception('Invalid controller path: `' . $path . '`');
		}
		$this->path = $path;
	}

	function delegate() {

		// Analize path
		$this->getController($file, $controllerClassName);

		// File readable?
		if (is_readable($file) == false) {
			die(' 404 file Not Found ');
		}

		include ($file);

		// Create controller
		$controller = new $controllerClassName($this->registry);
		// get data
		$controller->process();
	}

	private function getController(&$file, &$controller) {

		$call = (empty($_POST['call'])) ? '' : $_POST['call'];

		if (empty($call)) {
			$call = 'mode_about';
		}

		if (empty($call)) {
			$call = 'mode_about';
		};

		$controller = "controller_" . $call;

		// get controller file name
		$file = $this->path . $call . '.php';
	}

}
?>
