<?php

/*
 * Registration model.
 */
if (!class_exists("model_sys_register")) {

	Class model_sys_register Extends Model_Base {

		private $data;

		function prepare() {

			$this->data = array();
			$this->data['firstAttempt'] = true;

			if (isset($_POST["username"])) {
				$this->data['username'] = $_POST["username"];
				$this->data['firstAttempt'] = false;
			}
			else
				$this->data['username'] = "";

			if (isset($_POST["password"])) {
				$this->data['password'] = $_POST["password"];
				$this->data['firstAttempt'] = false;
			}
			else
				$this->data['password'] = "";

			if (isset($_POST["email"])) {
				$this->data['email'] = $_POST["email"];
				$this->data['firstAttempt'] = false;
			}
			else
				$this->data['email'] = "";

			if (isset($_POST["characterName"])) {
				$this->data['characterName'] = $_POST["characterName"];
				$this->data['firstAttempt'] = false;
			}
			else
				$this->data['characterName'] = "";

			if (isset($_POST["apikeyOwner"])) {
				$this->data['apikeyOwner'] = $_POST["apikeyOwner"];
				$this->data['firstAttempt'] = false;
			}
			else
				$this->data['apikeyOwner'] = "slave";

			if (isset($_POST["userId"])) {
				$this->data['userId'] = $_POST["userId"];
				$this->data['firstAttempt'] = false;
			}
			else
				$this->data['userId'] = "";

			if (isset($_POST["apiKey"])) {
				$this->data['apiKey'] = $_POST["apiKey"];
				$this->data['firstAttempt'] = false;
			}
			else
				$this->data['apiKey'] = "";

			if (isset($_POST["characterId"])) {
				$this->data['characterId'] = $_POST["characterId"];
				$this->data['firstAttempt'] = false;
			}
			else
				$this->data['characterId'] = "";

			if (isset($_POST["masterName"])) {
				$this->data['masterName'] = $_POST["masterName"];
				$this->data['firstAttempt'] = false;
			}
			else
				$this->data['masterName'] = "";
		}

		public function getData() {

			return $this->data;
		}

	}

}
?>
