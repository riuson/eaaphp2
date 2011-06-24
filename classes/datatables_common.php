<?php

/*
 * Common server-side backend processor for jquery.datatables
 */

class Datatables_Common {

	private $registry;

	function __construct($registry) {
		$this->registry = $registry;
	}

	function process($sIndexColumn, $aColumns, $sTable, $joinCondition = '') {

		//$aColumns = array('allianceId', 'shortName', 'name', 'memberCount', 'startDate');

		/* Indexed column (used for fast and accurate table cardinality) */
		//$sIndexColumn = "allianceId";

		/* DB table to use */
		//$sTable = "api_alliances";

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

		$postValues = "";
		foreach ($_POST as $key => $value) {
			$postValues .= "$key - $value, ";
		}
		$this->registry['db']->log($postValues);
		$rangeSeparator = "";
		if (isset($_POST['sRangeSeparator']))
			$rangeSeparator = $_POST['sRangeSeparator'];
		/* Individual column filtering */
		for ($i = 0; $i < count($aColumns); $i++) {
			if ($_POST['bSearchable_' . $i] == "true" && $_POST['sSearch_' . $i] != '') {
				if ($sWhere == "") {
					$sWhere = "WHERE ";
				} else {
					$sWhere .= " AND ";
				}
				$columnFilterValue = $this->registry['db']->escape($_POST['sSearch_' . $i]);
				// check for values range
				if (!empty($rangeSeparator) && strstr($columnFilterValue, $rangeSeparator)) {
					// get min and max
					preg_match("/(.*)\~(.*)/", $columnFilterValue, $columnFilterRangeMatches);
					// get filter
					if (empty($columnFilterRangeMatches[1]) && empty($columnFilterRangeMatches[2]))
						$sWhere .= " 0 = 0 ";
					else if (!empty($columnFilterRangeMatches[1]) && !empty($columnFilterRangeMatches[2]))
						$sWhere .= $aColumns[$i] . " BETWEEN '" . $columnFilterRangeMatches[1] . "' and '" . $columnFilterRangeMatches[2] . "' ";
					else if (empty($columnFilterRangeMatches[1]) && !empty($columnFilterRangeMatches[2]))
						$sWhere .= $aColumns[$i] . " < '" . $columnFilterRangeMatches[2] . "' ";
					else if (!empty($columnFilterRangeMatches[1]) && empty($columnFilterRangeMatches[2]))
						$sWhere .= $aColumns[$i] . " > '" . $columnFilterRangeMatches[1] . "' ";
				} else {
					$sWhere .= $aColumns[$i] . " LIKE '%" . $columnFilterValue . "%' ";
				}
			}
		}


		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
		FROM $sTable $joinCondition
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
		FROM   $sTable $joinCondition
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

		return json_encode($output);
	}

}
?>
