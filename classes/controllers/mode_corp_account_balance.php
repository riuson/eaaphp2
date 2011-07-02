<?php

/*
 * Account Balance.
 */

if (!class_exists("controller_mode_corp_account_balance")) {

	Class controller_mode_corp_account_balance Extends Controller_Base {

		static function title() {
			return "Account Balance";
		}

		static function limited() {
			return true;
		}

		function loginRequired() {
			return true;
		}

		function process() {

			$showTemplate = true;
			if (isset($_POST['sender']) && $_POST['sender'] == "datatables") {
				$showTemplate = false;
			}

			if (!$showTemplate) {
				$model = new model_mode_corp_account_balance($this->registry);
				$model->prepare();
				$this->registry['template']->set('jsonOutput', $model->getJsonOutput());
			}

			$this->registry['template']->set('showTemplate', $showTemplate);
			return $this->registry['template']->show('mode_corp_account_balance');
		}

	}
}
?>
