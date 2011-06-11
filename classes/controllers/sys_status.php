<?php

/*
 * Status controller.
 */

Class controller_sys_status Extends Controller_Base {

	function process() {
		$user = $this->registry['user'];

		$username = $user->UserName();
		if ($user->IsLogged()) {
			$sys_callback = "logout";
		} else {
			$sys_callback = "login";
		}
		//$user->logVisitor();

		$this->registry['template']->set('server_online', true);
		$this->registry['template']->set('server_pilots', 28982);
		$this->registry['template']->set('server_time', date("H:i:s"));
		$this->registry['template']->set('user_logged', $user->IsLogged());
		$this->registry['template']->set('user_name', $user->UserName());
		$this->registry['template']->set('callback', $sys_callback);

		return $this->registry['template']->show('sys_status');
	}

}
?>
