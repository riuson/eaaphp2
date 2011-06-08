<?php

$modeTitle = "Status";

if (!function_exists('getContent')) {

	function getContent() {
		$d = date("H:i:s");
		$user = new User();
		if ($user->IsLogged())
			$userInfo = "Welcome, $username";
		else
			$userInfo = "Login";
		return "EVE server: Online, 28984 pilots<br/>Sun 5 Jun 2011 $d";
	}

}
?>
