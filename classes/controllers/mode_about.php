<?php

/*
 * About project.
 */
if (!class_exists("controller_mode_about")) {

	Class controller_mode_about Extends Controller_Base {

		static function title() {
			return "About";
		}

		static function limited() {
			return false;
		}

		function loginRequired() {
			return false;
		}

		function process() {

			return $this->registry['template']->show('mode_about');
		}

	}

}
?>
