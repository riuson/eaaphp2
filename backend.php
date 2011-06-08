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
			echo getContent();
		} else {
			echo "$mode not found";
		}
	} else {
		echo "$mode incorrect mode";
	}
} else
// process status request
if (isset($_POST["sys"]) && !empty($_POST["sys"])) {
	$func = $_POST["sys"];

	// check mode name, contains only letters, not more 20
	if (preg_match("/^[a-z]+$/", $func) > 0 && strlen($func) <= 20) {

		$funcfile = Settings::ClassesPath() . "sys_{$func}.php";

		// list of mode's files (mode_*.php)
		$funcs = array();
		foreach (glob(Settings::ClassesPath() . "sys_*.php") as $filename) {
			array_push($funcs, $filename);
		}

		// if mode exists, call it
		if (in_array($funcfile, $funcs)) {
			include_once "$funcfile";
			echo getContent();
		} else {
			echo "$func not found";
		}
	} else {
		echo "$func incorrect function";
	}
} else {
	echo "bad request";
}
?>