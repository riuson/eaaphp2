<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('DIRSEP', DIRECTORY_SEPARATOR);

$site_path = realpath(dirname(__FILE__) . DIRSEP) . DIRSEP;
define('site_path', $site_path);

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
?>