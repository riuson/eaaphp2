<?php

/*
 * Check, find and load controller.
 */

Class Router {

	private $registry;

	function __construct($registry) {
		$this->registry = $registry;
	}

	function delegate() {

		// Analize call
		$this->getController($controllerClassName);
		// Create controller (__autoload)
		$controller = new $controllerClassName($this->registry);
		// get data
		$controller->process();
	}

	private function getController(&$controller) {

		$call = (empty($_POST['call'])) ? '' : $_POST['call'];

		// if no incoming data, set default mode
		if (empty($call)) {
			$call = 'mode_about';
		}

		// check for invalid symbols
		if (preg_match("/[^a-zA-Z_\d]/", $call) > 0)
		{
			$call = "sys_error";
		}

		$controller = "controller_" . $call;
	}

}
?>
