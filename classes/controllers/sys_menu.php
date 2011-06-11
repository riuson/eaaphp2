<?php

/*
 * Status controller.
 */

Class controller_sys_menu Extends Controller_Base {

	function process() {
		$modes = $this->registry['modes'];

		if (isset($_POST['item']) && !empty($_POST['item'])) {
			$item = $_POST['item'];
		} else {
			$item = "sys_about";
		}

		$this->registry['template']->set('item', $item);
		$this->registry['template']->set('modes', $modes->getAvailableModes());
		return $this->registry['template']->show('sys_menu');
	}

}
?>
