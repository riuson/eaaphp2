<?php

/*
 * Corporation wallet transactions list.
 */
if (!class_exists("controller_mode_corp_wallet_transactions")) {

	Class controller_mode_corp_wallet_transactions Extends Controller_Base {

		static function title() {
			return "Wallet Transactions";
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
				$model = new model_mode_corp_wallet_transactions($this->registry);
				$model->prepare();
				$this->registry['template']->set('jsonOutput', $model->getJsonOutput());
			}

			$this->registry['template']->set('showTemplate', $showTemplate);
			return $this->registry['template']->show('mode_corp_wallet_transactions');
		}

	}

}
?>
