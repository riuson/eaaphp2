<?php

/*
 * Visitors list model.
 */
if (!class_exists("model_mode_visitors")) {

	Class model_mode_visitors Extends Model_Base {

		private $jsonOutput;

		function prepare() {

			$aColumns = array('_date_', 'address', 'agent', 'login', 'uri');

			/* Indexed column (used for fast and accurate table cardinality) */
			$sIndexColumn = "recordId";

			/* DB table to use */
			$sTable = "api_visitors";

			/* Database connection information */
			$gaSql['user'] = "eauser";
			$gaSql['password'] = "RSN6s5nLHQhG5DSA";
			$gaSql['db'] = "eaaphp2db";
			$gaSql['server'] = "localhost";


			/*			 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
			 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
			 * no need to edit below this line
			 */

			/*
			 * MySQL connection
			 */
			$gaSql['link'] = mysql_pconnect($gaSql['server'], $gaSql['user'], $gaSql['password']) or
					die('Could not open connection to server');

			mysql_select_db($gaSql['db'], $gaSql['link']) or
					die('Could not select database ' . $gaSql['db']);


			/*
			 * Paging
			 */
			$sLimit = "";
			if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
				$sLimit = "LIMIT " . mysql_real_escape_string($_POST['iDisplayStart']) . ", " .
						mysql_real_escape_string($_POST['iDisplayLength']);
			}


			/*
			 * Ordering
			 */
			if (isset($_POST['iSortCol_0'])) {
				$sOrder = "ORDER BY  ";
				for ($i = 0; $i < intval($_POST['iSortingCols']); $i++) {
					if ($_POST['bSortable_' . intval($_POST['iSortCol_' . $i])] == "true") {
						$sOrder .= $aColumns[intval($_POST['iSortCol_' . $i])] . "
				 	" . mysql_real_escape_string($_POST['sSortDir_' . $i]) . ", ";
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
					$sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' OR ";
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
					$sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_POST['sSearch_' . $i]) . "%' ";
				}
			}


			/*
			 * SQL queries
			 * Get data to display
			 */
			$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
	";
			$rResult = mysql_query($sQuery, $gaSql['link']) or die(mysql_error());

			/* Data set length after filtering */
			$sQuery = "
		SELECT FOUND_ROWS()
	";
			$rResultFilterTotal = mysql_query($sQuery, $gaSql['link']) or die(mysql_error());
			$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
			$iFilteredTotal = $aResultFilterTotal[0];

			/* Total data set length */
			$sQuery = "
		SELECT COUNT(" . $sIndexColumn . ")
		FROM   $sTable
	";
			$rResultTotal = mysql_query($sQuery, $gaSql['link']) or die(mysql_error());
			$aResultTotal = mysql_fetch_array($rResultTotal);
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

			while ($aRow = mysql_fetch_array($rResult)) {
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

	}

}
?>
