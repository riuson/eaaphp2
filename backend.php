<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('DIRSEP', DIRECTORY_SEPARATOR);

$site_path = realpath(dirname(__FILE__) . DIRSEP) . DIRSEP;
define('site_path', $site_path);

function __autoload($class_name) {

	$class_name = strtolower($class_name);

	if (preg_match("/^(?:controller_)((mode|sys)_.+)$/i", $class_name, $matches) > 0) {
		$file = site_path . "classes" . DIRSEP . "controllers" . DIRSEP . $matches[1] . ".php";
	} else {
		$file = site_path . "classes" . DIRSEP . $class_name . ".php";
	}

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
$registry['router'] = $router;

$user = User::createUser($registry);
$registry['user'] = $user;

$modes = new Modes();
$registry['modes'] = $modes;

$router->delegate();
?>