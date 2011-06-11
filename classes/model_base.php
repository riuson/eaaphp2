<?php

/*
 * Model base class.
 */

Abstract Class Model_Base {

	protected $registry;

	function __construct($registry) {
		$this->registry = $registry;
	}
}
?>
