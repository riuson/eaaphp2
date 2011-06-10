<?php

/*
 * Logout processor.
 */

if (!class_exists("controller_sys_logout")) {

	Class controller_sys_logout Extends Controller_Base {

		static function title() {
			return "Logout";
		}

		function process() {

			$this->registry['user']->logout();
			$logoutSuccess = !$this->registry['user']->isLogged();

			$this->registry['template']->set('logoutSuccess', $logoutSuccess);
			$this->registry['template']->show('sys_logout');
		}

	}

}
?>
