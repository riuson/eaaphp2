<?php

$modeTitle = "Test mode";

if (!function_exists('getModeContent')) {

	function getModeContent() {
		return "
			<p class='content_header'>Test</p>
			<p>Sample</p>";
	}

}
?>