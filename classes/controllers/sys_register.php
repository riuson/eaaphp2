<?php

/*
 * Register processor.
 */

if (!class_exists("controller_sys_register")) {

	Class controller_sys_register Extends Controller_Base {

		static function title() {
			return "Register";
		}

		function loginRequired() {
			return false;
		}

		function process() {

			$model = new model_sys_register($this->registry);
			$model->prepare();
			$data = $model->getData();

			$registerSuccess = false;

			if ($this->registry['user']->register($data['username'], $data['password'], $data['email'], $data['characterName'], $data['apikeyOwner'], $data['userId'], $data['apiKey'], $data['characterId'], $data['masterName'])) {
				$this->registry['user']->login($data['username'], $data['password']);
				if ($this->registry['user']->isLogged()) {

					$registerSuccess = true;
				}
			}

			$this->registry['template']->set('data', $data);
			if ($registerSuccess) {
				$result = $this->registry['template']->show('sys_register_success');
			} else {
				$result = $this->registry['template']->show('sys_register');
			}

			return $result;
		}

	}

}
?>
