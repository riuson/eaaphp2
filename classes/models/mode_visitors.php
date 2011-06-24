<?php

/*
 * Visitors list model.
 */
if (!class_exists("model_mode_visitors")) {

	Class model_mode_visitors Extends Model_Base {

		private $jsonOutput;

		function prepare() {

			$aColumns = array('_date_', 'address', 'agent', 'login', 'uri');
			$sIndexColumn = "recordId";
			$sTable = "api_visitors";


			$data = new Datatables_Common($this->registry);
			$this->jsonOutput = $data->process($sIndexColumn, $aColumns, $sTable);
		}

		public function getJsonOutput() {
			return $this->jsonOutput;
		}

	}

}
?>
