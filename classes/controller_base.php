<?php

/*
 * Controller base class.
 */

Abstract Class Controller_Base {

	protected $registry;

	function __construct($registry) {
		$this->registry = $registry;
	}

	abstract function process();
}
?>
