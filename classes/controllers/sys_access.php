<?php

/*
 * Access settings controller.
 */

if (!class_exists("controller_sys_access")) {

	Class controller_sys_access Extends Controller_Base {

		static function title() {
			return "Access settings";
		}

		function process() {

			$model = new model_sys_access($this->registry);
			$model->prepare();

			$this->registry['template']->set('users', $model->getUsers());
			$this->registry['template']->set('limitedModes', $model->getLimitedModes());
			$this->registry['template']->set('selectedUser', $model->getSelectedUser());
			$result = $this->registry['template']->show('sys_access');

			return $result;
		}

	}

}
?>
