<?php

/*
 * Corp Account Balance model.
 */
if (!class_exists("model_mode_corp_account_balance")) {

	Class model_mode_corp_account_balance Extends Model_Base {

		private $jsonOutput;

		function prepare() {

			$this->registry['user']->getMasterData($data);

			$aColumns = array('api_account_balance.accountKey', 'divisionName', 'api_account_balance.balance', 'api_account_balance.balanceUpdated');

			/* Indexed column (used for fast and accurate table cardinality) */
			$sIndexColumn = "recordId";

			/* DB table to use */
			$sTable = "api_account_balance";
			$joinCondition = " LEFT JOIN api_corporation_divisions on (api_account_balance.accountKey = api_corporation_divisions.accountKey and api_account_balance.accountId = api_corporation_divisions.accountId and api_corporation_divisions.type = 0)";

			$data = new Datatables_Common($this->registry, $data['accountId']);
			$this->jsonOutput = $data->process($sIndexColumn, $aColumns, $sTable, $joinCondition);
		}

		public function getJsonOutput() {
			return $this->jsonOutput;
		}

	}

}
?>
