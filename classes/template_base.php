<?php

/*
 * Template base class.
 */

Abstract Class Template_Base {

	protected $vars;

	function __construct($vars) {
		$this->vars = $vars;
	}

	abstract function getView();
}
?>
