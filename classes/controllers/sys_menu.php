<?php

/*
 * Status controller.
 */

Class controller_sys_menu Extends Controller_Base {

	function process() {
		$user = $this->registry['user'];
		$modes = $this->registry['modes'];

		// exclude modes not available for this user
		$modesAvailableToUser = array();
		if ($user->isLogged()) {
			$modesAvailableToUser = $user->filterAvailableModes($modes->getModes());
		}
		$freeModes = $modes->getFreeModes();

		$displayModes = array_merge($freeModes, $modesAvailableToUser);

		if (isset($_POST['item']) && !empty($_POST['item'])) {
			$item = $_POST['item'];
		} else {
			$item = "sys_about";
		}

		$this->registry['template']->set('item', $item);
		$this->registry['template']->set('modes', $displayModes);
		$this->registry['template']->show('sys_menu');
	}

}
?>
