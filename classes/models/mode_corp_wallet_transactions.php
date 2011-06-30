<?php

/*
 * Corporation wallet transaction model.
 */
if (!class_exists("model_mode_corp_wallet_transactions")) {

	Class model_mode_corp_wallet_transactions Extends Model_Base {

		private $jsonOutput;

		function prepare() {

			$this->registry['user']->getMasterData($data);

			$aColumns = array('accountKey', 'transId', '_date_', 'typeName', 'quantity', 'price', 'characterName', 'clientName', 'stationName', 'transactionType');

			/* Indexed column (used for fast and accurate table cardinality) */
			$sIndexColumn = "recordId";

			/* DB table to use */
			$sTable = "api_wallet_transactions";
			//$joinCondition = "LEFT JOIN api_reftypes on (api_wallet_journal.refTypeId = api_reftypes.refTypeId)";

			$data = new Datatables_Common($this->registry, $data['accountId']);
			$this->jsonOutput = $data->process($sIndexColumn, $aColumns, $sTable);//, $joinCondition);
		}

		public function getJsonOutput() {
			return $this->jsonOutput;
		}

	}

}
?>
