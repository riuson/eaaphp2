<?php

/*
 * View template.
 */

Class Template {

	private $registry;
	private $vars = array();

	function __construct($registry) {

		$this->registry = $registry;
	}

	function set($varname, $value, $overwrite=false) {

		if (isset($this->vars[$varname]) == true AND $overwrite == false) {

			trigger_error('Unable to set var `' . $varname . '`. Already set, and overwrite not allowed.', E_USER_NOTICE);

			return false;
		}

		$this->vars[$varname] = $value;

		return true;
	}

	function remove($varname) {

		unset($this->vars[$varname]);

		return true;
	}

	function show($name) {

		$templateClassName = "template_" . $name;
		$template = new $templateClassName($this->vars);
		return $template->getView();
	}

}
?>
