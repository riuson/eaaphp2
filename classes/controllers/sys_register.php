<?php

/*
 * Register processor.
 */

if (!class_exists("controller_sys_register")) {

	Class controller_sys_register Extends Controller_Base {

		static function title() {
			return "Register";
		}

		function process() {

			$model = new model_sys_register($this->registry);
			$model->prepare();
			$data = $model->getData();

			$this->registry['template']->set('data', $data);

			if ($data['loginSuccess']) {
				$result = $this->registry['template']->show('sys_login_success');
			} else {
				$result = $this->registry['template']->show('sys_register');
			}

			return $result;
		}

	}

}
?>
