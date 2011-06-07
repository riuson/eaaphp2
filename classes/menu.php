<?php

function getMenuContent($menuName) {
	// list of mode's files (mode_*.php)
	$modes = array();
	foreach (glob("classes/mode_*.php") as $filename) {
		array_push($modes, $filename);
	}

	$result = "<p>Menu</p>
		<ul>";
	foreach ($modes as $filename) {
		include_once "$filename";
		//$title = "$filename";//getModeTitle();
		$title = $modeTitle;

		preg_match('/(?<=mode_).+(?=\.php)/i', $filename, $matches);
		$mode = $matches[0];

		$result .= "<li><a href='$mode'>$title</a></li>";
	}
	$result .= "</ul>";

	return $result;
}
?>