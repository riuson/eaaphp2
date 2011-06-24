<?php

/*
 * Alliance list model.
 */
if (!class_exists("model_mode_eve_alliance_list")) {

	Class model_mode_eve_alliance_list Extends Model_Base {

		private $jsonOutput;

		function prepareDataTable() {

			$aColumns = array('allianceId', 'shortName', 'name', 'memberCount', 'startDate');
			$sIndexColumn = "allianceId";
			$sTable = "api_alliances";

			$data = new Datatables_Common($this->registry);
			$this->jsonOutput = $data->process($sIndexColumn, $aColumns, $sTable);
		}

		public function getJsonOutput() {
			return $this->jsonOutput;
		}

	}

}
?>
