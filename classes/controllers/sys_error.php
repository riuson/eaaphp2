<?php

/*
 * Error mode.
 */

if (!class_exists("controller_sys_error")) {

	Class controller_sys_error Extends Controller_Base {

		static function title() {
			return "Error";
		}

		function process() {

			if (isset($_POST["call"]))
				$call = $_POST["call"];
			else
				$call = " ";
			$this->registry['template']->set('call', $call);
			$this->registry['template']->show('sys_error');
		}

	}

}
?>
