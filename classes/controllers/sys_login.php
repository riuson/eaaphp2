<?php

/*
 * Login processor.
 */

if (!class_exists("controller_sys_login")) {

	Class controller_sys_login Extends Controller_Base {

		static function title() {
			return "Login";
		}

		function loginRequired() {
			return false;
		}

		function process() {

			$firstAttempt = true;
			if (isset($_POST["username"])) {
				$username = $_POST["username"];
				$firstAttempt = false;
			}
			else
				$username = "";

			if (isset($_POST["password"])) {
				$password = $_POST["password"];
				$firstAttempt = false;
			}
			else
				$password = "";

			$this->registry['user']->login($username, $password);
			$loginSuccess = $this->registry['user']->isLogged();

			$loginFailed = false;
			if (!$firstAttempt && !$loginSuccess)
				$loginFailed = true;

			$this->registry['template']->set('username', $username);
			$this->registry['template']->set('login_success', $loginSuccess);

			if ($loginSuccess) {
				$this->registry['template']->set('loginFailed', false);
				$result = $this->registry['template']->show('sys_login_success');
			} else {
				$this->registry['template']->set('loginFailed', $loginFailed);
				$result = $this->registry['template']->show('sys_login');
			}

			return $result;
		}

	}

}
?>
