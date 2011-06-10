<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('DIRSEP', DIRECTORY_SEPARATOR);

$site_path = realpath(dirname(__FILE__) . DIRSEP) . DIRSEP;
define('site_path', $site_path);

//define ('site_path', "/home/vladimir/Документы/eaaphp2/");
//echo site_path;
function __autoload($class_name) {

	$filename = strtolower($class_name) . '.php';

	$file = site_path . 'classes' . DIRSEP . $filename;

	if (file_exists($file) == false) {

		return false;
	}

	include ($file);
}

session_start();

// variable's storage
$registry = new Registry();

$db = new Database();
$registry['db'] = $db;

$template = new Template($registry);
$registry['template'] = $template;

$router = new Router($registry);
//echo site_path . "controllers";
$router->setPath(site_path . "classes/controllers");
$registry['router'] = $router;

$user = User::createUser($registry);
$registry['user'] = $user;

$modes = new Modes();
$registry['modes'] = $modes;

$router->delegate();

//print_r($_SESSION);
// process mode request
/*
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
 */
?>