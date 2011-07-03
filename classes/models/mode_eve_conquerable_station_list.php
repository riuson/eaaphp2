<?php

/*
 * Visitors list model.
 */
if (!class_exists("model_mode_eve_conquerable_station_list")) {

	Class model_mode_eve_conquerable_station_list Extends Model_Base {

		private $jsonOutput;
		private $corpInfo;

		function prepareDataTable() {

			$aColumns = array('stationName', 'solarSystemName', 'corporationId', 'corporationName');
			$sIndexColumn = "stationId";
			$sTable = "api_outposts";
			$joinCondition = "LEFT JOIN mapSolarSystems ON ( api_outposts.`solarSystemId` = mapSolarSystems.`solarSystemId` )";

			$data = new Datatables_Common($this->registry);
			$this->jsonOutput = $data->process($sIndexColumn, $aColumns, $sTable, $joinCondition);
		}

		public function getJsonOutput() {
			return $this->jsonOutput;
		}

		public function prepareCorpInfo($corporationId) {

			$api = new Api_Corp_Corporation_Sheet($this->registry);
			$api->getCorporationInfo($corporationId, $commonInfo);
			$this->corpInfo = $commonInfo;
		}

		public function getCorpInfo() {
			return $this->corpInfo;
		}

	}

}
?>
