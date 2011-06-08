<?php

$modeTitle = "Test mode";

if (!function_exists('getContent')) {

	function getContent() {
		return "
			<p class='content_header'>Test</p>
			<p>Sample</p>";
	}

}
?>