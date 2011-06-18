<?php

/*
 * Corporation Sheet.
 */

if (!class_exists("controller_mode_corp_corporation_sheet")) {

	Class controller_mode_corp_corporation_sheet Extends Controller_Base {

		static function title() {
			return "My Corporation";
		}

		static function limited() {
			return true;
		}

		function loginRequired() {
			return true;
		}

		function process() {

			//print_r($_POST);
			$model = new model_mode_corp_corporation_sheet($this->registry);
			$model->prepare();

			$this->registry['template']->set('corpInfo', $model->getCorpInfo());
			$this->registry['template']->set('divisions', $model->getDivisions());
			$this->registry['template']->set('walletDivisions', $model->getWalletDivisions());

			$result = $this->registry['template']->show('mode_corp_corporation_sheet');

			return $result;
		}

	}
}
?>
