<?php

/*
 * Visitors list model.
 */
if (!class_exists("model_mode_visitors")) {

	Class model_mode_visitors Extends Model_Base {

		private $log;
		private $page;
		private $start;
		private $total;

		function prepare($page) {

			// get total rows count
			$qr = $this->registry['db']->query("select count(*) as _count_ from api_visitors;");
			$row = $qr->fetch_assoc();
			$this->total = $row["_count_"];
			$qr->close();

			// store start index
			if ($page >= 0 && $page < $this->total)
				$this->page = $page;
			else
				$this->page = 0;

			$result = array();

			$this->start = 20 * $this->page;
			$qr = $this->registry['db']->query("SELECT * FROM `api_visitors` order by _date_ desc limit {$this->start}, 20;");

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

		public function getPage() {
			return $this->page;
		}

		public function getStart() {
			return $this->start;
		}

		public function getTotal() {
			return $this->total;
		}

	}

}
?>
