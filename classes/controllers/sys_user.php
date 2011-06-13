<?php

/*
 * Change user registration data.
 */

if (!class_exists("controller_sys_user")) {

	Class controller_sys_user Extends Controller_Base {

		static function title() {
			return "User account";
		}

		function loginRequired() {
			return true;
		}

		function process() {

			//print_r($_POST);
			if ($this->registry['user']->isLogged()) {

				$model = new model_sys_user($this->registry);
				$model->prepare();
				$data = $model->getData();
				//print_r($data);
				$updateSuccess = false;

				if ($this->registry['user']->modify($data['password'], $data['email'], $data['characterName'], $data['apikeyOwner'], $data['userId'], $data['apiKey'], $data['characterId'], $data['master'])) {
					//$this->registry['user']->login($data['username'], $data['password']);

					$updateSuccess = true;
					//}
				}

				$firstAttempt = $data['firstAttempt'];

				$this->registry['user']->getAccountData($data);
				$data['firstAttempt'] = $firstAttempt;
				$data['updateSuccess'] = $updateSuccess;
				$data['password'] = "";

				if (empty($data['master']))
					$data['apikeyOwner'] = 'master';
				else
					$data['apikeyOwner'] = 'slave';

				$this->registry['template']->set('data', $data);

				$result = $this->registry['template']->show('sys_user');
			}
			else
				$result = $this->registry['template']->show('sys_error');

			return $result;
		}

	}

}
?>
