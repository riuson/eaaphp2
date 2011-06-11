<?php

/*
 * Status controller.
 */

Class controller_sys_status Extends Controller_Base {

	function process() {

		$model = new model_sys_status($this->registry);
		$model->prepare();
		$this->registry['template']->set('status', $model->getStatus());
		return $this->registry['template']->show('sys_status');
	}

}
?>
