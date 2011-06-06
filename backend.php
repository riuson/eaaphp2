<?php

//print_r($_POST);
if (isset($_POST["mode"])) {
	$mode = $_POST["mode"];

	// check mode name, contains only letters, not more 20
	if (preg_match("/^[a-z]+$/", $mode) > 0 && strlen($mode) <= 20) {

		$modefile = "classes/mode_{$mode}.php";

		// list of mode's files (mode_*.php)
		$modes = array();
		foreach (glob("classes/mode_*.php") as $filename) {
			array_push($modes, $filename);
		}

		// if mode exists, call it
		if (in_array($modefile, $modes)) {
			include_once "$modefile";
			echo getModeContent();
		} else {
			echo $modefile;
		}
	}
}
?>