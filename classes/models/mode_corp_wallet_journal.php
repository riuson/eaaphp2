<?php

/*
 * Visitors list model.
 */
if (!class_exists("model_mode_corp_wallet_journal")) {

	Class model_mode_corp_wallet_journal Extends Model_Base {

		private $jsonOutput;

		function prepare() {

			$this->registry['user']->getMasterData($data);

			$aColumns = array('accountKey', 'refId', '_date_', 'refTypeName', 'ownerName1', 'ownerName2', 'argName1', 'amount', 'balance', 'reason');

			/* Indexed column (used for fast and accurate table cardinality) */
			$sIndexColumn = "recordId";

			/* DB table to use */
			$sTable = "api_wallet_journal";
			$joinCondition = "LEFT JOIN api_reftypes on (api_wallet_journal.refTypeId = api_reftypes.refTypeId)";

			$data = new Datatables_Common($this->registry, $data['accountId']);
			$this->jsonOutput = $data->process($sIndexColumn, $aColumns, $sTable, $joinCondition);
		}

		public function getJsonOutput() {
			return $this->jsonOutput;
		}

	}

}
?>
