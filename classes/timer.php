<?php

/*
 * Timer for measuring performance.
 */

class Timer {

	private $timer = false;
	private $time = false;
	public $keepAliveText = '<!-- -->';

	function start() {
		$this->time = false;
		$this->timer = microtime(true);
	}

	function stop() {
		if ($this->timer == false) {
			trigger_error('You should start timer first');
			return false;
		}
		$this->time = microtime(true) - $this->timer;
		$this->timer = false;
		return $this->getTime();
	}

	function getTime() {
		return round($this->time * 1000) / 1000;
	}

	function keepAlive() {
		echo($this->keepAliveText);
		flush();
		ob_flush();
	}

}
?>
