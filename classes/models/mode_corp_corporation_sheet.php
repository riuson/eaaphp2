<?php

/*
 * User account setup model.
 */
if (!class_exists("model_mode_corp_corporation_sheet")) {

	Class model_mode_corp_corporation_sheet Extends Model_Base {

		private $corpInfo;
		private $divisions;
		private $walletDivisions;

		function prepare() {

			$api = new Api_Corp_Corporation_Sheet($this->registry, $this->registry['user']);
			$api->getCorporationInfoPrivate($commonInfo, $divisions, $walletDivisions);
			$this->corpInfo = $commonInfo;
			$this->divisions = $divisions;
			$this->walletDivisions = $walletDivisions;
		}

		public function getCorpInfo() {
			return $this->corpInfo;
		}

		public function getDivisions() {
			return $this->divisions;
		}

		public function getWalletDivisions() {
			return $this->walletDivisions;
		}

	}

}
?>
