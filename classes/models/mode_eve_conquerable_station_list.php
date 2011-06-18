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

			/* Indexed column (used for fast and accurate table cardinality) */
			$sIndexColumn = "stationId";

			/* DB table to use */
			$sTable = "api_outposts";

			/*
			 * Paging
			 */
			$sLimit = "";
			if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
				$sLimit = "LIMIT " . $this->registry['db']->escape($_POST['iDisplayStart']) . ", " .
						$this->registry['db']->escape($_POST['iDisplayLength']);
			}


			/*
			 * Ordering
			 */
			if (isset($_POST['iSortCol_0'])) {
				$sOrder = "ORDER BY  ";
				for ($i = 0; $i < intval($_POST['iSortingCols']); $i++) {
					if ($_POST['bSortable_' . intval($_POST['iSortCol_' . $i])] == "true") {
						$sOrder .= $aColumns[intval($_POST['iSortCol_' . $i])] . "
				 	" . $this->registry['db']->escape($_POST['sSortDir_' . $i]) . ", ";
					}
				}

				$sOrder = substr_replace($sOrder, "", -2);
				if ($sOrder == "ORDER BY") {
					$sOrder = "";
				}
			}


			/*
			 * Filtering
			 * NOTE this does not match the built-in DataTables filtering which does it
			 * word by word on any field. It's possible to do here, but concerned about efficiency
			 * on very large tables, and MySQL's regex functionality is very limited
			 */
			$sWhere = "";
			if ($_POST['sSearch'] != "") {
				$sWhere = "WHERE (";
				for ($i = 0; $i < count($aColumns); $i++) {
					$sWhere .= $aColumns[$i] . " LIKE '%" . $this->registry['db']->escape($_POST['sSearch']) . "%' OR ";
				}
				$sWhere = substr_replace($sWhere, "", -3);
				$sWhere .= ')';
			}

			/* Individual column filtering */
			for ($i = 0; $i < count($aColumns); $i++) {
				if ($_POST['bSearchable_' . $i] == "true" && $_POST['sSearch_' . $i] != '') {
					if ($sWhere == "") {
						$sWhere = "WHERE ";
					} else {
						$sWhere .= " AND ";
					}
					$sWhere .= $aColumns[$i] . " LIKE '%" . $this->registry['db']->escape($_POST['sSearch_' . $i]) . "%' ";
				}
			}


			/*
			 * SQL queries
			 * Get data to display
			 */
			$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
		FROM $sTable LEFT JOIN mapSolarSystems ON ( api_outposts.`solarSystemId` = mapSolarSystems.`solarSystemId` )
		$sWhere
		$sOrder
		$sLimit
	";
			$rResult = $this->registry['db']->query($sQuery) or die($this->registry['db']->getErrorMessage());

			/* Data set length after filtering */
			$sQuery = "
		SELECT FOUND_ROWS()
	";
			$rResultFilterTotal = $this->registry['db']->query($sQuery) or die($this->registry['db']->getErrorMessage());
			$aResultFilterTotal = $rResultFilterTotal->fetch_array();
			$iFilteredTotal = $aResultFilterTotal[0];

			/* Total data set length */
			$sQuery = "
		SELECT COUNT(" . $sIndexColumn . ")
		FROM   $sTable  LEFT JOIN mapSolarSystems ON ( api_outposts.`solarSystemId` = mapSolarSystems.`solarSystemId` )
	";
			$rResultTotal = $this->registry['db']->query($sQuery) or die($this->registry['db']->getErrorMessage());
			$aResultTotal = $rResultTotal->fetch_array();
			$iTotal = $aResultTotal[0];


			/*
			 * Output
			 */
			$output = array(
				"sEcho" => intval($_POST['sEcho']),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
			);

			while ($aRow = $rResult->fetch_array()) {
				$row = array();
				for ($i = 0; $i < count($aColumns); $i++) {
					if ($aColumns[$i] == "version") {
						/* Special output formatting for 'version' column */
						$row[] = ($aRow[$aColumns[$i]] == "0") ? '-' : $aRow[$aColumns[$i]];
					} else if ($aColumns[$i] != ' ') {
						/* General output */
						$row[] = $aRow[$aColumns[$i]];
					}
				}
				$output['aaData'][] = $row;
			}

			$this->jsonOutput = json_encode($output);
		}

		public function getJsonOutput() {
			return $this->jsonOutput;
		}

		public function prepareCorpInfo($corporationId) {

			$api = new Api_Corp_Corporation_Sheet($this->registry, $this->registry['user']);
			$api->getCorporationInfo($corporationId, $commonInfo);
			$this->corpInfo = $commonInfo;
		}

		public function getCorpInfo() {
			return $this->corpInfo;
		}

	}

}
?>
