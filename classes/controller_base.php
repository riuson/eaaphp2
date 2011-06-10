<?php

/*
 * Controller base class.
 */

Abstract Class Controller_Base {

	protected $registry;

	function __construct($registry) {
		$this->registry = $registry;
		//echo "hello";
	}

	abstract function process();
}
?>
