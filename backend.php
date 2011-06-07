<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

include_once "classes/settings.php";
//print_r($_POST);
// process mode request
if (isset($_POST["mode"]) && !empty($_POST["mode"])) {
	$mode = $_POST["mode"];

	// check mode name, contains only letters, not more 20
	if (preg_match("/^[a-z]+$/", $mode) > 0 && strlen($mode) <= 20) {

		$modefile = Settings::ClassesPath() . "mode_{$mode}.php";

		// list of mode's files (mode_*.php)
		$modes = array();
		foreach (glob(Settings::ClassesPath() . "mode_*.php") as $filename) {
			array_push($modes, $filename);
		}

		// if mode exists, call it
		if (in_array($modefile, $modes)) {
			include_once "$modefile";
			echo getModeContent();
		} else {
			echo "$mode not found";
		}
	} else {
		echo "$mode incorrect mode";
	}
} else
// process status request
if (isset($_POST["status"])) {
	include_once Settings::ClassesPath() . "status.php";
	echo getStatusContent();
} else
// process menu request
if (isset($_POST["menu"]) && !empty($_POST["menu"])) {
	include_once Settings::ClassesPath() . "menu.php";
	echo getMenuContent($_POST["menu"]);
} else {
	echo "bad request";
}
?>