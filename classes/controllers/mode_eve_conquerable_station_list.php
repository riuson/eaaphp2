<?php

/*
 * Visitors list.
 */
if (!class_exists("controller_mode_eve_conquerable_station_list")) {

	Class controller_mode_eve_conquerable_station_list Extends Controller_Base {

		static function title() {
			return "Conquerable stations";
		}

		static function limited() {
			return false;
		}

		function loginRequired() {
			return false;
		}

		function process() {

			$showTemplate = true;
			if (isset($_POST['sender']) && $_POST['sender'] == "datatables") {
				$showTemplate = false;
			}

			if (!$showTemplate) {
				$model = new model_mode_eve_conquerable_station_list($this->registry);
				$model->prepare();
				$this->registry['template']->set('jsonOutput', $model->getJsonOutput());
			}

			$this->registry['template']->set('showTemplate', $showTemplate);
			return $this->registry['template']->show('mode_eve_conquerable_station_list');
		}

	}

}
?>
