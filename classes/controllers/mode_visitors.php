<?php

/*
 * Visitors list.
 */
if (!class_exists("controller_mode_visitors")) {

	Class controller_mode_visitors Extends Controller_Base {

		static function title() {
			return "Visitors list";
		}

		static function limited() {
			return true;
		}

		function process() {

			// check user access rights here
			$accessGranted = true;

			if ($accessGranted) {

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

				$this->registry['template']->set('log', $result);
				return $this->registry['template']->show('mode_visitors');
			}
		}

	}

}
?>
