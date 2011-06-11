<?php

/*
 * Menu controller.
 */

Class controller_sys_menu Extends Controller_Base {

	function process() {

		$model = new model_sys_menu($this->registry);
		$model->prepare();
		
		$this->registry['template']->set('items', $model->getItems());
		return $this->registry['template']->show('sys_menu');
	}

}
?>
