<?php

/*
 * Visitors list model.
 */
if (!class_exists("model_mode_visitors")) {

	Class model_mode_visitors Extends Model_Base {

		private $log;

		function prepare() {

			$qr = $this->registry['db']->query("select count(*) as _count_ from api_visitors;");
			$row = $qr->fetch_assoc();
			$recordsCount = $row["_count_"];
			$qr->close();

			$result = array();

			$qr = $this->registry['db']->query("SELECT * FROM `api_visitors` group by address, date(_date_) order by _date_ desc limit 20;");

			while ($row = $qr->fetch_assoc()) {
				$sub = array();
				$sub["_date_"] = $row["_date_"];
				$sub["address"] = $row["address"];
				$sub["agent"] = $row["agent"];

				array_push($result, $sub);
			}
			$qr->close();

			$this->log = $result;
		}

		public function getLog() {

			return $this->log;
		}

	}

}
?>
