<?php

/*
 * Corp Account Balance model.
 */
if (!class_exists("model_mode_corp_account_balance")) {

	Class model_mode_corp_account_balance Extends Model_Base {

		private $jsonOutput;

		function prepare() {


			$aColumns = array('accountKey', 'balance', 'balanceUpdated');

			/* Indexed column (used for fast and accurate table cardinality) */
			$sIndexColumn = "recordId";

			/* DB table to use */
			$sTable = "api_account_balance";
			$joinCondition = "";

			$data = new Datatables_Common($this->registry);
			$this->jsonOutput = $data->process($sIndexColumn, $aColumns, $sTable, $joinCondition);
		}

		public function getJsonOutput() {
			return $this->jsonOutput;
		}

	}

}
?>
