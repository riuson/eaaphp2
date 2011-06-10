<?php

/*
 * Check, find and load controller.
 */

Class Router {

	private $registry;
	private $path;
	private $args = array();

	function __construct($registry) {
		$this->registry = $registry;
	}

	function setPath($path) {

		$path = trim($path, '\\');
		$path .= DIRSEP;
		//echo $path;
		if (is_dir($path) == false) {
			throw new Exception('Invalid controller path: `' . $path . '`');
		}
		$this->path = $path;
	}

	function delegate() {

		// Analize path
		$this->getController($file, $controller, $action, $args);

		// File readable?
		//echo $file;
		if (is_readable($file) == false) {
			die(' 404 file Not Found ');
		}

		include ($file);

		// Create controller
		$class = 'controller_' . $controller;
		//echo $class;
		$controller = new $class($this->registry);
		// Действие доступно?
		//if (is_callable(array($controller, $action)) == false) {
		//	die('404 controller/action Not Found');
		//}

		// Do action
		//$controller->$action();

		// get data
		$controller->process();
	}

	private function getController(&$file, &$controller, &$action, &$args) {

		$route = (empty($_POST['call'])) ? '' : $_POST['call'];

		//echo $route;
		if (empty($route)) {
			$route = 'mode_about';
		}

		// Получаем раздельные части
		//$route = trim($route, '/\\');
		//$parts = explode('/', $route);
		// Находим правильный контроллер
		$cmd_path = $this->path;
		$controller = $route;
		/*
		  foreach ($parts as $part) {

		  $fullpath = $cmd_path . $part;

		  // Есть ли папка с таким путём?
		  if (is_dir($fullpath)) {
		  $cmd_path .= $part . DIRSEP;
		  array_shift($parts);
		  continue;
		  }

		  // Находим файл
		  if (is_file($fullpath . '.php')) {
		  $controller = $part;
		  array_shift($parts);
		  break;
		  }
		  }
		 */

		if (empty($controller)) {
			$controller = 'mode_about';
		};

		// Получаем действие
		//$action = array_shift($parts);
		//if (empty($action)) {
//			$action = 'Sys_Status';
		//}
		$file = $cmd_path . $controller . '.php';
		$args = "1"; //$parts;
	}

}
?>
