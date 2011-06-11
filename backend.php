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
	} else if (preg_match("/^(?:template_)((mode|sys)_.+)$/i", $class_name, $matches) > 0) {

		$file = site_path . "classes" . DIRSEP . "templates" . DIRSEP . $matches[1] . ".php";
	} else if (preg_match("/^(?:model_)((mode|sys)_.+)$/i", $class_name, $matches) > 0) {

		$file = site_path . "classes" . DIRSEP . "models" . DIRSEP . $matches[1] . ".php";
	} else if (preg_match("/^(api_.*)/i", $class_name, $matches) > 0) {

		$file = site_path . "classes" . DIRSEP . "api" . DIRSEP . $matches[1] . ".php";
	} else {

		$file = site_path . "classes" . DIRSEP . $class_name . ".php";
	}

	if (file_exists($file) == false) {
		return false;
	}

	include ($file);
}

session_start();

date_default_timezone_set("Etc/Universal");

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

$modes = new Modes($user);
$registry['modes'] = $modes;

echo $router->delegate();

// api testing

//$api = new Api_Base($registry);
$params = array();
$params["version"] = "2";
//$api->request("/server/ServerStatus.xml.aspx", $params);
?>