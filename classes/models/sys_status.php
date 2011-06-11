<?php

/*
 * Status model.
 */
if (!class_exists("model_sys_status")) {

	Class model_sys_status Extends Model_Base {

		private $status;

		function prepare() {

			$this->status = array();

			$user = $this->registry['user'];

			$username = $user->UserName();
			if ($user->IsLogged()) {
				$sys_callback = "logout";
			} else {
				$sys_callback = "login";
			}

			$this->status['server_online'] = true;
			$this->status['server_pilots'] = 28982;
			$this->status['server_time'] = date("H:i:s");
			$this->status['user_logged'] = $user->IsLogged();
			$this->status['user_name'] = $user->UserName();
			$this->status['callback'] = $sys_callback;
		}

		public function getStatus() {

			return $this->status;
		}

	}

}
?>
