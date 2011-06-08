<?php

$modeTitle = "About";

if (!function_exists('getContent')) {

	function getContent() {
		return "
<p>About</p>
<p>Used documentation:</p>
<ul>
	<li><a href='http://myeve.eve-online.com/api/doc/default.asp'>EVE API Documentation Index</a></li>
	<li><a href='http://wiki.eve-id.net/'>EVE-Development Network</a></li>
	<li><a href='http://htmlbook.ru/'>HTML/CSS handbook</a></li>
</ul>
Project repository at <a href='https://github.com/riuson/eaaphp2'>github</a>
<script>
	function bindContent()
	{
	}
</script>
";
	}

}
?>