<?php

/**
 * Handle login, access rights, cookies.
 *
 * @author vladimir
 */
class User {

	private $accountId;
	private $logged;

	public function __construct() {
		$this->logged = false;
		$this->accountId = -1;

		// check login
	}

	public function IsLogged() {
		return $this->logged;
	}

}
?>
