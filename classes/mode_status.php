<?php

$modeTitle = "Status";

if (!function_exists('getModeContent')) {

	function getModeContent() {
		$d = date("H:i:s");
		return "EVE server: Online, 28984 pilots<br/>Sun 5 Jun 2011 4:44:19<br/><a href='123'>$d</a>";
	}

}
?>
